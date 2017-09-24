<?php


require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;


$app = new Silex\Application();
$app['debug'] = true;

$app->after(function (Request $request, Response $response) {
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
    });

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => 'sample',
        'user'   => 'root',
        'host'     => 'localhost',
        'port'     => 3306,
        'password' => 'dugi'
    ),
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
########### get login ################
$app->get('/', function() use($app) {
    if (null === $user = $app['session']->get('user')) {
        return $app->redirect('/Kod/public/login.php');
    }
    else return $app->redirect('/Kod/public/home.php');
});

########### get register ################
$app->get('/register', function() use($app) {
    if (null === $user = $app['session']->get('user')) {
        return $app->redirect('/Kod/public/register.php');
    }
    else return $app->redirect('/Kod/public/home.php');});

########### get logout ################
$app->get('/logout', function () use ($app) {
        $app['session']->clear();
        return $app->redirect('/Kod/public/login.php');

});

########### Retrieve posts ################
$app->get('/posts/all',function() use ($app) {

$sql = "SELECT * FROM posts";
$posts = $app['db']->fetchAll($sql); 
return json_encode($posts);
});

########### Register Users ################
$app->post('/register', function (Request $request) use ($app) {
    $post = array(
        'name' => $request->request->get('name'),
        'email'  => $request->request->get('email'),
        'password'  => $request->request->get('password'),

    );
    $name=$post['name'];
    $password=$post['password'];

    $sth = $app['db']->prepare("SELECT * FROM users WHERE name = ? and password = ?");
    $sth->bindValue(1, $name, PDO::PARAM_STR,50);
    $sth->bindValue(2, $password, PDO::PARAM_STR,40);
    $sth->execute();
    $user = $sth->fetchAll();
    if(!$user) {
        $app['db']->insert('users', $post);
        return $app->redirect('/Kod/public/login.php');
    }
    else return $app->redirect('/Kod/public/register.php');
});

########### Login Users ################
$app->post('/login', function (Request $request) use ($app) {
    $post = array(
        'name' => $request->request->get('name'),
        'password'  => $request->request->get('password'),
    );

    $name=$post['name'];
    $password=$post['password'];

    $sth = $app['db']->prepare("SELECT * FROM users WHERE name = ? and password = ?");
    $sth->bindValue(1, $name, PDO::PARAM_STR,50);
    $sth->bindValue(2, $password, PDO::PARAM_STR,40);
    $sth->execute();
    $user = $sth->fetchAll();
    if($user)
    { 
        $app['session']->set('user', array('name' => $name));
        return $app->redirect('/Kod/public/home.php');
    }
    else {
        $stat = array(
            'Status' => 'Failed',
            'Message' => 'Invalid Username/Password combination'        
        );
        return $app->redirect('/Kod/public/login.php');
    }

});

########### Enter posts ################
$app->post('/insert', function (Request $request) use ($app) {
    $user = $app['session']->get('user');
    $sender=$user["name"];
    $post = array(
        'post' => $request->request->get('post'),
        'sender'  => $sender       
    );

    $app['db']->insert('posts', $post);
    $sql = "SELECT * FROM posts";
    $posts = $app['db']->fetchAll($sql); 
    return json_encode($posts);
});

$app->run();