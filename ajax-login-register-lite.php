<?php 
/*Plugin Name: Ajax Login Register Lite
Plugin URI:   https://github.com/dasbairagya/ajax-login-register-lite
Description:  Simple ajax base wordpress login/register plugin. Activate the plugin and then go to your  Settings page to set up basic things. 
Version:      1.0.0
Author:       Filter Action
Author URI:   https://www.filteraction.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
License:     GPL2
Ajax Login Register Lite is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Ajax Login Register Lite is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Ajax Login Register Lite. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
if ( ! defined( 'ABSPATH' ) ) {
exit; 
}
if ( ! defined( 'ALRL_FILE' ) ) {
define( 'ALRL_FILE', __FILE__ );
}
define("ALRL_URL", plugin_dir_url( __FILE__ ));
define("ALRL_ROOT_URI", plugins_url( __FILE__ ));
define("ALRL_ADMIN_URI", admin_url());
define("ALRL_PATH", __DIR__);
define('ALRL_PLUGIN', plugin_basename( __FILE__ ));

class ALRL
{
    private $login_redirect;
    public function __construct()
    {
    	add_filter( "plugin_action_links_".ALRL_PLUGIN, array( $this, 'plugin_add_settings_link' ) );//add plugin settings link to plugins page
        add_action( 'wp_head', array( $this, 'upl_ajaxurl' ) );
        add_action( 'init', array($this, 'alrl_login_register_shortcode_cb' ) );
		add_action( 'wp_ajax_user_login', array( $this,'user_login_func' ) );
		add_action( 'wp_ajax_nopriv_user_login', array($this,'user_login_func' ) );
		add_action( 'wp_ajax_create_user', array( $this,'it_create_user' ) );
		add_action( 'wp_ajax_nopriv_create_user', array($this, 'it_create_user' ) );
		add_action( 'wp_ajax_reset_password', array( $this, 'reset_user_password' ) );
		add_action( 'wp_ajax_nopriv_reset_password', array( $this, 'reset_user_password' ) );
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
		add_action( 'admin_init', array( $this,'register_alrl_settings' ) );
		add_action( 'wp_authenticate', array( $this, 'login_with_email_address' ) );
		add_action( 'wp_logout',array( $this, 'auto_redirect_after_logout' ) );
		add_action( 'init', array( $this, 'alrl_enqueue_script') );
		add_action( 'admin_enqueue_scripts', array( $this, 'alrl_media_enque' ) );
		
    }

	public function plugin_add_settings_link( $links ) {
	    $settings_link = '<a href="admin.php?page=ajax-login-register-lite">' . __( 'Settings' ) . '</a>';
	    array_push( $links, $settings_link );
	  	return $links;
	}

    public function alrl_login_register_shortcode_cb(){
    	add_shortcode( 'alrl-login-register-lite', array( $this, 'alrl_login_register_shortcode' ) );
    }

	public function upl_ajaxurl(){
	?>
		<script type="text/javascript">
		  var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
	<?php
	}

	public function create_admin_menu(){
		$page_title = 'ALRL';
		$menu_title = 'ALRL';
		$capability = 'manage_options';
		$menu_slug = 'ajax-login-register-lite';
		$cb_function = array( $this, 'ajax_login_register_lite');
		$position = 2;
		$mypage = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $cb_function, $icon_url = 'dashicons-unlock', $position  ); 
		add_action( "admin_print_scripts-$mypage", array($this, 'alrl_enqueue_script' ) );
		add_action( "admin_print_scripts-$mypage", array($this, 'alrl_enqueue_bootstrap' ) );
	}

	public function register_alrl_settings(){
		//register our settings
		register_setting( 'ajax-login-register-lite-settings-group', 'reg_success_msg' );
		register_setting( 'ajax-login-register-lite-settings-group', 'reg_failure_msg' );
		register_setting( 'ajax-login-register-lite-settings-group', 'log_success_msg' );
		register_setting( 'ajax-login-register-lite-settings-group', 'log_failure_msg' );
		register_setting( 'ajax-login-register-lite-settings-group', 'alrl_logo_image' );
		register_setting( 'ajax-login-register-lite-settings-group', 'alrl_logo_height' );
		register_setting( 'ajax-login-register-lite-settings-group', 'alrl_logo_width' );
		register_setting( 'ajax-login-register-lite-settings-group', 'alrl_cookies' );
		register_setting( 'ajax-login-register-lite-settings-group', 'login_redirect' );
		register_setting( 'ajax-login-register-lite-settings-group', 'logout_redirect' );
		// register_setting( 'ajax-login-register-lite-settings-group', 'alrl_background' );
	}

	public function ajax_login_register_lite(){
	include_once('admin/admin-settings.php');
	}

	function logo_image_uploader( $name, $width, $height, $default_img ) {

	    // Set variables
	    $options = get_option( 'alrl_logo_image' );
	    

	    if ( !empty( $options[$name] ) ) {
	        $image_attributes = wp_get_attachment_image_src( $options[$name], array( $width, $height ) );
	        $src = $image_attributes[0];
	        $value = $options[$name];
	    } else {
	        $src = $default_img;
	        $value = '';
	    }

	    $text = __( 'Upload', RSSFI_TEXT );

	    // Print HTML field
	    echo '
	        <div class="upload">
	            <img data-src="' . $default_image . '" src="' . $src . '" width="' . $width . 'px" height="' . $height . 'px" />
	            <div>
	                <input type="hidden" name="alrl_logo_image[' . $name . ']" id="alrl_logo_image[' . $name . ']" value="' . $value . '" />
	                <button type="submit" class="upload_image_button button">' . $text . '</button>
	                <button type="submit" class="remove_image_button button">&times;</button>
	            </div>
	        </div>
	    ';
	}

	public function alrl_html_form_code(){
		include_once('view/register.php');
	}

	public function alrl_deliver_mail(){
		if ( isset( $_POST['cf-submitted'] ) ) {
		// sanitize form values
		$name    = sanitize_text_field( $_POST["cf-name"] );
		$email   = sanitize_email( $_POST["cf-email"] );
		$subject = sanitize_text_field( $_POST["cf-subject"] );
		$message = esc_textarea( $_POST["cf-message"] );
		$this->validate_form($name, $email, $subject, $message);//validation called here
		// display form error if it exist
		if (is_array($this->form_errors)) {
		foreach ($this->form_errors as $error) {
		echo '<div style="color:red;">';
		echo '<strong>ERROR</strong>:';
		echo $error . '<br/>';
		echo '</div>';
		}
		}
			// get the blog administrator's email address
			if ( count($this->form_errors) < 1 ) {
			$to = get_option( 'admin_email' );
			$headers = "From: $name <$email>" . "\r\n";
				// If email has been process for sending, display a success message
				if ( wp_mail( $to, $subject, $message, $headers ) ) {
				echo '<div>';
				echo '<p>Thanks for contacting me, expect a response soon.</p>';
				echo '</div>';
				} else {
				echo 'An unexpected error occurred';
				}
			}
		}
	}

	public function alrl_login_register_shortcode() {
		ob_start();
		//$this->alrl_deliver_mail();
		$this->alrl_html_form_code();
		return ob_get_clean();
	}

	public function user_login_func(){
		if($_POST['login_username']) {
		global $wpdb;
		//We shall SQL escape all inputs
		$username = $wpdb->escape($_REQUEST['login_username']);
		$password = $wpdb->escape($_REQUEST['login_password']);
		$remember = $wpdb->escape($_REQUEST['remember_me_checkbox']);
		if($remember) $remember = "true";
		else $remember = "false";
		$login_data = array();
		$response =array();
		$login_data['user_login'] = $username;
		$login_data['user_password'] = $password;
		$login_data['remember'] = $remember;
		$user_table = $wpdb->prefix . 'users';
		$results = $wpdb->get_row( "SELECT * FROM $user_table WHERE user_email='".$username."'");
		if($results->ID){
		//          $response = array('return'=>'invalid', 'msg'=>'<div class="alert alert-danger alert-dismissable fade in">
		//                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		//                <strong>Your account has not been activated yet.</strong>To activate it check your email and click on the activation link.</div> ','data'=>$activation_key);
		// echo json_encode($response);
		// die;
		$activation_id = $results->ID;
		$activation_key =  get_user_meta( $activation_id, 'has_to_be_activated', true );
		$user_meta=get_userdata($results->ID);
		$user_roles=$user_meta->roles;
		// if($activation_key != false )
		if($activation_key = false )
		{
		$response = array('return'=>'not_activated','key'=>$activation_key,'msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Your account has not been activated yet.</strong>To activate it check your email and click on the activation link.</div> ');
		}
		// elseif( $results->user_status == 0 ){
		elseif( 1== 2 ){
		$response = array('return'=>'inactive','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Your account is inactive.</strong> Please contact to site the admin.</div> ');
		}
		else{ 
		$user_verify = wp_signon( $login_data, false ); 
		if ( is_wp_error($user_verify) ){
		//loging falis
		$response = array('return'=>'invalid','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Invalid Username or Password...!</div> ');
		} 
		else {
		//login success
			$login_redirect = (!empty(get_option('login_redirect'))) ? esc_attr( get_option('login_redirect') ) : home_url();
      		$msg = (!empty(get_option('log_success_msg'))) ? esc_attr( get_option('log_success_msg') ): 'Login successfull. Redirecting...!';
		$response = array('return'=>'true','redirect' => $login_redirect, 'msg'=> '<div class="alert alert-success alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>'.$msg.'</div>');
		}
		}
		}//end result if
		else{
		$response = array('return'=>'invalid','msg'=> '<div class="alert alert-warning alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>User does not exits! </div> ');
		}
		echo json_encode($response);
		die;
		} //end $_post if
		}
	public function it_create_user() {
		global $wpdb;
		$save_value = array();
		$from_name = get_bloginfo('name');
		$from_email = get_bloginfo('admin_email');
		$fname = $_POST['uname'];
		$email = $_POST['uemail'];
		$password = $_POST['upassword'];
		$register_phone = $_POST['uphone'];
		$businessname = $_POST['businessname'];
		// Handle request then generate response using WP_Ajax_Response
		if(email_exists($email)){
		$save_value[0]="fail";
		$save_value[1] = '<div class="alert alert-danger" role="alert">
		<button style="width: 50px" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong>Oh snap!</strong> This email already exists.
		</div>';
		// return $save_value;
		}
		else if(username_exists($fname)){
		$save_value[0]="fail";
		$save_value[1] = '<div class="alert alert-danger" role="alert">
		<button style="width: 50px" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<strong>Oh snap!</strong> User already exists.
		</div>';
		// return $save_value;
		}
		else {
		$user_id = wp_insert_user(array(
		'user_login'    =>  $email,
		'user_pass'     =>  $password,
		'first_name'    =>  $fname,
		'user_email'    =>  $email,
		'display_name'  =>  $fname,
		'nickname'      =>  $fname,
		'user_status'   =>1
		//'role'      =>  'wholesaler'
		)
		);
		$code = sha1( $user_id . time() );
		$activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(288));
		add_user_meta( $user_id, 'has_to_be_activated', $code, true );
		$user_name=  sanitize_title_with_dashes($fname);
		update_user_meta( $user_id, 'register_phone', $register_phone );
		update_user_meta( $user_id, 'business_name', $businessname );
		if($user_id){
		global $wpdb;
		$status = 1;
		$user_table =  $wpdb->prefix . "users";
		$wpdb->update($user_table, array('user_status'=>$status), array('ID'=>$user_id));
		/*******************first mail to user - start **************************/
		$full_name = $fname . ' ' . $lname;
		$fullname = ucwords(strtolower($user_name));
		$subject = "Welcome to ".$from_name;
		$message = '<p>Dear '. $full_name.'!</p><p></p><p>You have successfully created an account to our Website.<br>Your Email: '.$email.'<br> Your password is : '.$password.'<br>To activate your acount click on the folowing link: '.$activation_link;
		//Headers
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		if(!empty($from_email) && filter_var($from_email,FILTER_VALIDATE_EMAIL))//Validating From
		$headers .= "From: ".$from_name." <".$from_email."> \r\n";
		$reply_email = $from_email;
		if($reply_email){
		$headers .= "Reply-To: {$reply_email}\r\n";
		$headers .= "Return-Path: {$from_name}\r\n";
		}
		wp_mail($email, $subject, $message , $headers);
		/******************* ! Mail to user - end **********************/
		/*************** Mail to admin - start ****************************/
		$subject = $from_name."- New customer registration request";
		$message    = '<p>Dear Admin,</p><p>'.$full_name.' is registered in our website!</p><br>User Details are:<br> Name: '.$full_name.'<br>Phone no:'.$register_phone.'<br>Email: '.$email.'<br>'
		. '<p>Best Wishes,<br>Team '.$from_name;
		wp_mail($from_email, $subject, $message , $headers);
		/**************** Mail to admin - end ****************************/
		}
		$reg_msg = (!empty(get_option('reg_success_msg'))) ? esc_attr( get_option('reg_success_msg') ): 'Registration successfull. Please check your mail for confirmation.';
		$save_value[0]='success';
		$save_value[1] = '<div class="alert alert-success" role="alert">
		<button style="width: 50px" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$reg_msg.'</div>';
		$save_value[3]= $activation_link;
		// return $save_value;
		}
		echo json_encode($save_value) ;
		// json_encode($_POST);
		die;
	}
	public function reset_user_password(){
		global $wpdb;
		$error = '';
		$success = '';
		// check if we're in reset form
		if( isset( $_POST['reset'] ) && $_POST['reset'] == true )
		{
		$email = trim($_POST['user_login']);
		if( empty( $email ) ) {
		$error = 'Enter a username or e-mail address..';
		$response = array('return'=>'invalid','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Enter a username or e-mail address..!</div> ');
		} else if( ! is_email( $email )) {
		$error = 'Invalid username or e-mail address.';
		$response = array('return'=>'invalid','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Invalid username or e-mail address </div>');
		} else if( ! email_exists( $email ) ) {
		$error = 'There is no user registered with that email address.';
		$response = array('return'=>'invalid','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>There is no user registered with that email address.</div> ');
		} else {
		$random_password = wp_generate_password( 12, false );
		$user = get_user_by( 'email', $email );
		$update_user = wp_update_user( array (
		'ID' => $user->ID,
		'user_pass' => $random_password
		)
		);
		// if  update user return true then lets send user an email containing the new password
		if( $update_user ) {
		$to = $email;
		$subject = 'Your new password';
		$sender = get_option('name');
		$message = 'Your new password is: '.$random_password;
		$headers[] = 'MIME-Version: 1.0' . "\r\n";
		$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers[] = "X-Mailer: PHP \r\n";
		$headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";
		$mail = wp_mail( $to, $subject, $message, $headers );
		if( $mail )
		$success = 'Check your email address for you new password.';
		$response = array('return'=>'ok','msg'=> '<div class="alert alert-success alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Check your email address for you new password.</div> ');
		} else {
		$error = 'Oops something went wrong updaing your account.';
		$response = array('return'=>'updatefailed','msg'=> '<div class="alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Oops something went wrong updaing your account.</div> ');
		}
		}
		if( ! empty( $error ) )
		/*  echo '<div class="message"><p class="error"><strong>ERROR:</strong> '. $error .'</p></div>';*/
		echo json_encode($response);
		if( ! empty( $success ) )
		/*  echo '<div class="error_login"><p class="success">'. $success .'</p></div>';*/
		echo json_encode($response);
		}
		die;
	}

	public function login_with_email_address( $username ) {
		$user = get_user_by( 'email', $username );
		if ( !empty( $user->user_login ) )
		$username = $user->user_login;
		return $username;
	}

	public function auto_redirect_after_logout(){
		$logout_redirect = (!empty(get_option('logout_redirect'))) ? esc_attr( get_option('logout_redirect') ) : home_url();

		wp_redirect($logout_redirect);
		exit();
	}

	public function alrl_enqueue_bootstrap(){

		wp_enqueue_style ('bootstrap',  'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'  );
		wp_enqueue_script('bootstrapjs', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js', array(), null, true);
    
	}

	public function alrl_enqueue_script(){ 
		//enque style & js
		wp_enqueue_style ('style', ALRL_URL. 'assets/css/style.css'  );
		// ------------------------------------------------------------------------------------
		wp_enqueue_script( 'register_validate_script', ALRL_URL . 'assets/js/register-validate.js', array(), false, true);
		wp_enqueue_script( 'login_validate_script', ALRL_URL . 'assets/js/login-validate.js', array(), false, true);
		wp_enqueue_script( 'my_custom_script', ALRL_URL . 'assets/js/script.js', array(), false, true);
	}

	public function alrl_media_enque(){
		wp_enqueue_media();
	}
}

new ALRL();
?>