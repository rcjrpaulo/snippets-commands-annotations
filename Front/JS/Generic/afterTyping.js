// execute function after user stops typing
var typingTimer;                //timer identifier
var doneTypingInterval = 5000;  //time in ms (5 seconds)

$('#myInput').keyup(function(){
    clearTimeout(typingTimer);
    if ($('#myInput').val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
});

function doneTyping () {
    //do something
}