jQuery(function(){

 function check_email() {
                  var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}jQuery/i);

                  if (!pattern.test(jQuery('#login_username').val())) {
              document.getElementById('login_username').style.borderColor = "red"; 
			  jQuery('#msg-log').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
			    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
			    '<strong>*</strong> Invalid email address</div> ');
			  
                  }

            } 


	    jQuery('#login_username').focusout(function(){
	  document.getElementById('login_username').style.borderColor = "";
	   check_email();
	});
		jQuery('#login_password').focusout(function(){
	  document.getElementById('login_password').style.borderColor = "";
	});

/*Reset Password*/
jQuery('#wp-submit').click(function(){
  var lost_email = jQuery('#lost_email').val();
  var action = jQuery('#action').val();
   if(lost_email==""||lost_email=="undefined"){
    document.getElementById('login_username').style.borderColor = "red"; 
    jQuery('#msg-log').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
      '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
      '<strong>*</strong> Username is required</div> ');
    return false;
   }
   else{
  jQuery('#msg-log').html('');
  var datas1 =   'user_login='+lost_email+
                '&action='+'reset_password'+              
                '&reset='+'true';             
                console.log(datas1);
       on();//show loader
    jQuery.ajax({
    type:'POST',
    url: ajaxurl,
    data: datas1,
    catch: false,
    dataType : 'json',
    success: function(response){

    console.log('return=  '+response['return']+' msg= '+response['msg']+'result='+response['results']);
// return false;
      if(response['return']=='ok'){
        //show login faild error
        jQuery('#msg-log').html(response['msg']);
        //window.location = "http://www.serenitea.com.au/demo/wp-admin/";
      }
      else if(response['return']=='invalid'){
        //login successfull and redirect.....
        jQuery('#msg-log').html(response['msg']);
         
      }
      else{
          jQuery('#msg-log').html(response['msg']);
      }
      off();
    },
    error: function (response) {
                      jQuery('#msg-log').addClass('error').html(response);
                    setTimeout(off, 3000);//hide loader
                    off();
                }

  });
  return false;

 }
})





/*loging validation*/
  jQuery('#log_btn_sub').click(function(){
   
	 var login_username = jQuery('#login_username').val();
	 var login_password = jQuery('#login_password').val();
	 var remember_me_checkbox = jQuery('#remember_me_checkbox').val();

 if(login_username==""||login_username=="undefined"){
	  document.getElementById('login_username').style.borderColor = "red"; 
	  jQuery('#msg-log').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
	    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
	    '<strong>*</strong> Username is required</div> ');
	  return false;
	 }
	 // else if(login_username!=""){
	 // 	check_email();
	 // 	return false;
	 // }
 else if(login_password==""||login_password=="undefined"){
   document.getElementById('login_password').style.borderColor = "red"; 
      jQuery('#msg-log').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
    '<strong>*</strong> Password is required.</div> ');
  return false;
 }
 else{
  jQuery('#msg-log').html('');
  var datas =   'login_username='+login_username+
                '&login_password='+login_password+
                '&action='+'user_login'+
                '&remember_me_checkbox='+remember_me_checkbox;
       on();//show loader
    jQuery.ajax({
    type:'POST',
    // url: 'https://localhost/egates/log-in/',
    url: ajaxurl,
    data: datas,
    catch: false,
    dataType : 'json',
    success: function(response){
         console.log(response);
      if(response['return']=='true'){
        //show login faild error
      	jQuery('#msg-log').html(response['msg']);
        window.location = response['redirect'];
      }
      else if(response['return']=='not_activated' || response['return']=='inactive'){
        //account has not been activated yet.
        jQuery('#msg-log').html(response['msg']);

      }
      else if(response['return']=='invalid'){
        jQuery('#msg-log').html(response['msg']+response['data']);
      	
      	 
      }
      else{
          jQuery('#msg-log').html(response['msg']);
      }
      off();
    },
    error: function (response) {
                      jQuery('#msg-log').addClass('error').html(response);
                    jQuery("#login-form")[0].reset()
                    setTimeout(off, 3000);//hide loader
                    off();
                }

  });
  return false;

 }

});
});
