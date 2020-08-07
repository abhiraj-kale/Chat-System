var msg_tab = null;
var receiver_id= null;
$(document).on('click', '.inbox_messsage', function() {
    var get_convo = $(this).find('label').attr('id');
    receiver_id = get_convo;
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
    
    $('.convo_name').find('label').first().text($(this).find('label').first().text());
    $('.convo_name').attr('id', get_convo);
    if (receiver_id!=null) {
        $.ajax({
            type: "POST",
            url: "code.php",
            data: "set_seen="+receiver_id,
            success: function (response) {
                $('.unread_lists').html(response);
            }
        });    
   }
});

setInterval(() => {
    //   if($('.receive_message').last().attr('id')!=undefined){
       
           $.ajax({
               type: "POST",
               url: "code.php",
               data: "receive_id="+$('.receive_message').last().attr('id'),
               success: function (res) {
                
                   $('.convo table').append(res);
                   // msg_tab.click(); 
                   if(msg_tab.find('label') && msg_tab.find('label').length>0){
                        var get_convo = msg_tab.find('label').attr('id');
                        $.ajax({
                            type: "POST",
                            url: "code.php",
                            data: "get_convo="+get_convo,
                            success: function (response) {
                                $('.convo table').html(response);
                                
                            }
                        });
                   }
                   if(res!=""){
                    $('.convo').scrollTop($('.convo')[0].scrollHeight);
                 }
               }
           });
           //
           $.ajax({
               type: "POST",
               url: "code.php",
               data: "get_online="+$('.convo_name').attr('id'),
               success: function (response) {
                $('.convo_name').find('label').last().text(response);
               }
           });

     //  }
           
           $.ajax({
               type: "POST",
               url: "code.php",
               data: "get_seen="+true,
               async:true,
               success: function (response) {
                $('.unread_lists').html(response);
               }
           });

                      

           
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
            $('.convo').scrollTop($('.convo')[0].scrollHeight);
        },
        complete:function(){
            $('.convo').scrollTop($('.convo')[0].scrollHeight);
        }
    });
    $('.convo').scrollTop($('.convo')[0].scrollHeight);
});
$('.search').keyup(function (e) { 
    var text = $(this).val();
    if(text != '' || text != ' '){
        $.ajax({
            type: "GET",
            url: "code.php",
            async:true,
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
          }
        }
    });
});
$(window).on('beforeunload',function(){
    $.ajax({
        type: "POST",
        url: "code.php",
        data: "logout="+true,
        success: function (response) {
          if (response==true) {
            window.location.replace("http://chat-system.atwebpages.com/");
          }
        }
    });
});