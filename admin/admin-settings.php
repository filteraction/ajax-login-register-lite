		<div class="wrap">
		  <h1>Ajax Login Register Lite Settings</h1>
		   <?php settings_errors(); ?>
			   <div class="row">
				 <div class="col-md-7">
				  <form method="post" action="options.php">
				    <?php settings_fields( 'ajax-login-register-lite-settings-group' ); ?>
				    <?php do_settings_sections( 'ajax-login-register-lite-settings-group' ); ?>
				    <table class="form-table">
				      <tr valign="top">
				        <th scope="row">Registration success message
				        </th>
				        <td>
				          <input type="text" name="reg_success_msg" value="<?php echo esc_attr( get_option('reg_success_msg') ); ?>" />
				        </td>
				      </tr>
				      <!-- <tr valign="top">
				        <th scope="row">Registration failure message
				        </th>
				        <td>
				          <input type="text" name="reg_failure_msg" value="<?php echo esc_attr( get_option('reg_failure_msg') ); ?>" />
				        </td>
				      </tr> -->
				      <tr valign="top">
				        <th scope="row">Login success message
				        </th>
				        <td>
				          <input type="text" name="log_success_msg" value="<?php echo esc_attr( get_option('log_success_msg') ); ?>" />
				        </td>
				      </tr>
				     <!--  <tr valign="top">
				        <th scope="row">Login failure message
				        </th>
				        <td>
				          <input type="text" name="log_failure_msg" value="<?php echo esc_attr( get_option('log_failure_msg') ); ?>" />
				        </td>
				      </tr> -->
				      <tr valign="top">
				        <th scope="row">Upload Logo
				        </th>
				        <td>
				          <?php 

				          $default_image = plugins_url('assets/images/demo-logo.png', __FILE__);
				          $this->logo_image_uploader( 'custom_image', $width = 190, $height = 180, $default_image  ); ?>
				        </td>
				      </tr> 
				      <tr valign="top">
				        <th scope="row">Background image
				        </th>
				        <td>
				          <?php 
				          $default_image = plugins_url('assets/images/pumpkins-creative.jpg', __FILE__);
				          $this->logo_image_uploader( 'alrl_background', $width = 360, $height = 180, $default_image ); ?>
				        </td>
				      </tr>
				      <tr valign="top">
				        <th scope="row">Logo height
				        </th>
				        <td>
				          <input type="text" name="alrl_logo_height" value="<?php echo esc_attr( get_option('alrl_logo_height') ); ?>" placeholder=" eg. 170" />
				        </td>
				      </tr>
				      <tr valign="top">
				        <th scope="row">Logo width
				        </th>
				        <td>
				          <input type="text" name="alrl_logo_width" value="<?php echo esc_attr( get_option('alrl_logo_width') ); ?>" placeholder=" eg. 170" />
				        </td>
				      </tr>
				       <tr valign="top">
				          <th scope="row">Redirect url after login</th>
				          <td>
				        <input type="text" name="login_redirect" value="<?php echo esc_attr( get_option('login_redirect') ); ?>" placeholder=" eg. https://example.com/profile" />   
				          </td>
				      </tr> <tr valign="top">
				          <th scope="row">Redirect url after logout</th>
				          <td>
				        <input type="text" name="logout_redirect" value="<?php echo esc_attr( get_option('logout_redirect') ); ?>" placeholder=" eg. https://example.com" />   
				          </td>
				      </tr>
				      <tr valign="top">
				          <th scope="row">Enable cookies</th>
				          <td>
				        <input type="checkbox" name="alrl_cookies" value="yes" <?php echo (get_option('alrl_cookies') == 'yes')?'checked="checked"':'' ?>>    
				          </td>
				      </tr>
				    </table>
				    <?php submit_button(); ?>
				  </form>
				</div>
				<div class="col-md-5">
				  <div class="panel-group">
				     <div class="panel panel-info">
				      <div class="panel-heading">Copy the shortcode below</div>
				      <div class="panel-body">[alrl-login-register-lite]</div>
				      
				    </div>
				  </div>
				  <div class="panel-group">
				     <div class="panel panel-info">
				      <div class="panel-heading">Live Demo</div>
				      <div class="panel-body"><?php echo do_shortcode('[alrl-login-register-lite]');?></div>
				    </div>
				  </div>

				</div>
			</div>
		</div>