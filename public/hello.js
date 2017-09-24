$(document).ready(function() {
    $.ajax({
        url: "http://localhost/Kod/public/posts/all"
    }).then(function(data) {
       $('.greeting-id').append(data.id);
       $('.greeting-content').append(data.content);
    });
});