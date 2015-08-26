<?php

function mo_register_openid() {
	if( isset( $_GET[ 'tab' ]) && $_GET[ 'tab' ] !== 'register' ) {
		$active_tab = $_GET[ 'tab' ];
	} else if(mo_openid_is_customer_registered()) {
		$active_tab = 'login';
	} else {
		$active_tab = 'register';
	}
	
	if(mo_openid_is_curl_installed()==0){ ?>
		<p style="color:red;">(Warning: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP CURL extension</a> is not installed or disabled)</p>
	<?php
	}?>
	<?php
	if(!mo_openid_is_extension_installed('mcrypt')) { ?>
		<div id="help_openid_mcrypt_title" class="mo_openid_title_panel">
			<div style="color:red;" class="mo_openid_help_title">(Warning: PHP mcrypt extension is not installed or disabled) (Why we need it?)</div>
		</div>
		<div id="help_openid_mcrypt" class="mo_openid_help_desc" hidden>
			PHP Mcrypt extension is required to Encrypt Social Login in such a way as to make it unreadable by anyone except those possessing special knowledge (usually referred to as a "key") that allows them to change the information back to its original, readable form.
			<br/>
			Encryption is important because it allows you to securely protect your users Social Login details that you don't want anyone else to have access to.
		</div>
	<?php
	}?>
<div id="tab">
	<h2 class="nav-tab-wrapper">
		<?php if(!mo_openid_is_customer_registered()) { ?>
			<a class="nav-tab <?php echo $active_tab == 'register' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'register'), $_SERVER['REQUEST_URI'] ); ?>">Account Setup</a>
		<?php } ?>
		<a class="nav-tab <?php echo $active_tab == 'login' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'login'), $_SERVER['REQUEST_URI'] ); ?>">Social Login</a>
		<a class="nav-tab <?php echo $active_tab == 'share' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'share'), $_SERVER['REQUEST_URI'] ); ?>">Social Sharing</a>
	</h2>
</div>

<div id="mo_openid_settings">

	<div class="mo_container">
			<table style="width:100%;">
				<tr>
					<td style="vertical-align:top;width:65%;">

						<?php
							if( $active_tab == 'share' ) {
								mo_openid_other_settings();
							} else if ( $active_tab == 'register') {
								if (get_option ( 'mo_openid_verify_customer' ) == 'true') {
									mo_openid_show_verify_password_page();
								} else if (trim ( get_option ( 'mo_openid_admin_email' ) ) != '' && trim ( get_option ( 'mo_openid_admin_api_key' ) ) == '' && get_option ( 'mo_openid_new_registration' ) != 'true') {
									mo_openid_show_verify_password_page();
								} else if(get_option('mo_openid_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_openid_registration_status') == 'MO_OTP_VALIDATION_FAILURE' || get_option('mo_openid_registration_status') == 'MO_OTP_DELIVERED_FAILURE' ){
									mo_openid_show_otp_verification();
								}else if (! mo_openid_is_customer_registered()) {
									delete_option ( 'password_mismatch' );
									mo_openid_show_new_registration_page();
								}
							} else {
								mo_openid_apps_config();
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
												<td><b>&nbsp;&nbsp;Phone number:</b></td>
												<td><input class="mo_openid_table_textbox" type="tel" id="phone"
													pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" name="phone"
													title="Phone with country code eg. +1xxxxxxxxxx"
													placeholder="Phone with country code eg. +1xxxxxxxxxx"
													value="<?php echo get_option('mo_openid_admin_phone');?>" /><br/>We will call only if you need support.</td>
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
						//jQuery("#phone").intlTelInput();
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
								href="<?php echo get_option('mo_openid_host_name') . "/moas/idp/userforgotpassword"; ?>">Forgot
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
							
							<table>
									<tr>
										<td colspan="2">
											<h3>Social Login
											<input type="submit" name="submit" value="Save" style="float:right; margin-right:2%; margin-top: -3px;width:100px;" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
													class="button button-primary button-large" />
												</h3>
												
												<b>Select applications to enable login for your users. Customize your login icons using a range of shapes, themes and sizes. You can choose different places to display these icons and also customize redirect url after login.</b>
										</td>
										
									</tr>
								</table>
							
							<table class="mo_openid_settings_table">
							
							
								<h3>Select Apps</h3>
								<p>Select applications to enable social login</p>
							
								<tr>
											<td class="mo_openid_table_td_checkbox"><input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> id="facebook_enable" class="app_enable" name="mo_openid_facebook_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_facebook_enable') == 1 );?> /><strong>Facebook</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> id="google_enable" class="app_enable" name="mo_openid_google_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_google_enable') == 1 );?> /><strong>Google</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
										id="instagram_enable" class="app_enable" name="mo_openid_instagram_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_instagram_enable') == 1 );?> /><strong>Instagram</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> id="linkedin_enable" class="app_enable" name="mo_openid_linkedin_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_linkedin_enable') == 1 );?> /><strong>LinkedIn</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
										id="amazon_enable" class="app_enable" name="mo_openid_amazon_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_amazon_enable') == 1 );?> /><strong>Amazon</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
										id="salesforce_enable" class="app_enable" name="mo_openid_salesforce_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_salesforce_enable') == 1 );?> /><strong>Salesforce</strong>
										&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
										id="windowslive_enable" class="app_enable" name="mo_openid_windowslive_enable" value="1" onchange="previewLoginIcons();"
										<?php checked( get_option('mo_openid_windowslive_enable') == 1 );?> /><strong>Windows Live</strong>
									</td>
								</td>
								<tr>
								
								
								
					<td>
						<br>
							<hr>
							<h3>Customize Login Icons</h3>
							<p>Customize shape, theme and size of social login icons</p>
							</td>
		</tr>
		<tr>
		<td>
			<b>Shape</b>
			<b style="margin-left:130px;">Theme</b>
			<b style="margin-left:130px;">Space between Icons</b>
			<b style="margin-left:86px;">Size of Icons</b>
			</td>
		</tr>
		<tr>
				
				<td class="mo_openid_table_td_checkbox">
					<input type="radio"    name="mo_openid_login_theme" value="circle" onclick="checkLoginButton();moLoginPreview(document.getElementById('mo_login_icon_size').value ,'circle',setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)"
						<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
								<?php checked( get_option('mo_openid_login_theme') == 'circle' );?> />Round
						
				<span style="margin-left:106px;">
					<input type="radio" id="mo_openid_login_default_radio"  name="mo_openid_login_custom_theme" value="default" onclick="checkLoginButton();moLoginPreview(setSizeOfIcons(), setLoginTheme(),'default',document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)"
								<?php checked( get_option('mo_openid_login_custom_theme') == 'default' );?> <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>Default
					
				</span>
				
				<span  style="margin-left:111px;">
						<input style="width:50px" onkeyup="moLoginSpaceValidate(this)" id="mo_login_icon_space" name="mo_login_icon_space" type="text" value="<?php echo get_option('mo_login_icon_space')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
						<input id="mo_login_space_plus" type="button" value="+" onmouseup="moLoginPreview(setSizeOfIcons() ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
						<input id="mo_login_space_minus" type="button" value="-" onmouseup="moLoginPreview(setSizeOfIcons()  ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
				</span>
					
					
				<span id="commontheme" style="margin-left:115px">
				<input style="width:50px" id="mo_login_icon_size" onkeyup="moLoginSizeValidate(this)" name="mo_login_icon_custom_size" type="text" value="<?php echo get_option('mo_login_icon_custom_size')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_size_plus" type="button" value="+" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_size_minus" type="button" value="-" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_size').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				
				</span>
				<span style="margin-left:115px" class="longbuttontheme">Width:&nbsp;
				<input style="width:50px" id="mo_login_icon_width" onkeyup="moLoginWidthValidate(this)" name="mo_login_icon_custom_width" type="text" value="<?php echo get_option('mo_login_icon_custom_width')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_width_plus" type="button" value="+" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_width_minus" type="button" value="-" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_width').value ,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				
				</span>
				
				
				</td>			
		</tr>
	
		<tr>
				<td class="mo_openid_table_td_checkbox">
				<input type="radio"   name="mo_openid_login_theme"  value="oval" onclick="checkLoginButton();moLoginPreview(document.getElementById('mo_login_icon_size').value,'oval',setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_size').value )"
						<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
								<?php checked( get_option('mo_openid_login_theme') == 'oval' );?> />Rounded Edges	

				<span style="margin-left:50px;">
						<input type="radio" id="mo_openid_login_custom_radio"  name="mo_openid_login_custom_theme" value="custom" onclick="checkLoginButton();moLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
								<?php checked( get_option('mo_openid_login_custom_theme') == 'custom' );?> />Custom Background*
								
						</span>	
								
					<span style="margin-left:249px" class="longbuttontheme" >Height:
				<input style="width:50px" id="mo_login_icon_height" onkeyup="moLoginHeightValidate(this)" name="mo_login_icon_custom_height" type="text" value="<?php echo get_option('mo_login_icon_custom_height')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_height_plus" type="button" value="+" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				<input id="mo_login_height_minus" type="button" value="-" onmouseup="moLoginPreview(document.getElementById('mo_login_icon_width').value,setLoginTheme(),setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				
				</span>
				</td>
		</tr>
		
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio"   name="mo_openid_login_theme" value="square" onclick="checkLoginButton();moLoginPreview(document.getElementById('mo_login_icon_size').value ,'square',setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_size').value )"
						<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
								<?php checked( get_option('mo_openid_login_theme') == 'square' );?> />Square
					
						<span style="margin-left:113px;">
						<input id="mo_login_icon_custom_color" style="width:135px;" name="mo_login_icon_custom_color"  class="color" value="<?php echo get_option('mo_login_icon_custom_color')?>" onchange="moLoginPreview(setSizeOfIcons(), setLoginTheme(),'custom',document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
						</span>
				</td>
		</tr>
		<tr>
				<td class="mo_openid_table_td_checkbox">
						<input type="radio" id="iconwithtext"   name="mo_openid_login_theme" value="longbutton" onclick="checkLoginButton();moLoginPreview(document.getElementById('mo_login_icon_width').value ,'longbutton',setLoginCustomTheme(),document.getElementById('mo_login_icon_custom_color').value,document.getElementById('mo_login_icon_space').value,document.getElementById('mo_login_icon_height').value)"
						<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
								<?php checked( get_option('mo_openid_login_theme') == 'longbutton' );?> />Long Button with Text</td>
		</tr>
		<tr>
			<td>	<br><b>Preview : </b><br/><span hidden id="no_apps_text">No apps selected</span>
				<div>
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_google" src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_facebook" src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_linkedin" src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_instagram" src="<?php echo plugins_url( 'includes/images/icons/instagram.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_amazon" src="<?php echo plugins_url( 'includes/images/icons/amazon.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_salesforce" src="<?php echo plugins_url( 'includes/images/icons/salesforce.png', __FILE__ )?>" />
					<img class="mo_login_icon_preview" id="mo_login_icon_preview_windowslive" src="<?php echo plugins_url( 'includes/images/icons/windowslive.png', __FILE__ )?>" />
				</div>
				
				<div>
					<a id="mo_login_button_preview_google" class="btn btn-block btn-defaulttheme btn-social btn-google btn-custom-size"> <i class="fa fa-google-plus"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Google</a>
					<a id="mo_login_button_preview_facebook" class="btn btn-block btn-defaulttheme btn-social btn-facebook btn-custom-size"> <i class="fa fa-facebook"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Facebook</a>
					<a id="mo_login_button_preview_linkedin" class="btn btn-block btn-defaulttheme btn-social btn-linkedin btn-custom-size"> <i class="fa fa-linkedin"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> LinkedIn</a>
					<a id="mo_login_button_preview_instagram" class="btn btn-block btn-defaulttheme btn-social btn-instagram btn-custom-size"> <i class="fa fa-instagram"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Instagram</a>
					<a id="mo_login_button_preview_amazon" class="btn btn-block btn-defaulttheme btn-social btn-soundcloud btn-custom-size"> <i class="fa fa-amazon"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Amazon</a>
					<a id="mo_login_button_preview_salesforce" class="btn btn-block btn-defaulttheme btn-social btn-vimeo btn-custom-size"> <i class="fa fa-cloud"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Salesforce</a>
					<a id="mo_login_button_preview_windowslive" class="btn btn-block btn-defaulttheme btn-social btn-microsoft btn-custom-size"> <i class="fa fa-windows"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Windows</a>
				</div>
				
				<div>
					<i class="mo_custom_login_icon_preview fa fa-google-plus" id="mo_custom_login_icon_preview_google"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_login_icon_preview fa fa-facebook" id="mo_custom_login_icon_preview_facebook"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_login_icon_preview fa fa-linkedin" id="mo_custom_login_icon_preview_linkedin" style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_login_icon_preview fa fa-instagram" id="mo_custom_login_icon_preview_instagram" style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_login_icon_preview fa fa-amazon" id="amazoncustom" style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_login_icon_preview fa fa-cloud" id="salesforcecustom" style="margin-bottom:-10px;color:#ffffff;text-align:center;margin-top:5px;" ></i>
					<i class="mo_custom_login_icon_preview fa fa-windows" id="mo_custom_login_icon_preview_windows" style="color:#ffffff;text-align:center;margin-top:5px;" ></i>
				</div>
				
				<div>
					<a id="mo_custom_login_button_preview_google" class="btn btn-block btn-customtheme btn-social   btn-custom-size"> <i class="fa fa-google-plus"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Google</a>
					<a id="mo_custom_login_button_preview_facebook" class="btn btn-block btn-customtheme btn-social  btn-custom-size"> <i class="fa fa-facebook"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Facebook</a>
					<a id="mo_custom_login_button_preview_linkedin" class="btn btn-block btn-customtheme btn-social  btn-custom-size"> <i class="fa fa-linkedin"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> LinkedIn</a>
					<a id="mo_custom_login_button_preview_instagram" class="btn btn-block btn-customtheme btn-social  btn-custom-size"> <i class="fa fa-instagram"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Instagram</a>
					<a id="mo_custom_login_button_preview_amazon" class="btn btn-block btn-customtheme btn-social  btn-custom-size"><i class="fa fa-amazon"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Amazon</a>
					<a id="mo_custom_login_button_preview_salesforce" class="btn btn-block btn-customtheme btn-social  btn-custom-size"> <i class="fa fa-cloud"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Salesforce</a>
					<a id="mo_custom_login_button_preview_windows" class="btn btn-block btn-customtheme btn-social  btn-custom-size"> <i class="fa fa-windows"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Windows</a>
				</div>
		</td>
	</tr>
	<tr>
		<td><br>
		<strong>*NOTE:</strong><br/>Custom background: This will change the background color of login icons.
		</td>
	</tr>
	<tr>
									<td>
									<br>
										<hr>
										<h3>Display Options</h3>
											<b>Select the options where you want to display the social login icons</b>
										</td>
								</tr>

											<tr>
												<td class="mo_openid_table_td_checkbox">
												<input type="checkbox" id="default_login_enable" name="mo_openid_default_login_enable" value="1"
													<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>	<?php checked( get_option('mo_openid_default_login_enable') == 1 );?> />Default Login Form</td>
											</tr>
											<tr>
												<td class="mo_openid_table_td_checkbox">
												<input type="checkbox" id="default_register_enable" name="mo_openid_default_register_enable" value="1"
												<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>	<?php checked( get_option('mo_openid_default_register_enable') == 1 );?> />Default Registration Form</td>
											</tr>
											<tr>
												<td class="mo_openid_table_td_checkbox">
													<input type="checkbox" id="default_comment_enable" name="mo_openid_default_comment_enable" value="1"
													<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>	<?php checked( get_option('mo_openid_default_comment_enable') == 1 );?> />Comment Form</td>
											</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td>
										<b>Redirect URL after login:</b>
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" id="login_redirect_same_page" name="mo_openid_login_redirect" value="same"
										<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_login_redirect') == 'same' );?> />Same page where user logged in
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" id="login_redirect_homepage" name="mo_openid_login_redirect" value="homepage"
										<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_login_redirect') == 'homepage' );?> />Homepage
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" id="login_redirect_dashboard" name="mo_openid_login_redirect" value="dashboard"
										<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_login_redirect') == 'dashboard' );?> />Account dashboard
									</td>
								</tr>
								<tr>
									<td>
										<input type="radio" id="login_redirect_customurl" name="mo_openid_login_redirect" value="custom"
										<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_login_redirect') == 'custom' );?> />Custom URL
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="url" id="login_redirect_url" style="width:50%" name="mo_openid_login_redirect_url" value="<?php echo get_option('mo_openid_login_redirect_url')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
									</td>
								</tr>
				<script>
					var tempHorSize = '<?php echo get_option('mo_login_icon_custom_size') ?>';
					var tempHorTheme = '<?php echo get_option('mo_openid_login_theme') ?>';
					var tempHorCustomTheme = '<?php echo get_option('mo_openid_login_custom_theme') ?>';
					var tempHorCustomColor = '<?php echo get_option('mo_login_icon_custom_color') ?>';
					var tempHorSpace = '<?php echo get_option('mo_login_icon_space')?>';
					var tempHorHeight = '<?php echo get_option('mo_login_icon_custom_height') ?>';
						function moLoginIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<60?r.value++:"subtract"==t&&r.value>20&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					
						function moLoginSpaceIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<60?r.value++:"subtract"==t&&r.value>0&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					
						function moLoginWidthIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<1000?r.value++:"subtract"==t&&r.value>200&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					
						function moLoginHeightIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<50?r.value++:"subtract"==t&&r.value>35&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					
					moLoginIncrement(document.getElementById('mo_login_size_plus'), "add", document.getElementById('mo_login_icon_size'), 300, 0.7);
					moLoginIncrement(document.getElementById('mo_login_size_minus'), "subtract", document.getElementById('mo_login_icon_size'), 300, 0.7);
					
					moLoginSpaceIncrement(document.getElementById('mo_login_space_plus'), "add", document.getElementById('mo_login_icon_space'), 300, 0.7);
					moLoginSpaceIncrement(document.getElementById('mo_login_space_minus'), "subtract", document.getElementById('mo_login_icon_space'), 300, 0.7);
					
					moLoginWidthIncrement(document.getElementById('mo_login_width_plus'), "add", document.getElementById('mo_login_icon_width'), 300, 0.7);
					moLoginWidthIncrement(document.getElementById('mo_login_width_minus'), "subtract", document.getElementById('mo_login_icon_width'), 300, 0.7);
					
					moLoginHeightIncrement(document.getElementById('mo_login_height_plus'), "add", document.getElementById('mo_login_icon_height'), 300, 0.7);
					moLoginHeightIncrement(document.getElementById('mo_login_height_minus'), "subtract", document.getElementById('mo_login_icon_height'), 300, 0.7);
					
					function setLoginTheme(){return jQuery('input[name=mo_openid_login_theme]:checked', '#form-apps').val();}
					function setLoginCustomTheme(){return jQuery('input[name=mo_openid_login_custom_theme]:checked', '#form-apps').val();}
					function setSizeOfIcons(){
							
								if((jQuery('input[name=mo_openid_login_theme]:checked', '#form-apps').val()) == 'longbutton'){
									//alert(document.getElementById('mo_login_icon_width').value);
									return document.getElementById('mo_login_icon_width').value;
								}else{
									//alert(document.getElementById('mo_login_icon_size').value);
									return document.getElementById('mo_login_icon_size').value;
								}
					}
					moLoginPreview(setSizeOfIcons(),tempHorTheme,tempHorCustomTheme,tempHorCustomColor,tempHorSpace,tempHorHeight);	
					
					function moLoginPreview(t,r,l,p,n,h){
									if(l == 'default'){
										if(r == 'longbutton'){
											var a = "btn-defaulttheme";
										//jQuery("."+a).css("padding-left",(t-138)+"px");
										//jQuery("."+a).css("padding-right",(t-138)+"px");
										jQuery("."+a).css("width",t+"px");
										jQuery("."+a).css("padding-top",(h-29)+"px");
										jQuery("."+a).css("padding-bottom",(h-29)+"px");
										jQuery(".fa").css("padding-top",(h-35)+"px");
										jQuery("."+a).css("margin-bottom",(n-5)+"px");
										}else{
											//alert("njkvdf");
											var a="mo_login_icon_preview";
											jQuery("."+a).css("margin-left",(n-4)+"px");
											
											if(r=="circle"){
												jQuery("."+a).css({height:t,width:t});
												jQuery("."+a).css("borderRadius","999px");
											}else if(r=="oval"){
												jQuery("."+a).css("borderRadius","5px");
												jQuery("."+a).css({height:t,width:t});
											}else if(r=="square"){
												jQuery("."+a).css("borderRadius","0px");
												jQuery("."+a).css({height:t,width:t});
											}
										}
									}
									else if(l == 'custom'){
										if(r == 'longbutton'){
											
												var a = "btn-customtheme";
												//jQuery("."+a).css("padding-left",(t-138)+"px");
												//jQuery("."+a).css("padding-right",(t-138)+"px");
												jQuery("."+a).css("width",(t)+"px");
												jQuery("."+a).css("padding-top",(h-29)+"px");
												jQuery("."+a).css("padding-bottom",(h-29)+"px");
												jQuery(".fa").css("padding-top",(h-35)+"px");
												jQuery("."+a).css("margin-bottom",(n-5)+"px");
												jQuery("."+a).css("background","#"+p);
										}else{
											var a="mo_custom_login_icon_preview";
											jQuery("."+a).css({height:t-8,width:t});
											jQuery("."+a).css("padding-top","8px");
											jQuery("."+a).css("margin-left",(n-4)+"px");
											
											if(r=="circle"){
												jQuery("."+a).css("borderRadius","999px");
											}else if(r=="oval"){
												jQuery("."+a).css("borderRadius","5px");
												}else if(r=="square"){
												jQuery("."+a).css("borderRadius","0px");
											}
											jQuery("."+a).css("background","#"+p);
											jQuery("."+a).css("font-size",(t-16)+"px");
										}
									}
									
								
								previewLoginIcons();
								
					}
					
					function checkLoginButton(){
								if(document.getElementById('iconwithtext').checked) {
									if(setLoginCustomTheme() == 'default'){
										 jQuery(".mo_login_icon_preview").hide();
										 jQuery(".mo_custom_login_icon_preview").hide();
										 jQuery(".btn-customtheme").hide();
										 jQuery(".btn-defaulttheme").show();
									}else if(setLoginCustomTheme() == 'custom'){
										jQuery(".mo_login_icon_preview").hide();
										 jQuery(".mo_custom_login_icon_preview").hide();
										 jQuery(".btn-defaulttheme").hide();
											jQuery(".btn-customtheme").show();
									}
									jQuery("#commontheme").hide();
									jQuery(".longbuttontheme").show();
								}else {
									
									if(setLoginCustomTheme() == 'default'){
										jQuery(".mo_login_icon_preview").show();
										jQuery(".btn-defaulttheme").hide();
										jQuery(".btn-customtheme").hide();
										jQuery(".mo_custom_login_icon_preview").hide();
									}else if(setLoginCustomTheme() == 'custom'){
										jQuery(".mo_login_icon_preview").hide();
										 jQuery(".mo_custom_login_icon_preview").show();
										 jQuery(".btn-defaulttheme").hide();
										 jQuery(".btn-customtheme").hide();
									}
									jQuery("#commontheme").show();
									jQuery(".longbuttontheme").hide();
								}
								previewLoginIcons();
						}	
						
						function previewLoginIcons() {
								var flag = 0;
								if (document.getElementById('google_enable').checked)   {
									flag = 1;
										if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
											jQuery("#mo_login_icon_preview_google").show();
										if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
											jQuery("#mo_custom_login_icon_preview_google").show();
										if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
											jQuery("#mo_login_button_preview_google").show();
										if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
											jQuery("#mo_custom_login_button_preview_google").show();
								} else if(!document.getElementById('google_enable').checked){
									jQuery("#mo_login_icon_preview_google").hide();
									jQuery("#mo_custom_login_icon_preview_google").hide();
									jQuery("#mo_login_button_preview_google").hide();
									jQuery("#mo_custom_login_button_preview_google").hide();
									
								}
								
								if (document.getElementById('facebook_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_icon_preview_facebook").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_icon_preview_facebook").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_button_preview_facebook").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_button_preview_facebook").show();
								}else if(!document.getElementById('facebook_enable').checked){
									jQuery("#mo_login_icon_preview_facebook").hide();
									jQuery("#mo_custom_login_icon_preview_facebook").hide();
									jQuery("#mo_login_button_preview_facebook").hide();
									jQuery("#mo_custom_login_button_preview_facebook").hide();
								}
								
								if (document.getElementById('linkedin_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_icon_preview_linkedin").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_icon_preview_linkedin").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)	
										jQuery("#mo_login_button_preview_linkedin").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)	
										jQuery("#mo_custom_login_button_preview_linkedin").show();
								} else if(!document.getElementById('linkedin_enable').checked){
									jQuery("#mo_login_icon_preview_linkedin").hide();
									jQuery("#mo_custom_login_icon_preview_linkedin").hide();
									jQuery("#mo_login_button_preview_linkedin").hide();
									jQuery("#mo_custom_login_button_preview_linkedin").hide();
								}
								
								if (document.getElementById('instagram_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_icon_preview_instagram").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_icon_preview_instagram").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_button_preview_instagram").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_button_preview_instagram").show();
								} else if(!document.getElementById('instagram_enable').checked){
									jQuery("#mo_login_icon_preview_instagram").hide();
									jQuery("#mo_custom_login_icon_preview_instagram").hide();
									jQuery("#mo_login_button_preview_instagram").hide();
									jQuery("#mo_custom_login_button_preview_instagram").hide();
								}
								
								if (document.getElementById('amazon_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checkedd)
										jQuery("#mo_login_icon_preview_amazon").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#amazoncustom").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked) {
										jQuery("#mo_login_button_preview_amazon").show();
										jQuery("#mo_login_icon_preview_amazon").hide();
									}
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_button_preview_amazon").show();
								}else if(!document.getElementById('amazon_enable').checked){
									jQuery("#mo_login_icon_preview_amazon").hide();
									jQuery("#amazoncustom").hide();
									jQuery("#mo_login_button_preview_amazon").hide();
									jQuery("#mo_custom_login_button_preview_amazon").hide();
								}
								
								if (document.getElementById('salesforce_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_icon_preview_salesforce").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#salesforcecustom").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_button_preview_salesforce").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_button_preview_salesforce").show();
								} else if(!document.getElementById('salesforce_enable').checked){
									jQuery("#mo_login_icon_preview_salesforce").hide();
									jQuery("#salesforcecustom").hide();
									jQuery("#mo_login_button_preview_salesforce").hide();
									jQuery("#mo_custom_login_button_preview_salesforce").hide();
								}
								
								if (document.getElementById('windowslive_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_login_default_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_icon_preview_windowslive").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && !document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_icon_preview_windows").show();
									if(document.getElementById('mo_openid_login_default_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_login_button_preview_windowslive").show();
									if(document.getElementById('mo_openid_login_custom_radio').checked && document.getElementById('iconwithtext').checked)
										jQuery("#mo_custom_login_button_preview_windows").show();
								} else if(!document.getElementById('windowslive_enable').checked){
									jQuery("#mo_login_icon_preview_windowslive").hide();
									jQuery("#mo_custom_login_icon_preview_windows").hide();
									jQuery("#mo_login_button_preview_windowslive").hide();
									jQuery("#mo_custom_login_button_preview_windows").hide();
								}
								
								if(flag) {
									jQuery("#no_apps_text").hide();
								} else {
									jQuery("#no_apps_text").show();
								}
						}
						checkLoginButton();
				</script>
		
		
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
			<td><input class="mo_openid_table_textbox" type="text" name="mo_openid_login_widget_customize_text" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> value="<?php echo get_option('mo_openid_login_widget_customize_text'); ?>" /></td>
		</tr>
			
		
			<tr>
												<td><b>Enter text to show on your login buttons (If you have selected shape 4 from 'Customize Login Icons' section):</b></td>
												<td><input class="mo_openid_table_textbox" type="text" name="mo_openid_login_button_customize_text" 
													<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> value="<?php echo get_option('mo_openid_login_button_customize_text'); ?>"  /></td>
											</tr>
		
							<tr>
											
											<td><br /><input type="submit" name="submit" value="Save" style="width:100px;" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
													class="button button-primary button-large" /></td>
											</tr>


								<tr>
									<td colspan="2">
										<hr>
										<p>
											<h3>Add Login Icons</h3>
											You can add login icons in the following areas from <strong>Display Options</strong>. For other areas(widget areas), use Login Widget.
										<ol>
											<li>Default Login Form: This option places login icons below the default login form on wp-login.</li>
											<li>Default Registration Form: This option places login icons below the default registration form.</li>
											<li>Comment Form: This option places login icons above the comment section of all your posts.</li>
										</ol>
										
											<h3>Add Login Icons as Widget</h3>

										<ol>
											<li>Go to Appearance->Widgets. Among the available widgets you
												will find miniOrange Social Login Widget, drag it to the widget area where
												you want it to appear.</li>
											<li>Now logout and go to your site. You will see app icon for which you enabled login.</li>
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
								<td colspan="2"><input class="mo_openid_table_textbox" autofocus="true" type="text" name="otp_token" required placeholder="Enter OTP" style="width:61%;" pattern="[0-9]{6,8}" title="Only 6 digit numbers are allowed"/>
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
	
								<table>
									<tr>
										<td colspan="2">
											<h3>Social Sharing
											<input type="submit" name="submit" value="Save" style="width:100px;float:right;margin-right:2%"
											class="button button-primary button-large" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
												</h3>
												<b>Select applications to add share icons. Customize sharing icons by using a range of shapes, themes and sizes to suit to your website. You can also choose different places to display these icons. Additionally, place vertical floating icons on your pages.</b>
										</td>
										
									</tr>
								</table>
	
	<table class="mo_openid_settings_table">
		<h3>Select Social Apps</h3>
		<p>Select applications to enable social sharing</p>
		<tr>
			<td class="mo_openid_table_td_checkbox">
				<input type="checkbox" id="facebook_share_enable" class="app_enable" name="mo_openid_facebook_share_enable" value="1" 
				onclick="addSelectedApps();" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_facebook_share_enable') == 1 );?> />
				<strong>Facebook</strong>
				&nbsp;&nbsp;&nbsp;&nbsp;
				
				<input type="checkbox" id="google_share_enable" class="app_enable" name="mo_openid_google_share_enable" value="1" onclick="addSelectedApps();"
				<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_google_share_enable') == 1 );?> />
				<strong>Google</strong>
				&nbsp;&nbsp;&nbsp;&nbsp;
			
				<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
				id="twitter_share_enable" class="app_enable" name="mo_openid_twitter_share_enable" value="1" onclick="addSelectedApps();"
				<?php checked( get_option('mo_openid_twitter_share_enable') == 1 );?> />
				<strong>Twitter </strong>
				&nbsp;&nbsp;&nbsp;&nbsp;
			
					<input type="checkbox" id="linkedin_share_enable" class="app_enable" name="mo_openid_linkedin_share_enable" value="1" onclick="addSelectedApps();" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
					<?php checked( get_option('mo_openid_linkedin_share_enable') == 1 );?> />
					<strong>LinkedIn</strong>
					&nbsp;&nbsp;&nbsp;&nbsp;
				
				<input type="checkbox" id="pinterest_share_enable" class="app_enable" name="mo_openid_pinterest_share_enable" value="1" onclick="addSelectedApps();"
				<?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
				<?php checked( get_option('mo_openid_pinterest_share_enable') == 1 );?> />
				<strong>Pinterest </strong>
				&nbsp;&nbsp;&nbsp;&nbsp;
			
				<input type="checkbox" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
				id="reddit_share_enable" class="app_enable" name="mo_openid_reddit_share_enable" value="1" onclick="addSelectedApps();"
				<?php checked( get_option('mo_openid_reddit_share_enable') == 1 );?> />
				<strong>Reddit </strong>
			</td>
		</tr>
			
									

		
		
		<tr>
			<td>
				<br>
				<hr>
				<h3>Customize Sharing Icons</h3>
				<p>Customize shape, size and background for sharing icons</p>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width:98%">
					<tr>
						<td><b>Shape</b></td>
						<td><b>Theme</b></td>
						<td><b>Space between Icons</b></td>
						<td><b>Size of Icons</b></td>
					</tr>
					<tr>
						<td style="width:inherit;"> <!-- Shape radio buttons -->
							<!-- Round -->
							<input type="radio" id="mo_openid_share_theme_circle"  <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>  name="mo_openid_share_theme" value="circle" onclick="tempHorShape = 'circle';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, 'circle', setCustomTheme(), document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value, document.getElementById('mo_sharing_icon_custom_font').value)" <?php checked( get_option('mo_openid_share_theme') == 'circle' );?> />Round
							
						</td>
						<td><!-- Theme radio buttons -->
							<!-- Default -->
							<input type="radio" id="mo_openid_default_background_radio"  name="mo_openid_share_custom_theme" value="default" onclick="tempHorTheme = 'default';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(), 'default', document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value, document.getElementById('mo_sharing_icon_custom_font').value)"
							<?php checked( get_option('mo_openid_share_custom_theme') == 'default' );?> <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>Default
						</td>
						<td> <!-- Size between icons buttons-->
							<input style="width:50px" onkeyup="moSharingSpaceValidate(this)" id="mo_sharing_icon_space" name="mo_sharing_icon_space" type="text" value="<?php echo get_option('mo_sharing_icon_space')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
							<input id="mo_sharing_space_plus" type="button" value="+" onmouseup="moSharingPreview('horizontal',document.getElementById('mo_sharing_icon_size').value ,setTheme(),setCustomTheme(),document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
							<input id="mo_sharing_space_minus" type="button" value="-" onmouseup="moSharingPreview('horizontal',document.getElementById('mo_sharing_icon_size').value ,setTheme(),setCustomTheme(),document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
						</td>
						<td> <!-- Size buttons-->
							<input style="width:50px" id="mo_sharing_icon_size" onkeyup="moSharingSizeValidate(this)" name="mo_sharing_icon_custom_size" type="text" value="<?php echo get_option('mo_sharing_icon_custom_size')?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				
							<input id="mo_sharing_size_plus" type="button" value="+" onmouseup="tempHorSize = document.getElementById('mo_sharing_icon_size').value;moSharingPreview('horizontal',document.getElementById('mo_sharing_icon_size').value , setTheme(), setCustomTheme(), document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value,document.getElementById('mo_sharing_icon_custom_font').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
				
							<input id="mo_sharing_size_minus" type="button" value="-" onmouseup="tempHorSize = document.getElementById('mo_sharing_icon_size').value;moSharingPreview('horizontal',document.getElementById('mo_sharing_icon_size').value ,setTheme(), setCustomTheme(), document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value, document.getElementById('mo_sharing_icon_custom_font').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
						</td>
					</tr>
					<tr>
						<td> <!-- Shape radio buttons -->
							<!-- Rounded Edges -->
							<input type="radio"   name="mo_openid_share_theme"  value="oval" onclick="tempHorShape = 'circle';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, 'oval', setCustomTheme(), document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_share_theme') == 'oval' );?> />Rounded Edges
						</td>
						<td> <!-- Theme radio buttons -->
							<!-- Custom background -->
							
							<input type="radio" id="mo_openid_custom_background_radio"  name="mo_openid_share_custom_theme" value="custom" onclick="tempHorTheme = 'custom';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(),'custom',document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
							<?php checked( get_option('mo_openid_share_custom_theme') == 'custom' );?> />Custom background*
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td> <!-- Shape radio buttons -->
							<!-- Square -->
							<input type="radio"   name="mo_openid_share_theme" value="square" onclick="tempHorShape = 'square';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(), setCustomTheme(), document.getElementById('mo_sharing_icon_custom_color').value, document.getElementById('mo_sharing_icon_space').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_share_theme') == 'square' );?> />Square
						</td>
						<td> <!-- Theme radio buttons -->
							<!-- Custom background textbox -->
							
							<input id="mo_sharing_icon_custom_color" name="mo_sharing_icon_custom_color" class="color" value="<?php echo get_option('mo_sharing_icon_custom_color')?>" onchange="moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(),setCustomTheme(),document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value,document.getElementById('mo_sharing_icon_custom_font').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>>
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td> <!-- Theme radio buttons -->
							<!-- No background -->
							<input type="radio" id="mo_openid_no_background_radio"  name="mo_openid_share_custom_theme" value="customFont" onclick="tempHorTheme = 'custom';moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(),'customFont',document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value,document.getElementById('mo_sharing_icon_custom_font').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_openid_share_custom_theme') == 'customFont' );?> />No background*
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td> <!-- Theme radio buttons -->
							<!-- No background textbox-->
							<input id="mo_sharing_icon_custom_font" name="mo_sharing_icon_custom_font"  class="color" value="<?php echo get_option('mo_sharing_icon_custom_font')?>" onchange="moSharingPreview('horizontal', document.getElementById('mo_sharing_icon_size').value, setTheme(),setCustomTheme(),document.getElementById('mo_sharing_icon_custom_color').value,document.getElementById('mo_sharing_icon_space').value,document.getElementById('mo_sharing_icon_custom_font').value,document.getElementById('mo_sharing_icon_custom_font').value)" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
						</td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>					
		
		<tr><td>&nbsp;</td></tr>		
		
		<tr>
			<td><b>Preview: </b><br/><span hidden id="no_apps_text">No apps selected</span></td>
		</tr>
		
		<tr>
			<td>
		
				<div>
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_facebook" src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" />
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_google" src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" />
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_twitter" src="<?php echo plugins_url( 'includes/images/icons/twitter.png', __FILE__ )?>" />
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_linkedin" src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" />
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_pinterest" src="<?php echo plugins_url( 'includes/images/icons/pininterest.png', __FILE__ )?>" />
					<img class="mo_sharing_icon_preview" id="mo_sharing_icon_preview_reddit" src="<?php echo plugins_url( 'includes/images/icons/reddit.png', __FILE__ )?>" />
					
				</div>
		
				<div>
					<i class="mo_custom_sharing_icon_preview fa fa-facebook" id="mo_custom_sharing_icon_preview_facebook"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_preview fa fa-google-plus" id="mo_custom_sharing_icon_preview_google"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_preview fa fa-twitter" id="mo_custom_sharing_icon_preview_twitter" style="color:#ffffff;text-align:center;margin-top:5px;" ></i>
					<i class="mo_custom_sharing_icon_preview fa fa-linkedin" id="mo_custom_sharing_icon_preview_linkedin" style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_preview fa fa-pinterest" id="mo_custom_sharing_icon_preview_pinterest"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_preview fa fa-reddit" id="mo_custom_sharing_icon_preview_reddit"  style="color:#ffffff;text-align:center;margin-top:5px;"></i>
					
				</div>
											
				<div>
					<i class="mo_custom_sharing_icon_font_preview fa fa-facebook" id="mo_custom_sharing_icon_font_preview_facebook"  style="text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_font_preview fa fa-google" id="mo_custom_sharing_icon_font_preview_google"  style="text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_font_preview fa fa-twitter" id="mo_custom_sharing_icon_font_preview_twitter" style="text-align:center;margin-top:5px;" ></i>
					<i class="mo_custom_sharing_icon_font_preview fa fa-linkedin" id="mo_custom_sharing_icon_font_preview_linkedin" style="text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_font_preview fa fa-pinterest" id="mo_custom_sharing_icon_font_preview_pinterest"  style="text-align:center;margin-top:5px;"></i>
					<i class="mo_custom_sharing_icon_font_preview fa fa-reddit" id="mo_custom_sharing_icon_font_preview_reddit"  style="text-align:center;margin-top:5px;"></i>
					
				</div>
				<!--	<img id="mo_sharing_icon_preview" src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" />-->
					
				<!--	<i class="fa fa-facebook" style="color:#ffffff;text-align:center;margin-top:5px;" id="mo_custom_sharing_icon_preview" />-->
	
			</td>
		</tr>
		
		<script>
					var tempHorSize = '<?php echo get_option('mo_sharing_icon_custom_size') ?>';
					var tempHorShape = '<?php echo get_option('mo_openid_share_theme') ?>';
					var tempHorTheme = '<?php echo get_option('mo_openid_share_custom_theme') ?>';
					var tempbackColor = '<?php echo get_option('mo_sharing_icon_custom_color')?>';
					var tempHorSpace = '<?php echo get_option('mo_sharing_icon_space')?>';
					var tempHorFontColor = '<?php echo get_option('mo_sharing_icon_custom_font')?>';
					function moSharingIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<60?r.value++:"subtract"==t&&r.value>10&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					
					moSharingIncrement(document.getElementById('mo_sharing_size_plus'), "add", document.getElementById('mo_sharing_icon_size'), 300, 0.7);
					moSharingIncrement(document.getElementById('mo_sharing_size_minus'), "subtract", document.getElementById('mo_sharing_icon_size'), 300, 0.7);
					
					function moSharingSpaceIncrement(e,t,r,a,i){
						var h,s,c=!1,_=a;s=function(){
							"add"==t&&r.value<50?r.value++:"subtract"==t&&r.value>0&&r.value--,h=setTimeout(s,_),_>20&&(_*=i),c||(document.onmouseup=function(){clearTimeout(h),document.onmouseup=null,c=!1,_=a},c=!0)},e.onmousedown=s}
					moSharingSpaceIncrement(document.getElementById('mo_sharing_space_plus'), "add", document.getElementById('mo_sharing_icon_space'), 300, 0.7);
					moSharingSpaceIncrement(document.getElementById('mo_sharing_space_minus'), "subtract", document.getElementById('mo_sharing_icon_space'), 300, 0.7);
					
					
					function setTheme(){return jQuery('input[name=mo_openid_share_theme]:checked', '#settings_form').val();}
					function setCustomTheme(){return jQuery('input[name=mo_openid_share_custom_theme]:checked', '#settings_form').val();}
		</script>	
		
		

		<script type="text/javascript">
				
				var selectedApps = [];
		
					
				
						function moSharingPreview(e,t,r,w,h,n,x){
							
							if("default"==w){
								var a="mo_sharing_icon_preview";
								jQuery('.mo_sharing_icon_preview').show();
								jQuery('.mo_custom_sharing_icon_preview').hide();
								jQuery('.mo_custom_sharing_icon_font_preview').hide();
								jQuery("."+a).css({height:t,width:t});
								jQuery("."+a).css("font-size",(t-10)+"px");
								jQuery("."+a).css("margin-left",(n-4)+"px");
								
								if(r=="circle"){
								jQuery("."+a).css("borderRadius","999px");
								}else if(r=="oval"){
								jQuery("."+a).css("borderRadius","5px");
								}else if(r=="square"){
								jQuery("."+a).css("borderRadius","0px");
								}
								
							}
							else if(w == "custom"){
								var a="mo_custom_sharing_icon_preview";
								jQuery('.mo_sharing_icon_preview').hide();
								jQuery('.mo_custom_sharing_icon_font_preview').hide();
								jQuery('.mo_custom_sharing_icon_preview').show();
								jQuery("."+a).css("background","#"+h);
								jQuery("."+a).css("padding-top","8px");
								jQuery("."+a).css({height:t-8,width:t});
								jQuery("."+a).css("font-size",(t-16)+"px");
								
								
								if(r=="circle"){
								jQuery("."+a).css("borderRadius","999px");
								}else if(r=="oval"){
								jQuery("."+a).css("borderRadius","5px");
								}else if(r=="square"){
								jQuery("."+a).css("borderRadius","0px");
								}
								
								jQuery("."+a).css("margin-left",(n-4)+"px");
							}
							
							else if("customFont"==w){
								var a="mo_custom_sharing_icon_font_preview";
								jQuery('.mo_sharing_icon_preview').hide();
								jQuery('.mo_custom_sharing_icon_preview').hide();
								jQuery('.mo_custom_sharing_icon_font_preview').show();
								jQuery("."+a).css("font-size",(t-5)+"px");
								jQuery('.mo_custom_sharing_icon_font_preview').css("color","#"+x);
								jQuery("."+a).css("margin-left",(n-4)+"px");
								
								if(r=="circle"){
								jQuery("."+a).css("borderRadius","999px");
								
								}else if(r=="oval"){
								jQuery("."+a).css("borderRadius","5px");
								}else if(r=="square"){
								jQuery("."+a).css("borderRadius","0px");
								}
								
							}
							addSelectedApps();
							
							
							
						}
						moSharingPreview('horizontal',tempHorSize,tempHorShape,tempHorTheme,tempbackColor,tempHorSpace,tempHorFontColor);
						
						function addSelectedApps() {
							var flag = 0;
								if (document.getElementById('google_share_enable').checked)   {
									flag = 1;
										if(document.getElementById('mo_openid_default_background_radio').checked)
											jQuery("#mo_sharing_icon_preview_google").show();
										if(document.getElementById('mo_openid_custom_background_radio').checked)
											jQuery("#mo_custom_sharing_icon_preview_google").show();
										if(document.getElementById('mo_openid_no_background_radio').checked)
											jQuery("#mo_custom_sharing_icon_font_preview_google").show();
								} else if(!document.getElementById('google_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_google").hide();
									jQuery("#mo_custom_sharing_icon_preview_google").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_google").hide();
									
								}
								
								if (document.getElementById('facebook_share_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_default_background_radio').checked)
										jQuery("#mo_sharing_icon_preview_facebook").show();
									if(document.getElementById('mo_openid_custom_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_preview_facebook").show();
									if(document.getElementById('mo_openid_no_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_font_preview_facebook").show();
								}else if(!document.getElementById('facebook_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_facebook").hide();
									jQuery("#mo_custom_sharing_icon_preview_facebook").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_facebook").hide();
								}
								
								if (document.getElementById('linkedin_share_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_default_background_radio').checked)
										jQuery("#mo_sharing_icon_preview_linkedin").show();
									if(document.getElementById('mo_openid_custom_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_preview_linkedin").show();
									if(document.getElementById('mo_openid_no_background_radio').checked)	
										jQuery("#mo_custom_sharing_icon_font_preview_linkedin").show();
								} else if(!document.getElementById('linkedin_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_linkedin").hide();
									jQuery("#mo_custom_sharing_icon_preview_linkedin").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_linkedin").hide();
								}
								
								if (document.getElementById('twitter_share_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_default_background_radio').checked)
										jQuery("#mo_sharing_icon_preview_twitter").show();
									if(document.getElementById('mo_openid_custom_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_preview_twitter").show();
									if(document.getElementById('mo_openid_no_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_font_preview_twitter").show();
								} else if(!document.getElementById('twitter_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_twitter").hide();
									jQuery("#mo_custom_sharing_icon_preview_twitter").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_twitter").hide();
								}
								
								if (document.getElementById('pinterest_share_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_default_background_radio').checked)
										jQuery("#mo_sharing_icon_preview_pinterest").show();
									if(document.getElementById('mo_openid_custom_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_preview_pinterest").show();
									if(document.getElementById('mo_openid_no_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_font_preview_pinterest").show();
								}else if(!document.getElementById('pinterest_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_pinterest").hide();
									jQuery("#mo_custom_sharing_icon_preview_pinterest").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_pinterest").hide();
								}
								
								if (document.getElementById('reddit_share_enable').checked) {
									flag = 1;
									if(document.getElementById('mo_openid_default_background_radio').checked)
										jQuery("#mo_sharing_icon_preview_reddit").show();
									if(document.getElementById('mo_openid_custom_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_preview_reddit").show();
									if(document.getElementById('mo_openid_no_background_radio').checked)
										jQuery("#mo_custom_sharing_icon_font_preview_reddit").show();
									//}
								} else if(!document.getElementById('reddit_share_enable').checked){
									jQuery("#mo_sharing_icon_preview_reddit").hide();
									jQuery("#mo_custom_sharing_icon_preview_reddit").hide();
									jQuery("#mo_custom_sharing_icon_font_preview_reddit").hide();
								}
								
								if(flag) {
									jQuery("#no_apps_text").hide();
								} else {
									jQuery("#no_apps_text").show();
								}
						}
						
				jQuery( document ).ready(function() {
						addSelectedApps();					
				});
		</script>
		<tr>
			<td>
				<br/>
				<strong>*NOTE:</strong><br/>Custom background: This will change the background color of sharing icons.
				<br/>No background: This will Change the font color of icons without background.
			</td>
		</tr>
		<tr>
			<td>
				<br>
				 <hr>
				<h3>Display Options</h3>
				<p><strong>Select the options where you want to display social share icons</strong></p>
			</td>
		</tr>
											
		<tr>
			<td>
				<input type="checkbox" id="mo_apps_home_page"  name="mo_share_options_home_page"  value="1" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_share_options_enable_home_page') == 1 );?>>
				Home Page
			</td>
		</tr>
		<tr>
			<td>
			<input type="checkbox" id="mo_apps_posts"  name="mo_share_options_post" value="1" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>
			<?php checked( get_option('mo_share_options_enable_post') == 1 );?>>
				Blog Post
			</td>		
		</tr>
		<tr>
			<td>
				<input type="checkbox" id="mo_apps_static_page"  name="mo_share_options_static_pages"  value="1" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> <?php checked( get_option('mo_share_options_enable_static_pages') == 1 );?>>
				Static Pages
			</td>
		</tr>
		<tr>
			<td>
				<br/>
				<strong>NOTE:</strong>  The icons in above pages will be placed horizontally. For vertical icons, add <b>miniOrange Sharing - Vertical</b> widget from Appearance->Widgets.
			</td>
		</tr>
		<tr>
			<td>
			<br>
			<hr>
			<h3>Customize Text For Social Share Icons</h3>
			</td>
		</tr>
		<tr>
			<td>
				<b>Enter text to show above share widget:</b>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="mo_openid_table_textbox" style="width:50%;" type="text" name="mo_openid_share_widget_customize_text"
					value="<?php echo get_option('mo_openid_share_widget_customize_text'); ?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> />
			</td>
		</tr>
		<tr>
			<td>
				<b>Enter your twitter Username (without @):</b>
				&nbsp;
				<input class="mo_openid_table_textbox" style="width:50%;" type="text" name="mo_openid_share_twitter_username"
					value="<?php echo get_option('mo_openid_share_twitter_username'); ?>" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?> />
			</td>
		</tr>
		<tr>
									
			<td>
				<br />
				<input type="submit" name="submit" value="Save" style="width:100px;"
					class="button button-primary button-large" <?php if(!mo_openid_is_customer_registered()) echo 'disabled'?>/>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<hr>
				<p>
					<h3>Add Sharing Icons</h3>
					You can add sharing icons in the following areas from <strong>Display Options</strong>. For other areas(widget areas) and vertical floating widget, use Sharing Widgets.
				<ol>
					<li>Home Page: This option places sharing icons in the homepage.</li>
					<li>Blog Post: This option places sharing icons in individual post pages.</li>
					<li>Static Pages: This option places sharing icons in all non-post pages.</li>
				</ol>
					<h3>Add Sharing Icons as Widget</h3>

				<ol>
					<li>Go to Appearance->Widgets. Among the available widgets you will find <b>miniOrange Sharing - Vertical</b> and <b>miniOrange Sharing - Horizontal</b>.</li>
					<li>Drag the one you want to a widget area. You can edit Vertical widget position.</li>
					<li>Now go to your site. You will see the icons for apps which you enabled for sharing.</li>
				</ol>
				</p>
			</td>
		</tr>					
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
			$customerKey 	= get_option('mo_openid_admin_customer_key');
			if( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) ) {
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
						<!--td><b><font color="#FF0000">*</font>Email:</b></td-->
						<td><input type="email" class="mo_openid_table_contact" required placeholder="Enter your Email" name="mo_openid_contact_us_email" value="<?php echo get_option("mo_openid_admin_email"); ?>"></td>
					</tr>
					<tr>
						<!--td><b>Phone:</b></td-->
						<td><input type="tel" id="contact_us_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" placeholder="Enter your phone number with country code (+1)" class="mo_openid_table_contact" name="mo_openid_contact_us_phone" value="<?php echo get_option('mo_openid_admin_phone');?>"></td>
					</tr>
					<tr>
						<!--td><b><font color="#FF0000">*</font>Query:</b></td-->
						<td><textarea class="mo_openid_table_contact" onkeypress="mo_openid_valid_query(this)" onkeyup="mo_openid_valid_query(this)" placeholder="Write your query here" onblur="mo_openid_valid_query(this)" required name="mo_openid_contact_us_query" rows="4" style="resize: vertical;"></textarea></td>
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
		
		function moSharingSizeValidate(e){
	var t=parseInt(e.value.trim());t>60?e.value=60:10>t&&(e.value=20)
}
function moSharingSpaceValidate(e){
	var t=parseInt(e.value.trim());t>50?e.value=50:0>t&&(e.value=0)
}
function moLoginSizeValidate(e){
	var t=parseInt(e.value.trim());t>60?e.value=60:20>t&&(e.value=20)
}
function moLoginSpaceValidate(e){
	var t=parseInt(e.value.trim());t>60?e.value=60:0>t&&(e.value=0)
}
function moLoginWidthValidate(e){
	var t=parseInt(e.value.trim());t>1000?e.value=1000:200>t&&(e.value=200)
}
function moLoginHeightValidate(e){
	var t=parseInt(e.value.trim());t>50?e.value=50:35>t&&(e.value=35)
}

	</script>
<?php
}

function mo_openid_is_extension_installed($name) {
	if  (in_array  ($name, get_loaded_extensions())) {
		return true;
	}
	else {
		return false;
	}
}

function mo_openid_is_curl_installed() {
		    if  (in_array  ('curl', get_loaded_extensions())) {
		        return 1;
		    } else
		        return 0;
}?>