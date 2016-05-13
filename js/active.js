$(function(){
    $('#sidebar a').click(function(){
        $('#sidebar .active').removeClass('active'); // remove the class from the currently selected
        $(this).addClass('active'); // add the class to the newly clicked link
    });
});

/**
 * Add a new chat message
 *
 * @param {string} message
 */
function send_message(message) {
  $.ajax({
    url: 'send_msg.php',
    method: 'post',
    data: {msg: message},
    success: function(data) {
      $('#chatMsg').val('');
      get_messages();
    }
  });
}

$('textarea').keypress(
    function(e){
        if (e.keyCode == 13) {
            var msg = $(this).val();
			$(this).val('');
			if(msg!='')
			$('<div class="msg_b">'+msg+'</div>').insertBefore('.msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
        }
    });
