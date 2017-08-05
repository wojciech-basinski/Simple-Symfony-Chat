$(document).ready(function() {
    function sendMessage() {
        var text = $('#message-text').val();

        var params = {
            'text' : text
        };
        $.ajax({
            type: "POST",
            dataType: "json",
            url: sendPath,
            data: params
        }).done(function(msg){
            $('#message-text').val('');
            //TODO: check if message is good and show them
        });
    }

    //sending new message when clicked on button
    $('body').on('click', '#send', function(){
        sendMessage();
    });

    //sending new message when pressed enter
    $('body').on('keypress', '#message-text' , function( event ) {
        if (event.which == 13 ) {
            sendMessage();
        }
    });
});