$(document).ready(function() {
    function sendMessage() {
        var text = $('#message-text').val();
        if (text === '') {
            return;
        }
        var params = {
            'text' : text
        };
        $('#message-text').val('');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: sendPath,
            data: params
        }).done(function(msg){
            //TODO: check if message is good and show them
            if (msg === false) {
                $('#messages-box').append('<div class="message-error">An error occurred while sending message.</div>')
            } else {
                $('#messages-box').append('<div class="message">' + text + '</div>')
            }
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