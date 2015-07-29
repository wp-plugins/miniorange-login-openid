<?php
function mo_register_openid() {
		if(mo_openid_is_curl_installed()==0){ ?>
			<p style="color:red;">(Warning: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled)</p>
<?php
}?>
<div id="tab">
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab nav-tab-active"
			href="admin.php?page=mo_openid_settings" id="tab1">Social Login</a> <a
			class="nav-tab disabledTab" href="admin.php?page=mo_openid_settings&tab2=true" id="tab2">Social Sharing</a>
	</h2>
</div>

<div id="mo_openid_settings">

	<div class="mo_container">
			<table style="width:100%;">
				<tr>
				<td style="vertical-align:top;width:65%;">

		<?php


	if( isset( $_GET[ 'tab2' ] ) ) {

				mo_openid_other_settings();
	}else{

	if (get_option ( 'mo_openid_verify_customer' ) == 'true') {

		mo_openid_show_verify_password_page();
	} else if (trim ( get_option ( 'mo_openid_admin_email' ) ) != '' && trim ( get_option ( 'mo_openid_admin_api_key' ) ) == '' && get_option ( 'mo_openid_new_registration' ) != 'true') {
		mo_openid_show_verify_password_page();
	} else if(get_option('mo_openid_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_openid_registration_status') == 'MO_OTP_VALIDATION_FAILURE' || get_option('mo_openid_registration_status') == 'MO_OTP_DELIVERED_FAILURE' ){
		mo_openid_show_otp_verification();
	}else if (! mo_openid_is_customer_registered()) {
		delete_option ( 'password_mismatch' );

		mo_openid_show_new_registration_page();
	}  else {

		mo_openid_apps_config();
	}
	}

	?>
			</td>
					<td style="vertical-align:top;padding-left:1%;">
						<?php echo miniorange_openid_support(); ?>
					</td>
				</tr>
			</table>
		<?php

}
function mo_openid_show_new_registration_page() {
	update_option ( 'mo_openid_new_registration', 'true' );
	global $current_user;
		get_currentuserinfo();
	?>

		<!--Register with miniOrange-->
					<form name="f" method="post" action="" id="register-form">
								<input type="hidden" name="option" value="mo_openid_connect_register_customer" />
								<div class="mo_openid_table_layout">

										<h3>Register with miniOrange</h3>

										<p>Please enter a valid email that you have access to. You will be able to move forward after verifying an OTP that we will be sending to this email.
										</p>
										<table class="mo_openid_settings_table">
											<tr>
												<td><b><font color="#FF0000">*</font>Email:</b></td>
												<td><input class="mo_openid_table_textbox" type="email" name="email"
													required placeholder="person@example.com"
													value="<?php echo $current_user->user_email;?>" /></td>
											</tr>

											<tr>
												<td><b><font color="#FF0000">*</font>Phone number:</b></td>
												<td><input class="mo_openid_table_textbox" type="tel" id="phone"
													pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" name="phone" required
													title="Phone with country code eg. +1xxxxxxxxxx"
													value="<?php echo get_option('mo_openid_admin_phone');?>" /></td>
												<td></td>
											</tr>
											<tr>
												<td><b><font color="#FF0000">*</font>Password:</b></td>
												<td><input class="mo_openid_table_textbox" required type="password"
													name="password" placeholder="Choose your password (Min. length 6)" /></td>
											</tr>
											<tr>
												<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
												<td><input class="mo_openid_table_textbox" required type="password"
													name="confirmPassword" placeholder="Confirm your password" /></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><br /><input type="submit" name="submit" value="Next" style="width:100px;"
													class="button button-primary button-large" /></td>
											</tr>
										</table>
									
								</div>
		</form>
				<script>
						jQuery("#phone").intlTelInput();
						var text = "&nbsp;&nbsp;We will call only if you need support."
						jQuery('.intl-number-input').append(text);

		</script>
		<?php
}
function mo_openid_show_verify_password_page() {
	?>
			<!--Verify password with miniOrange-->
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_openid_connect_verify_customer" />
			<div class="mo_openid_table_layout">
				<h3>Login with miniOrange</h3>

					</p>
					<table class="mo_openid_settings_table">
						<tr>
							<td><b><font color="#FF0000">*</font>Email:</b></td>
							<td><input class="mo_openid_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php echo get_option('mo_openid_admin_email');?>" /></td>
						</tr>
						<td><b><font color="#FF0000">*</font>Password:</b></td>
						<td><input class="mo_openid_table_textbox" required type="password"
							name="password" placeholder="Choose your password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" name="submit"
								class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
								target="_blank"
								href="<?php echo get_option('host_name') . "/moas/idp/userforgotpassword"; ?>">Forgot
									your password?</a></td>
						</tr>
					</table>
				
			</div>
		</form>
		<?php
}

