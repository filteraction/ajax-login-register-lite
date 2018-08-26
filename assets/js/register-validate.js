//************* form submit check ************
jQuery(function () {

    jQuery(document.body).on('blur', '.required', function () {
        //console.log(this.id);
        if (jQuery(this).val() != null && jQuery(this).val().trim() != "") {
            jQuery(this).css('border-color', '');
        }
        else {
            jQuery(this).css('border-color', 'red');
        }
    });
    jQuery(document.body).on('keyup', '.required', function ()
      {
        if (jQuery(this).val() != null && jQuery(this).val().trim() != "") {
            jQuery(this).css('border-color', '');
        }
        else
        {
            jQuery(this).css('border-color', 'red');
        }
    });   





     jQuery(document.body).on('blur', '.chk_password', function () {
        var pass = jQuery('#upass').val();
        var cpass = jQuery('#cpass').val();
        if (cpass == null || cpass.trim() == "") {
                jQuery('#cpass').css('border-color', 'red');
                chk_pass = false;
            }
          else if (cpass!= pass) {
          jQuery('#msg-reg').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
        '<strong>Oh snap!</strong> Password does not match</div> ');
                jQuery('#cpass').css('border-color', 'red');
                chk_pass = false;
              
          }
          else {
                jQuery('#cpass').css('border-color', '');
                 jQuery('#msg-reg').html('');
            }
    });
    jQuery(document.body).on('keyup', '.chk_password', function (){
          var pass = jQuery('#upass').val();
        var cpass = jQuery('#cpass').val();
        if (cpass == null || cpass.trim() == "") {
                jQuery('#cpass').css('border-color', 'red');
                chk_pass = false;
            }
          else if (cpass!= pass) {
        jQuery('#msg-reg').html('');
          jQuery('#msg-reg').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
        '<strong>Oh snap!</strong> Password does not match</div> ');
                jQuery('#cpass').css('border-color', 'red');
                chk_pass = false;
              
          }
          else {
                jQuery('#cpass').css('border-color', '');
            }
    });









    jQuery(document.body).on('keypress', '.yearvalidate', function (ev) {
        if (ev.which != 8 && ev.which != 0 && (ev.which < 48 || ev.which > 57)) {
            return false;
        }
        else
        {
            var current_year = new Date().getFullYear();
            if (jQuery(this).val() != null && jQuery(this).val().trim() != "" && jQuery(this).val().length == 4) {
                if (Number(jQuery(this).val()) <= current_year) {
                    jQuery(this).css('border-color', '');
                }
                else {
                    jQuery(this).css('border-color', 'red');
                }
            }
            else {
                jQuery(this).css('border-color', 'red');
            }
        }
    });
    jQuery(document.body).on('blur', '.yearvalidate', function () {
        var current_year = new Date().getFullYear();
        if (jQuery(this).val() != null && jQuery(this).val().trim() != "") {
            if ((jQuery(this).val().length == 4) && (Number(jQuery(this).val()) <= current_year)) {
                jQuery(this).css('border-color', '');
            }
            else {
                jQuery(this).css('border-color', 'red');                
            }
        }
    });
    jQuery(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    //jQuery(".required").blur(function () {
    //    console.log(this.id);
    //    if (jQuery(this).val() != null && jQuery(this).val().trim() != "")
    //    {
    //     jQuery(this).css('border-color', '');
    //    }
    //    else
    //    {
    //     jQuery(this).css('border-color', 'red');
    //    }
    //});

    jQuery(".email_required").keyup(function () {
       if (jQuery(this).val() != null && jQuery(this).val().trim() != "") {
           var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)jQuery)|(@@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?jQuery)/i);
           var valid = emailReg.test(jQuery(this).val());
           if (!valid) {
               jQuery(this).css('border-color', 'red');
           } else {
               jQuery(this).css('border-color', '');
           }
       }
       else
       {
           jQuery(this).css('border-color', 'red');
       }
    });

  jQuery(document.body).on('blur', '.email_required', function () {
       if (jQuery(this).val() != null && jQuery(this).val().trim() != "") {
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}jQuery/i);

           var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)jQuery)|(@@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?jQuery)/i);
           var valid = pattern.test(jQuery(this).val());
           if (!valid) {
               jQuery(this).css('border-color', 'red');
           } else {
               jQuery(this).css('border-color', '');
           }
       }
       else
       {
           jQuery(this).css('border-color', 'red');
       }
    });





    jQuery("#register-form").submit(function (event) {
   
        // events: required, number, decimal, email_required
        var chk_required = true;
        var chk_email_required = true;
        var chk_email_format = true;
        var chk_pass = true;
        jQuery(this).find('.required').each(function () {
            if (jQuery(this).val() == null || jQuery(this).val().trim() == "") {
                jQuery(this).css('border-color', 'red');
                chk_required = false;
            }
        });  


        jQuery(this).find('.email_required').each(function () {
            if (jQuery(this).val() == null || jQuery(this).val().trim() == "") {
                jQuery(this).css('border-color', 'red');
                chk_email_required = false;
            }
        });

        jQuery(this).find('.email_required').each(function () {
            if (jQuery(this).val() == null || jQuery(this).val().trim() == "") {
                var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)jQuery)|(@@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?jQuery)/i);
                var valid = emailReg.test(jQuery(this).val());
                if (!valid)
                {
                    jQuery(this).css('border-color', 'red');
                    chk_email_format = false;
                }
                else
                {
                    jQuery(this).css('border-color', '');
                }

            }
        });
        
     

  jQuery(this).find('.chk_password').each(function () {
            if (jQuery(this).val() == null || jQuery(this).val().trim() == "") {
                jQuery(this).css('border-color', 'red');
                chk_pass = false;
            }
        });
       
        
        jQuery(this).find('.yearvalidate').each(function () {
            var current_year = new Date().getFullYear();
            if (jQuery(this).val() != null && jQuery(this).val().trim() != "")
            {
                if ((jQuery(this).val().length == 4) && (Number(jQuery(this).val()) <= current_year))
                {
                    jQuery(this).css('border-color', '');
                }
                else
                {
                    jQuery(this).css('border-color', 'red');
                    chk_email_format = false;
                }
            }
        });
        // console.log('chk_required = '+chk_required);
        //  console.log('chk_pass = '+chk_pass);
        //   console.log('chk_email_required = '+chk_email_required);
        //    console.log('chk_email_format = '+chk_email_format);
        if (chk_required == true && chk_pass==true && chk_email_required == true && chk_email_format == true) {
            on();
              // var alldata = jQuery("#register-form").serialize();
              var register_userfname = jQuery('#uname').val();
              var register_email = jQuery('#uemail').val();
              var register_password = jQuery('#upass').val();
              var register_phone = jQuery('#uphone').val();
              var business_name = jQuery('#businessname').val();

              var dataString ='action='+'create_user'+
                '&uname='+register_userfname+
                '&uemail='+register_email+
                '&upassword='+register_password+
                '&businessname='+business_name+
                '&uphone='+register_phone;

            // console.log(alldata);
            // console.log(ajaxurl);
                jQuery.ajax({
                    type:'POST',
                    url: ajaxurl,
                    data: dataString,
                    catch: false,
                    dataType : 'json',
                    success: function(response)
                    {
                         console.log('error:'+response);
                      if(response[0]=='fail')
                          {
                            jQuery('#msg-success').addClass('strong').html(response[1]);
                          }
                      else if(response[0]=='success')
                        {
                          console.log(response[3]);
                            jQuery('#msg-success').addClass('strong').html(response[1]);
                            jQuery("#register-form")[0].reset();
                        }
                      else
                        {
                          jQuery('#msg-success').addClass('strong').html('<div class="alert alert-danger" role="alert">'+
                            '<button style="width: 50px" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                  '<strong>Oh snap!</strong> Something went wrong.</div>');
                        }
                          off();
                    },
                    error: function (response) {
                      console.log(response);
                                      jQuery('#msg-success').addClass('error').html(response);
                                    jQuery("#register-form")[0].reset()
                                    off();
                                }

                  });
    
            return false;

        }
        else //if (chk_required == false || chk_email_required == false || chk_email_format == false) 
        {
                        jQuery('#msg-reg').addClass('error').html('<div class="alert alert-danger alert-dismissable fade in">'+
        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
        '<strong>*</strong> Fields are required</div> ');
            event.preventDefault();
        }

    });
});