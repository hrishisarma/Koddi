
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koddi-Home</title>
    <!-- Bootstrap -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./fr.css">
</head>
<body>
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Koddi</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submits" class="btn btn-defaults">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li id="ds"><a href="/Kod/public/logout">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
</div>
<div class="container">
    <main class="row">
        <section class="col-sm-6">
            <h2>Tweets</h2>
            <hr />
            <div id="ulposts">
            </div>
        </section>
        <aside class="col-sm-6">
            <h2>Add Tweet</h2>
            <hr />
            <div id="frmCreatePost">
                <div class="form-group">
                    <label for="comment">Post New Tweet</label>
                    <textarea class="form-control" name="txtcomment" id="txtcomment" rows="3" maxlength="140"></textarea>
                </div>

                <div id="divErr" class="alert alert-danger" role="alert" hidden>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <label id="lblErrMsg" hidden/>
                </div>

                <button id="btnSubmit" class="btn btn-primary">Submit</button>
            </div>
        </aside>

    </main>
</div>
<script src="./frontend1.js"></script>
</body>
</html>