function mo_openid_apps_config() {
	?>
		<!-- Google configurations -->
				<form id="form-apps" name="form-apps" method="post" action="">
					<input type="hidden" name="option" value="mo_openid_enable_apps" />
					<div class="mo_openid_table_layout">
							<table class="mo_openid_settings_table">

								<h3>Select Apps</h3>
							
								
									<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="amazon_enable" class="app_enable" name="mo_openid_amazon_enable" value="1"
								<?php checked( get_option('mo_openid_amazon_enable') == 1 );?> /><strong>Amazon</strong>
								</td>
								</tr>
								<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="instagram_enable" class="app_enable" name="mo_openid_instagram_enable" value="1"
								<?php checked( get_option('mo_openid_instagram_enable') == 1 );?> /><strong>Instagram</strong>
								</td>
								</tr>
								<tr>
											<td class="mo_openid_table_td_checkbox"><input type="checkbox"
															id="facebook_enable" class="app_enable" name="mo_openid_facebook_enable" value="1"
										<?php checked( get_option('mo_openid_facebook_enable') == 1 );?> /><strong>Facebook</strong></td>
								</tr>
								<tr>
									<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="google_enable" class="app_enable" name="mo_openid_google_enable" value="1"
										<?php checked( get_option('mo_openid_google_enable') == 1 );?> /><strong>Google</strong></td>
								</tr>
								<tr>
										<td class="mo_openid_table_td_checkbox"><input type="checkbox"
															id="linkedin_enable" class="app_enable" name="mo_openid_linkedin_enable" value="1"
										<?php checked( get_option('mo_openid_linkedin_enable') == 1 );?> /><strong>LinkedIn</strong></td>
								</tr>
							
								<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="salesforce_enable" class="app_enable" name="mo_openid_salesforce_enable" value="1"
								<?php checked( get_option('mo_openid_salesforce_enable') == 1 );?> /><strong>Salesforce</strong></td>
								</tr>
								
								<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="windowslive_enable" class="app_enable" name="mo_openid_windowslive_enable" value="1"
								<?php checked( get_option('mo_openid_windowslive_enable') == 1 );?> /><strong>Windows Live</strong>
								</td>
								</tr>
								
								<tr>
									<td>
									<br>
										<hr>
										<h3>Display Options</h3>
											<p>Please select the options where you want to display the social login icons:</p>
										</td>
								</tr>

											<tr>
												<td class="mo_openid_table_td_checkbox">
												<input type="checkbox" id="default_login_enable" name="mo_openid_default_login_enable" value="1"
																<?php checked( get_option('mo_openid_default_login_enable') == 1 );?> /><strong>Default Login Form</strong></td>
											</tr>
											<tr>
															<td class="mo_openid_table_td_checkbox">
																		<input type="checkbox" id="default_register_enable" name="mo_openid_default_register_enable" value="1"
															<?php checked( get_option('mo_openid_default_register_enable') == 1 );?> /><strong>Default Registration Form</strong></td>
											</tr>
											<tr>
															<td class="mo_openid_table_td_checkbox">
																		<input type="checkbox" id="default_comment_enable" name="mo_openid_default_comment_enable" value="1"
															<?php checked( get_option('mo_openid_default_comment_enable') == 1 );?> /><strong>Comment Form</strong></td>
											</tr>
											<tr>
					<td>
						<br>
							<hr>
							<h3>Theme Options</h3>
							<p>Please select your favourite theme for icons:</p>
							</td>
		</tr>
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"   name="mo_openid_login_theme" class="theme-checkbox" value="oval"
								<?php checked( get_option('mo_openid_login_theme') == 'oval' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/login-theme-1.png', __FILE__ )?>" /></td>
				
		</tr>
	
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"   class="theme-checkbox" name="mo_openid_login_theme" value="circle"
								<?php checked( get_option('mo_openid_login_theme') == 'circle' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/login-theme-2.png', __FILE__ )?>" /></td>
				
		</tr>
		
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"  class="theme-checkbox" name="mo_openid_login_theme" value="square"
								<?php checked( get_option('mo_openid_login_theme') == 'square' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/login-theme-3.png', __FILE__ )?>" /></td>
		</tr>
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"  class="theme-checkbox" name="mo_openid_login_theme" value="button"
								<?php checked( get_option('mo_openid_login_theme') == 'button' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/login-theme-4.png', __FILE__ )?>" /></td>
		</tr>
		<tr>
					<td>
						<br>
							<hr>
							<h3>Customize Text For Social Login Buttons / Icons</h3>
							</td>
		</tr>
		</table>
		<table class="mo_openid_display_table">
		<tr>
												<td><b>Enter text to show above login widget:</b></td>
												<td><input class="mo_openid_table_textbox" type="text" name="mo_openid_login_widget_customize_text"
													 value="<?php echo get_option('mo_openid_login_widget_customize_text'); ?>" /></td>
											</tr>
			
		
			<tr>
												<td><b>Enter text to show on your login buttons (If you have selected theme 4 from above options):</b></td>
												<td><input class="mo_openid_table_textbox" type="text" name="mo_openid_login_button_customize_text"
													value="<?php echo get_option('mo_openid_login_button_customize_text'); ?>"  /></td>
											</tr>
		
							<tr>
											
											<td><br /><input type="submit" name="submit" value="Save" style="width:100px;"
													class="button button-primary button-large" /></td>
											</tr>


								<tr>
									<td colspan="2">
										<hr>
										<p>
											<h3>Add Login Widget</h3>

										<ol>
											<li>Go to Appearance->Widgets. Among the available widgets you
												will find miniOrange Social Login Widget, drag it to the widget area where
												you want it to appear.</li>
											<li>Now logout and go to your site. You will see app icon for which you enabled login.
												</li>
											<li>Click that app icon and login with your existing app account to wordpress.</li>
										</ol>
										</p>
									</td>
								</tr>
							</table>
						</div>

		</form>
		<script>
jQuery(function() {
				jQuery('#tab2').removeClass('disabledTab');
});
</script>

<?php
}

function mo_openid_show_otp_verification(){
	?>
		<!-- Enter otp -->
		<form name="f" method="post" id="otp_form" action="">
			<input type="hidden" name="option" value="mo_openid_validate_otp" />
				<div class="mo_openid_table_layout">
					<table class="mo_openid_settings_table">
							<h3>Verify Your Email</h3>
							<tr>
								<td><b><font color="#FF0000">*</font>Enter OTP:</b></td>
								<td colspan="2"><input class="mo_openid_table_textbox" autofocus="true" type="text" name="otp_token" required placeholder="Enter OTP" style="width:61%;" pattern="{6,8}"/>
								 &nbsp;&nbsp;<a style="cursor:pointer;" onclick="document.getElementById('resend_otp_form').submit();">resend otp</a></td>
							</tr>
							<tr><td colspan="3"></td></tr>
							<tr>

								<td>&nbsp;</td>
								<td style="width:17%">
								<input type="submit" name="submit" value="Validate OTP" class="button button-primary button-large" /></td>

		</form>
		<form name="f" method="post">
		<td style="width:18%">
						<input type="hidden" name="option" value="mo_openid_go_back"/>
						<input type="submit" name="submit"  value="Back" class="button button-primary button-large" /></td>
		</form>
		<form name="f" id="resend_otp_form" method="post" action="">
							<td>

							<input type="hidden" name="option" value="mo_openid_resend_otp"/>
							</td>
							</tr>
							
						
		</form>
		</table>
		</div>



<?php
}
function mo_openid_other_settings(){
	
?>
<form name="f" method="post" id="settings_form" action="">
<input type="hidden" name="option" value="mo_openid_save_other_settings" />
				<div class="mo_openid_table_layout">
				<table class="mo_openid_settings_table">
									<h3>Select Social Apps</h3>
								<tr>
											<td class="mo_openid_table_td_checkbox"><input type="checkbox"
															id="facebook_enable" class="app_enable" name="mo_openid_facebook_share_enable" value="1"
										<?php checked( get_option('mo_openid_facebook_share_enable') == 1 );?> /><strong>Facebook</strong></td>
								</tr>
								<tr>
									<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="google_enable" class="app_enable" name="mo_openid_google_share_enable" value="1"
										<?php checked( get_option('mo_openid_google_share_enable') == 1 );?> /><strong>Google</strong></td>
								</tr>
								<tr>
										<td class="mo_openid_table_td_checkbox"><input type="checkbox"
															id="linkedin_enable" class="app_enable" name="mo_openid_linkedin_share_enable" value="1"
										<?php checked( get_option('mo_openid_linkedin_share_enable') == 1 );?> /><strong>LinkedIn</strong></td>
								</tr>
							<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="pinterest_enable" class="app_enable" name="mo_openid_pinterest_share_enable" value="1"
								<?php checked( get_option('mo_openid_pinterest_share_enable') == 1 );?> /><strong>Pinterest </strong></td>
								</tr>
								<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="reddit_enable" class="app_enable" name="mo_openid_reddit_share_enable" value="1"
								<?php checked( get_option('mo_openid_reddit_share_enable') == 1 );?> /><strong>Reddit </strong></td>
								</tr>
								<tr>
								<td class="mo_openid_table_td_checkbox"><input type="checkbox"
										id="twitter_enable" class="app_enable" name="mo_openid_twitter_share_enable" value="1"
								<?php checked( get_option('mo_openid_twitter_share_enable') == 1 );?> /><strong>Twitter </strong></td>
								</tr>	
									

											<tr>
											<td>
											<br>
											  <hr>
											<h3>Display Options</h3>
											<p>Please select the options where you want to display social share icons:</p>
											</td>
											</tr>
											
											<tr>
		<td><input type="checkbox" id="mo_apps_home_page"  name="mo_share_options_home_page"  value="1"
			<?php checked( get_option('mo_share_options_enable_home_page') == 1 );?>><strong>Home Page</strong>
		</td></tr>
		<tr>
		<td><input type="checkbox" id="mo_apps_posts"  name="mo_share_options_post" value="1"
			<?php checked( get_option('mo_share_options_enable_post') == 1 );?>><strong>Blog Post</strong></td>		</tr>
		<tr>
		<td><input type="checkbox" id="mo_apps_static_page"  name="mo_share_options_static_pages"  value="1"
			<?php checked( get_option('mo_share_options_enable_static_pages') == 1 );?>><strong>Static Pages</strong></td></tr>
		<tr>
					<td>
						<br>
							<hr>
							<h3>Theme Options</h3>
							<p>Please select your favourite theme for icons:</p>
							</td>
		</tr>
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"   name="mo_openid_share_theme" class="theme-checkbox" value="oval"
								<?php checked( get_option('mo_openid_share_theme') == 'oval' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/theme-1.png', __FILE__ )?>" /></td>
				
		</tr>
	
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"   class="theme-checkbox" name="mo_openid_share_theme" value="circle"
								<?php checked( get_option('mo_openid_share_theme') == 'circle' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/theme-2.png', __FILE__ )?>" /></td>
				
		</tr>
		
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"  class="theme-checkbox" name="mo_openid_share_theme" value="square"
								<?php checked( get_option('mo_openid_share_theme') == 'square' );?> /><img src="<?php echo plugins_url( 'includes/images/themes/theme-3.png', __FILE__ )?>" /></td>
		</tr>
		
		<tr>
					<td>
						<br>
							<hr>
							<h3>Customize Text For Social Share Icons</h3>
							</td>
		</tr>
		</table>
		<table class="mo_openid_display_table">
		
		<tr>
												<td><b>Enter text to show above share widget:</b></td>
												<td><input class="mo_openid_table_textbox" type="text" name="mo_openid_share_widget_customize_text"
													value="<?php echo get_option('mo_openid_share_widget_customize_text'); ?>"  /></td>
											</tr>
			
			<tr>
											
											<td><br /><input type="submit" name="submit" value="Save" style="width:100px;"
													class="button button-primary button-large" /></td>
											</tr>


								<tr>
		
										
        </table>

				
			</div>

</form>
<script>
jQuery(function() {
				jQuery('#tab1').removeClass("nav-tab-active");
				jQuery('#tab2').addClass("nav-tab-active");
				
		});
</script>
<?php
}
function mo_openid_is_customer_registered() {
			$email 			= get_option('mo_openid_admin_email');
			$phone 			= get_option('mo_openid_admin_phone');
			$customerKey 	= get_option('mo_openid_admin_customer_key');
			if( ! $email || ! $phone || ! $customerKey || ! is_numeric( trim( $customerKey ) ) ) {
				return 0;
			} else {
				return 1;
			}
}

function miniorange_openid_support(){
	global $current_user;
		get_currentuserinfo();
?>
	<div class="mo_openid_support_layout">

			<h3>Support</h3>
			<p>Need any help? Just send us a query so we can help you.</p>
			<form method="post" action="">
				<input type="hidden" name="option" value="mo_openid_contact_us_query_option" />
				<table class="mo_openid_settings_table">
					<tr>
						<td><b><font color="#FF0000">*</font>Email:</b></td>
						<td><input type="email" class="mo_openid_table_contact" required name="mo_openid_contact_us_email" value="<?php echo get_option("mo_openid_admin_email"); ?>"></td>
					</tr>
					<tr>
						<td><b>Phone:</b></td>
						<td><input type="tel" id="contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" class="mo_openid_table_contact" name="mo_openid_contact_us_phone" value="<?php echo get_option('mo_openid_admin_phone');?>"></td>
					</tr>
					<tr>
						<td><b><font color="#FF0000">*</font>Query:</b></td>
						<td><textarea class="mo_openid_table_contact" onkeypress="mo_openid_valid_query(this)" onkeyup="mo_openid_valid_query(this)" onblur="mo_openid_valid_query(this)" required name="mo_openid_contact_us_query" rows="4" style="resize: vertical;"></textarea></td>
					</tr>
				</table>
				<br>
			<input type="submit" name="submit" value="Submit Query" style="width:110px;" class="button button-primary button-large" />

			</form>
			<p>If you want custom features in the plugin, just drop an email at <a href="mailto:info@miniorange.com">info@miniorange.com</a>.</p>
		</div>
	</div>
	</div>
	</div>
	<script>
		jQuery("#contact_us_phone").intlTelInput();
		function mo_openid_valid_query(f) {
			!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
					/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
		}
	</script>
<?php
}

function mo_openid_is_curl_installed() {
		    if  (in_array  ('curl', get_loaded_extensions())) {
		        return 1;
		    } else
		        return 0;
}?>
