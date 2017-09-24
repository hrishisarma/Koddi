(function ($){
    $(document).ready(function(){
        $("#btnSubmit").click(updatePost);
        setInterval(function(){ getAllPosts(); }, 2000);
    });
    function updatePost() {
        var comment = $("#txtcomment").val();
        var post_object = {
            "post" : comment
        };
        $("#txtcomment").val("");
        createPosts(post_object);
    }
    function createPosts(postdata){
        var list = document.getElementById("ulposts");
        list.innerHTML = '';
        $.post("http://localhost/Kod/public/insert",postdata,getAllPosts);  
    }  
    function getAllPosts(Response){
        $.get('http://localhost/Kod/public/posts/all', function(res){
            var data = [];
            data = res;
            generateList(JSON.parse(res));
        });
    }  
    function generateList(collection){
        var list = document.getElementById("ulposts");
        list.innerHTML = '';

        for(var i=0;i<collection.length;i++){
            var post_li = document.createElement('div');
            var post_div = document.createElement('div');
            var item_h2 = document.createElement('h4');
            var item_text = document.createElement('h4');
            var item_username = document.createElement('h4');
            var item_date = document.createElement('label');


            item_text.innerText = collection[i].post  ;
            item_username.innerText = 'User : ' +  collection[i].sender  ;
            var item_div = document.createElement('div');

            item_div.appendChild(item_text);
            item_div.appendChild(item_username);
            if(i%2 == 0){
                item_div.setAttribute('class', 'evenchild');
            }else{
                item_div.setAttribute('class', 'oddchild');
            }
            item_h2.appendChild(item_div);
            post_div.appendChild(item_h2);
            post_li.appendChild(post_div);
            list.appendChild(post_li);
        }
    };
    var form_post = $("#frmCreatePost");
    
    function showErrorMessage(message_str) {
        $("#divErr").removeClass('hidden');
        $("#lblErrMsg").removeClass('hidden');
        $("#lblErrMsg").text(message_str);
    }
    function hideErrorMessage(message_str) {
        $("#divErr").addClass('hidden');
        $("#lblErrMsg").addClass('hidden');
    }
})(jQuery);
