var msg_tab = null;
$(document).on('click', '.inbox_messsage', function() {
    var get_convo = $(this).find('label').attr('id');
    msg_tab = $(this);
    $.ajax({
        type: "POST",
        url: "code.php",
        data: "get_convo="+get_convo,
        success: function (response) {
            $('.convo table').html(response);
        },
        complete:function(){
            $('.convo').scrollTop($('.convo')[0].scrollHeight);
        }
    });
    $('.convo_name').find('label').text($(this).find('label').text());
    $('.convo_name').attr('id', get_convo);
    
});

setInterval(() => {
    //   if($('.receive_message').last().attr('id')!=undefined){
       
           $.ajax({
               type: "POST",
               url: "code.php",
               data: "receive_id="+$('.receive_message').last().attr('id'),
               success: function (response) {
                   $('.convo table').append(response);
                   // msg_tab.click(); 
                   var get_convo = msg_tab.find('label').attr('id');
                   $.ajax({
                       type: "POST",
                       url: "code.php",
                       data: "get_convo="+get_convo,
                       success: function (response) {
                           $('.convo table').html(response);
                       }
                   });
                   $('.convo_name').find('label').text(msg_tab.find('label').text());
                   $('.convo_name').attr('id', get_convo);
               }
           });
     //  }
   }, 2000);

$('#type').keyup(function() {
    if($(this).val() == '' || $(this).val() == ' ') {
        $('.send-msg').prop('disabled', true);
    }else{
        $('.send-msg').prop('disabled', false);
    }
});
$('.send-msg').on('click', function(){
    $('.send-msg').prop('disabled', true);
    var msg = $('#type').val();
    $.ajax({
        type: "POST",
        url: "code.php",
        data: "msg="+msg,
        success: function (response) {
            if (response=="failure" || response=="Failure") {
                alert("Failure");
            }else {
               msg_tab.click(); 
               $('#type').val('');
            }
        },
        complete:function(){
            $('.convo').scrollTop($('.convo')[0].scrollHeight);
        }
    });
});
$('.search').keyup(function (e) { 
    var text = $(this).val();
    if(text != '' || text != ' '){
        $.ajax({
            type: "GET",
            url: "code.php",
            data: "text="+text,
            success: function (response) {
                $('.in_list').html(response);
            }
        });
    }
});

$('.logout').on('click',function(){
    $.ajax({
        type: "POST",
        url: "code.php",
        data: "logout="+true,
        success: function (response) {
          if (response==true) {
            window.location.replace("http://chat-system.atwebpages.com/");
          }else{
              alert('Could not LOG OUT');
          }
        }
    });
});