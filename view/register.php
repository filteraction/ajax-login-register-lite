<?php 
$default_logo_image = plugins_url('../assets/images/demo-logo.png', __FILE__);
$default_background_image = plugins_url('../assets/images/pumpkins-creative.jpg', __FILE__);
$logo="custom_image";
$background="alrl_background";
$logo_height = (!empty(get_option( 'alrl_logo_height' )) ) ? get_option( 'alrl_logo_height' ) : 160 ;
$logo_width = (!empty(get_option( 'alrl_logo_width' )) ) ? get_option( 'alrl_logo_width' ) : 180 ;
function get_image_url($name, $default_src, $width=null,$height = null ){
  $options = get_option( 'alrl_logo_image' );
  
    if ( !empty( $options[$name] ) ) {
        $image_attributes = wp_get_attachment_image_src( $options[$name], array( $width, $height ) );
        $src = $image_attributes[0];
        $value = $options[$name];
    } else {
        $src = $default_src;
        $value = '';
    }
    return $src;
  }
    
?>
<section class="ajax-login-register-lite">
<style type="text/css">
    .card{border: none !important; bacground:none !important;}
    .ajax-login-register-lite{
      /*'https://site.goigi.co/egates/wp-content/uploads/2018/04/Automated-Gates.jpg'*/
  background: url(<?php  echo get_image_url($background, $default_background_image, 100, 100);?>);
}
</style>
<div id="msg-success"></div>
  <div id="loadersmall"></div>
  <div id="overlay"></div>

        <div id="msg-log" style="margin-top: 15px;"></div>
        <div id="msg-reg"></div>
      <div class="flip">
        <div class="card"> 
          <div class="face front"> 
            <div class="panel panel-default">
              <!-- start: login form -->
               <!-- <?php echo do_shortcode('[wordpress_social_login]'); ?> --> 
              <form class="form-horizontal" id="login-form">
                
                <br>
                 <div class="logo center">
                  
                    <a href="<?php echo home_url();?>">
                <?php echo '<img data-src="' . $default_logo_image . '" src="' . get_image_url($logo, $default_logo_image, $logo_width, $logo_height) . '" width="' . $logo_width . 'px" height="' . $logo_height . 'px" />';?>
                    
                        
                    </a>
                </div>

                <br>
                <input id="login_username" class="form-control" name="username" 
                 placeholder="*Email" type="text" >
                <!-- <input class="form-control" placeholder="Username"/> -->
                <input id="login_password" class="form-control" name="password" 
                 placeholder="*password" type="password">
                <!-- <input class="form-control" placeholder="Password"/> -->
                <div class="text-left" style="float: left;">
                  <input id="remember_me_checkbox" name="remember_me_checkbox"
                  class="checkbox1"  type="checkbox"> Remember me</div>
                <div class="text-right" style="float: right;"><a href="#" onclick="forgot()">Forgot Password?</a></div>
                <button class="btn btn-primary btn-block" id="log_btn_sub">LOG IN</button>
             
                <div class="text-center">
                  <a href="#" class="fliper-btn">Create new account?</a>
                </div>
                <?php wp_nonce_field( 'login-form' ); ?>
              </form>
              <!-- end: login form -->
              <!-- start:forgot password -->
                <div id="list1" class="form-horizontal">
                 <br>
                  <div class="logo center">
                  
                     <a href="<?php echo home_url();?>">
                <?php echo '<img data-src="' . $default_logo_image . '" src="' . get_image_url($logo, $default_logo_image, $logo_width, $logo_height) . '" width="' . $logo_width . 'px" height="' . $logo_height . 'px" />';?>
                    
                        
                    </a>
                </div>
                      <form name="lostpasswordform" id="lostpasswordform" >
                        
                              <input type="text" name="user_login" id="lost_email" class="form-control"  placeholder="Enter your email here" required>
                            <input type="hidden" name="action" value="reset" id="action"/>
                              <button id="wp-submit" class="btn btn-primary btn-block">Get New Password</button>
                              <p class="text-center">
                                <a href="#" onclick="back_to_login()">Back to Login</a>
                              </p>
                              
                      </form>
            
              </div>
              <!-- ends:forgot password -->
            </div>
          </div> 




          <div class="face back"> 
              <div class="panel panel-default">
              <form class="form-horizontal" id="register-form">
                <br>

                  <div class="logo center">
                  
                      <a href="<?php echo home_url();?>">
                <?php echo '<img data-src="' . $default_logo_image . '" src="' . get_image_url($logo, $default_logo_image, $logo_width, $logo_height) . '" width="' . $logo_width . 'px" height="' . $logo_height . 'px" />';?>
                    
                        
                    </a>
                </div>
                <br>
                <input id="uname" class="form-control required" name="uname" 
                 placeholder="*Name" type="text">
                <input id="businessname" class="form-control required" name="businessname" 
                 placeholder="*Business Name" type="text">
                 <input id="uphone" class="form-control number required" name="uphone" 
                 placeholder="*Contact Number" type="text">
                 <input id="uemail" class="form-control email_required" name="uemail" 
                 placeholder="*Email" type="email">
                 <input id="upass" class="form-control required" name="upassword" 
                 placeholder="*Password" type="password">
                 <input id="cpass" class="form-control chk_password" name="cpassword" 
                 placeholder="*Re Enter Password " type="password">

                <button class="btn btn-primary btn-block" id="register-submit">SIGN UP</button>
                <p class="text-center">
                  <a href="#" class="fliper-btn">Already have an account?</a>
                </p>
                
              </form>

            </div>

          </div>
        </div>   
      </div>



<script>

function on() {
    document.getElementById("overlay").style.display = "block";
     document.getElementById("loadersmall").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("loadersmall").style.display = "none";
}

function forgot(){
  document.getElementById("login-form").style.display = "none";
  document.getElementById("list1").style.display = "block";
}
function back_to_login(){
  document.getElementById("login-form").style.display = "block";
  document.getElementById("list1").style.display = "none";
}

var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";   

</script>
</section>