$(document).ready(function(){
        // get data with ajax
        setInterval(function(){
            $.get('default/visitor.php', function(data) {
                var visitOld = $('#w-visitor').html();
                if (visitOld < data){
                    alertify.success('<i class="fa fa-user"></i> One visitor enter to library.');
                }
            });
        }, 3000);
});