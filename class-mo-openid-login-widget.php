<?php
if(mo_openid_is_customer_registered()) {
/*
* Login Widget
*
*/
class mo_openid_login_wid extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'mo_openid_login_wid',
			'miniOrange Social Login Widget',
			array( 'description' => __( 'Login using Social Apps like Google, Facebook, LinkedIn, Microsoft, Instagram.', 'flw' ), )
		);
	 }


	public function widget( $args, $instance ) {
		extract( $args );

		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );

		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->openidloginForm();

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}


    public function openidloginForm(){
		global $post;
				$this->error_message();
				$selected_theme = get_option('mo_openid_login_theme');
				$appsConfigured = get_option('mo_openid_google_enable') | get_option('mo_openid_salesforce_enable') | get_option('mo_openid_facebook_enable') | get_option('mo_openid_linkedin_enable') | get_option('mo_openid_instagram_enable') | get_option('mo_openid_amazon_enable') | get_option('mo_openid_windowslive_enable') | get_option('mo_openid_twitter_enable');
				$spacebetweenicons = get_option('mo_login_icon_space');
				$customWidth = get_option('mo_login_icon_custom_width');
				$customHeight = get_option('mo_login_icon_custom_height');
				$customSize = get_option('mo_login_icon_custom_size');
				$customBackground = get_option('mo_login_icon_custom_color');
				$customTheme = get_option('mo_openid_login_custom_theme');
				if( ! is_user_logged_in() ) {

					if( $appsConfigured ) {
						$this->mo_openid_load_login_script();
					?>
					
						<a href="http://miniorange.com/single-sign-on-sso" hidden></a>
					
						 <div class="mo-openid-app-icons">

						 <p><?php   echo get_option('mo_openid_login_widget_customize_text'); ?>
						</p>
					<?php
						if($customTheme == 'default'){
						if( get_option('mo_openid_google_enable') ) {
							if($selected_theme == 'longbutton'){
						?>
							
						<a  onClick="moOpenIdLogin('google');" style='width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important' class='btn btn-block btn-social btn-google btn-custom-size' > <i style='padding-top:<?php echo $customHeight-35 ?>px !important' class='fa fa-google-plus'></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Google</a>
						<?php }
						else{ ?>
						<a  onClick="moOpenIdLogin('google');" ><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important" src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
						<?php
						}
						}

						if( get_option('mo_openid_facebook_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('facebook');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-facebook  btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-facebook"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Facebook</a>
						<?php }
						else{ ?>

							<a  onClick="moOpenIdLogin('facebook');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important" src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>

						<?php }

						}
						if( get_option('mo_openid_twitter_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('twitter');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-twitter btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-twitter"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Twitter</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('twitter');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important"  src="<?php echo plugins_url( 'includes/images/icons/twitter.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}
						
					if( get_option('mo_openid_linkedin_enable') ) {
									if($selected_theme == 'longbutton'){ ?>
							<a  onClick="moOpenIdLogin('linkedin');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-linkedin btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-linkedin"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> LinkedIn</a>
						<?php }
						else{ ?>
							<a  onClick="moOpenIdLogin('linkedin');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important" src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
								<?php }
						}if( get_option('mo_openid_instagram_enable') ) {
							if($selected_theme == 'longbutton'){	?>
						 <a  onClick="moOpenIdLogin('instagram');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-instagram btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-instagram"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Instagram</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('instagram');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important"  src="<?php echo plugins_url( 'includes/images/icons/instagram.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}if( get_option('mo_openid_amazon_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('amazon');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-soundcloud btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-amazon"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Amazon</a>
						<?php }
						else{ ?>

						<a  onClick="moOpenIdLogin('amazon');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important"  src="<?php echo plugins_url( 'includes/images/icons/amazon.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}if( get_option('mo_openid_salesforce_enable') ) {
								if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('salesforce');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-vimeo btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-cloud"></i> <?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Salesforce</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('salesforce');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important"  src="<?php echo plugins_url( 'includes/images/icons/salesforce.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
						<?php }
						}if( get_option('mo_openid_windowslive_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('windowslive');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important" class="btn btn-block btn-social btn-microsoft btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-windows"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Microsoft</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('windowslive');"><img style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important"  src="<?php echo plugins_url( 'includes/images/icons/windowslive.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}
						
						}
						?>
						
						
						
						<?php
						if($customTheme == 'custom'){
						if( get_option('mo_openid_google_enable') ) {
							if($selected_theme == 'longbutton'){
						?>
							
							<a   onClick="moOpenIdLogin('google');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important; background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-customtheme btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-google-plus"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Google</a>
						<?php }
						else{ ?>
						<a  onClick="moOpenIdLogin('google');" ><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"  class="fa fa-google-plus custom-login-button <?php echo $selected_theme; ?>" ></i></a>
						<?php
						}
						}

						if( get_option('mo_openid_facebook_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('facebook');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-facebook  btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-facebook"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Facebook</a>
						<?php }
						else{ ?>

							<a  onClick="moOpenIdLogin('facebook');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;" class="fa fa-facebook custom-login-button <?php echo $selected_theme; ?>" ></i></a>

						<?php }

						}
						if( get_option('mo_openid_twitter_enable') ) {
							if($selected_theme == 'longbutton'){
						?>
							
							<a   onClick="moOpenIdLogin('twitter');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important; background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-customtheme btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-twitter"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Twitter</a>
						<?php }
						else{ ?>
						<a  onClick="moOpenIdLogin('twitter');" ><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"  class="fa fa-twitter custom-login-button <?php echo $selected_theme; ?>" ></i></a>
						<?php
						}
						}
					if( get_option('mo_openid_linkedin_enable') ) {
									if($selected_theme == 'longbutton'){ ?>
							<a  onClick="moOpenIdLogin('linkedin');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-linkedin btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-linkedin"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> LinkedIn</a>
						<?php }
						else{ ?>
							<a  onClick="moOpenIdLogin('linkedin');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"  class="fa fa-linkedin custom-login-button <?php echo $selected_theme; ?>" ></i></a>
								<?php }
						}if( get_option('mo_openid_instagram_enable') ) {
							if($selected_theme == 'longbutton'){	?>
						 <a  onClick="moOpenIdLogin('instagram');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important;background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-instagram btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-instagram"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Instagram</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('instagram');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"   class="fa fa-instagram custom-login-button <?php echo $selected_theme; ?>"></i></a>
						<?php }
						}if( get_option('mo_openid_amazon_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('amazon');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important;" class="btn btn-block btn-social btn-linkedin btn-custom-size" ><i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-amazon"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Amazon</a>
						<?php }
						else{ ?>

						<a  onClick="moOpenIdLogin('amazon');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"   class="fa fa-amazon custom-login-button <?php echo $selected_theme; ?>"></i></a>
						<?php }
						}if( get_option('mo_openid_salesforce_enable') ) {
								if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('salesforce');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-linkedin btn-custom-size" ><i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-cloud"></i> <?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Salesforce</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('salesforce');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px " class="fa fa-cloud custom-login-button <?php echo $selected_theme; ?>" ></i></a>
						<?php }
						}if( get_option('mo_openid_windowslive_enable') ) {
							if($selected_theme == 'longbutton'){
						?> <a  onClick="moOpenIdLogin('windowslive');" style="width:<?php echo $customWidth ?>px !important;padding-top:<?php echo $customHeight-29 ?>px !important;padding-bottom:<?php echo $customHeight-29 ?>px !important;margin-bottom:<?php echo $spacebetweenicons-5 ?>px !important;background:<?php echo "#".$customBackground?> !important" class="btn btn-block btn-social btn-microsoft btn-custom-size" > <i style="padding-top:<?php echo $customHeight-35 ?>px !important" class="fa fa-windows"></i><?php
									echo get_option('mo_openid_login_button_customize_text'); 	?> Microsoft</a>
						<?php }
						else{ ?>


						<a  onClick="moOpenIdLogin('windowslive');"><i style="width:<?php echo $customSize?>px !important;height:<?php echo $customSize?>px !important;margin-left:<?php echo $spacebetweenicons-4?>px !important;background:<?php echo "#".$customBackground?> !important;font-size:<?php echo $customSize-16?>px !important;"   class=" fa fa-windows custom-login-button <?php echo $selected_theme; ?>"></i></a>
						<?php }
						}
						
						
						}
						?>
						<br>
						</div> <br>
						<?php


					} else {
						?>
						<div>No apps configured. Please contact your administrator.</div>
					<?php
					}
				}else {
					global $current_user;
			     	get_currentuserinfo();
					$link_with_username = __('Howdy, ', 'flw') . $current_user->display_name;
					?>
					<div id="logged_in_user" class="mo_openid_login_wid">
						<li><?php echo $link_with_username;?> | <a href="<?php echo wp_logout_url( site_url() ); ?>" title="<?php _e('Logout','flw');?>"><?php _e('Logout','flw');?></a></li>
					</div>
					<?php
				}
				
				
	}

	
	public function openidloginFormShortCode( $atts ){
		global $post;
				$html = '';
				$this->error_message();
				$selected_theme = isset( $atts['shape'] )? $atts['shape'] : get_option('mo_openid_login_theme');
				$appsConfigured = get_option('mo_openid_google_enable') | get_option('mo_openid_salesforce_enable') | get_option('mo_openid_facebook_enable') | get_option('mo_openid_linkedin_enable') | get_option('mo_openid_instagram_enable') | get_option('mo_openid_amazon_enable') | get_option('mo_openid_windowslive_enable') |get_option('mo_openid_twitter_enable');
				$spacebetweenicons = isset( $atts['space'] )? $atts['space'] : get_option('mo_login_icon_space');
				$customWidth = isset( $atts['width'] )? $atts['width'] : get_option('mo_login_icon_custom_width');
				$customHeight = isset( $atts['height'] )? $atts['height'] : get_option('mo_login_icon_custom_height');
				$customSize = isset( $atts['size'] )? $atts['size'] : get_option('mo_login_icon_custom_size');
				$customBackground = isset( $atts['background'] )? $atts['background'] : get_option('mo_login_icon_custom_color');
				$customTheme = isset( $atts['theme'] )? $atts['theme'] : get_option('mo_openid_login_custom_theme');
				$customText = get_option('mo_openid_login_widget_customize_text');
				$buttonText = get_option('mo_openid_login_button_customize_text');
				
				
				if($selected_theme == 'longbuttonwithtext'){
					$selected_theme = 'longbutton';
				}
				if($customTheme == 'custombackground'){
					$customTheme = 'custom';
				}
				
				if( ! is_user_logged_in() ) {

					if( $appsConfigured ) {
						$this->mo_openid_load_login_script();
					$html .= "<a href='http://miniorange.com/single-sign-on-sso' hidden></a>
					
						 <div class='mo-openid-app-icons'>
						
						 <p> $customText</p>";
						
						if($customTheme == 'default'){
						if( get_option('mo_openid_google_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-google btn-custom-dec' onClick='moOpenIdLogin(" . '"google"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-google-plus'></i>" . $buttonText . " Google</a>"; 
						 }
						else{ 
						
						$html .= "<a  onClick='moOpenIdLogin(" . '"google"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/google.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						
						}
						}

						if( get_option('mo_openid_facebook_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-facebook btn-custom-dec' onClick='moOpenIdLogin(" . '"facebook"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-facebook'></i>" . $buttonText . " Facebook</a>"; }
						else{ 
								$html .= "<a  onClick='moOpenIdLogin(" . '"facebook"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/facebook.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}

						}
						if( get_option('mo_openid_twitter_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-twitter btn-custom-dec' onClick='moOpenIdLogin(" . '"twitter"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-twitter'></i>" . $buttonText . " Twitter</a>"; }
						else{ 
								$html .= "<a  onClick='moOpenIdLogin(" . '"twitter"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/twitter.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}

						}
					if( get_option('mo_openid_linkedin_enable') ) {
									if($selected_theme == 'longbutton'){ 
							 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-linkedin btn-custom-dec' onClick='moOpenIdLogin(" . '"linkedin"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-linkedin'></i>" . $buttonText . " LinkedIn</a>";
						 }
						else{ 
								$html .= "<a  onClick='moOpenIdLogin(" . '"linkedin"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/linkedin.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						 }
						}if( get_option('mo_openid_instagram_enable') ) {
							if($selected_theme == 'longbutton'){	
						 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-instagram btn-custom-dec' onClick='moOpenIdLogin(" . '"instagram"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-instagram'></i>" . $buttonText . " Instagram</a>";
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"instagram"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/instagram.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}
						}if( get_option('mo_openid_amazon_enable') ) {
							if($selected_theme == 'longbutton'){
						      $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-soundcloud btn-custom-dec' onClick='moOpenIdLogin(" . '"amazon"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-amazon'></i>" . $buttonText . " Amazon</a>"; 
						 }
						else{
							$html .= "<a  onClick='moOpenIdLogin(" . '"amazon"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/amazon.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}
						}if( get_option('mo_openid_salesforce_enable') ) {
								if($selected_theme == 'longbutton'){
						 $html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-vimeo btn-custom-dec' onClick='moOpenIdLogin(" . '"salesforce"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-cloud'></i>" . $buttonText . " Salesforce</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"salesforce"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/salesforce.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}
						}if( get_option('mo_openid_windowslive_enable') ) {
							if($selected_theme == 'longbutton'){
								$html .= "<a  style='width: " . $customWidth . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom: " . ($spacebetweenicons-5)  . "px !important' class='btn btn-block btn-social btn-microsoft btn-custom-dec' onClick='moOpenIdLogin(" . '"windowslive"' . ");'> <i style='padding-top:" . ($customHeight-35) . "px !important' class='fa fa-windows'></i>" . $buttonText . " Microsoft</a>";
							}
						else{ 
								$html .= "<a  onClick='moOpenIdLogin(" . '"windowslive"' . ");' ><img style='width:" . $customSize ."px !important;height: " . $customSize ."px !important;margin-left: " . ($spacebetweenicons-4) ."px !important' src='" . plugins_url( 'includes/images/icons/windowslive.png', __FILE__ ) . "' class=' " .$selected_theme . "' ></a>";
						}
						}
						}
						
						
						
						if($customTheme == 'custom'){
						if( get_option('mo_openid_google_enable') ) {
							if($selected_theme == 'longbutton'){
								$html .= "<a   onClick='moOpenIdLogin(" . '"google"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-google-plus'></i> " . $buttonText . " Google</a>"; 
							}
						else{ 
								$html .= "<a  onClick='moOpenIdLogin(" . '"google"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-google-plus custom-login-button  " . $selected_theme . "' ></i></a>";
						
							}
						}

						if( get_option('mo_openid_facebook_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a   onClick='moOpenIdLogin(" . '"facebook"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-facebook'></i> " . $buttonText . " Facebook</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"facebook"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-facebook custom-login-button  " . $selected_theme . "' ></i></a>";
						}

						}
						if( get_option('mo_openid_twitter_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a   onClick='moOpenIdLogin(" . '"twitter"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-twitter'></i> " . $buttonText . " Twitter</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"twitter"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-twitter custom-login-button  " . $selected_theme . "' ></i></a>";
						}

						}
					if( get_option('mo_openid_linkedin_enable') ) {
									if($selected_theme == 'longbutton'){ 
							 $html .= "<a   onClick='moOpenIdLogin(" . '"linkedin"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-linkedin'></i> " . $buttonText . " LinkedIn</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"linkedin"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-linkedin custom-login-button  " . $selected_theme . "' ></i></a>";
						}
						}if( get_option('mo_openid_instagram_enable') ) {
							if($selected_theme == 'longbutton'){
								 $html .= "<a   onClick='moOpenIdLogin(" . '"instagram"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-instagram'></i> " . $buttonText . " Instagram</a>"; 
						 }
						else{
							$html .= "<a  onClick='moOpenIdLogin(" . '"instagram"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-instagram custom-login-button  " . $selected_theme . "' ></i></a>";
						}
						}if( get_option('mo_openid_amazon_enable') ) {
							if($selected_theme == 'longbutton'){
						 $html .= "<a   onClick='moOpenIdLogin(" . '"amazon"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-amazon'></i> " . $buttonText . " Amazon</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"amazon"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-amazon custom-login-button  " . $selected_theme . "' ></i></a>";
						}
						}if( get_option('mo_openid_salesforce_enable') ) {
								if($selected_theme == 'longbutton'){
						  $html .= "<a   onClick='moOpenIdLogin(" . '"salesforce"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-cloud'></i> " . $buttonText . " Salesforce</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"salesforce"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-cloud custom-login-button  " . $selected_theme . "' ></i></a>";
						}
						}if( get_option('mo_openid_windowslive_enable') ) {
							if($selected_theme == 'longbutton'){
						  $html .= "<a   onClick='moOpenIdLogin(" . '"windowslive"' . ");' style='width:" . ($customWidth) . "px !important;padding-top:" . ($customHeight-29) . "px !important;padding-bottom:" . ($customHeight-29) . "px !important;margin-bottom:" . ($spacebetweenicons-5) . "px !important; background:#" . $customBackground . "!important;' class='btn btn-block btn-social btn-customtheme btn-custom-dec' > <i style='padding-top:" .($customHeight-35) . "px !important' class='fa fa-windows'></i> " . $buttonText . " Microsoft</a>"; 
						 }
						else{ 
							$html .= "<a  onClick='moOpenIdLogin(" . '"windowslive"' . ");' ><i style='width:" . $customSize . "px !important;height:" . $customSize . "px !important;margin-left:" . ($spacebetweenicons-4) . "px !important;background:#" . $customBackground . " !important;font-size: " . ($customSize-16) . "px !important;'  class='fa fa-windows custom-login-button  " . $selected_theme . "' ></i></a>";
						}
						}
						}
						 $html .= '</div> <br>';


					} else {
						
						$html .= '<div>No apps configured. Please contact your administrator.</div>';
					
					}
				}else {
					global $current_user;
			     	get_currentuserinfo();
					$link_with_username = __('Howdy, ', 'flw') . $current_user->display_name;
					?>
					<div id="logged_in_user" class="mo_openid_login_wid">
						<li><?php echo $link_with_username;?> | <a href="<?php echo wp_logout_url( site_url() ); ?>" title="<?php _e('Logout','flw');?>"><?php _e('Logout','flw');?></a></li>
					</div>
					<?php
				}
				
				return $html;
				
	}
	
	private function mo_openid_load_login_script() {
			?>
			<script type="text/javascript">
				function moOpenIdLogin(app_name) {
				<?php
					if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
						$http = "https://";
					} else {
						$http =  "http://";
					}
					if ( strpos($_SERVER['REQUEST_URI'],'wp-login.php') !== FALSE){
							$redirect_url = site_url() . '/wp-login.php?option=getMoSocialLogin&app_name=';

					}else{
					    	$redirect_url = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
							if(strpos($redirect_url, '?') !== false) {
								$redirect_url .= '&option=getMoSocialLogin&app_name=';
							} else {
								$redirect_url .= '?option=getMoSocialLogin&app_name=';
							}
    				}
    			?>
					window.location.href = '<?php echo $redirect_url; ?>' + app_name;
				}
			</script>
			<?php
	}

	public function error_message(){
		if(isset($_SESSION['msg']) and $_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}

}


/**
 * Sharing Widget Horizontal
 *
 */
class mo_openid_sharing_hor_wid extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'mo_openid_sharing_hor_wid',
			'miniOrange Sharing - Horizontal',
			array( 'description' => __( 'Share using horizontal widget. Lets you share with Social Apps like Google, Facebook, LinkedIn, Pinterest, Reddit.', 'flw' ), )
		);
	 }


	public function widget( $args, $instance ) {
		extract( $args );

		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );

		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->show_sharing_buttons_horizontal();

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}


    public function show_sharing_buttons_horizontal(){
		global $post;
		$title = str_replace('+', '%20', urlencode($post->post_title));
		$content=strip_shortcodes( strip_tags( get_the_content() ) );
		$post_content=$content;
		$excerpt = '';
		$landscape = 'horizontal';
		include( plugin_dir_path( __FILE__ ) . 'class-mo-openid-social-share.php');
	}

}


/**
 * Sharing Vertical Widget
 *
 */
class mo_openid_sharing_ver_wid extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'mo_openid_sharing_ver_wid',
			'miniOrange Sharing - Vertical',
			array( 'description' => __( 'Share using a vertical floating widget. Lets you share with Social Apps like Google, Facebook, LinkedIn, Pinterest, Reddit.', 'flw' ), )
		);
	 }


	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );
		$alignment = apply_filters( 'alignment', isset($instance['alignment'])? $instance['alignment'] : 'left');
		$left_offset = apply_filters( 'left_offset', isset($instance['left_offset'])? $instance['left_offset'] : '20');
		$right_offset = apply_filters( 'right_offset', isset($instance['right_offset'])? $instance['right_offset'] : '0');
		$top_offset = apply_filters( 'top_offset', isset($instance['top_offset'])? $instance['top_offset'] : '100');
		$space_icons = apply_filters( 'space_icons', isset($instance['space_icons'])? $instance['space_icons'] : '10');

		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
		
		echo "<div class='mo_openid_vertical' style='" .(isset($alignment) && $alignment != '' && isset($instance[$alignment.'_offset']) ? $alignment .': '. ( $instance[$alignment.'_offset'] == '' ? 0 : $instance[$alignment.'_offset'] ) .'px;' : '').(isset($top_offset) ? 'top: '. ( $top_offset == '' ? 0 : $top_offset ) .'px;' : '') ."'>";
		
		$this->show_sharing_buttons_vertical($space_icons);
		
		echo '</div>';

		echo $args['after_widget'];
	}

	/*Called when user changes configuration in Widget Admin Panel*/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		$instance['alignment'] = $new_instance['alignment'];
		$instance['left_offset'] = $new_instance['left_offset'];
		$instance['right_offset'] = $new_instance['right_offset'];
		$instance['top_offset'] = $new_instance['top_offset'];
		$instance['space_icons'] = $new_instance['space_icons'];
		return $instance;
	}


    public function show_sharing_buttons_vertical($space_icons){
		global $post;
		if($post->post_title) {
			$title = str_replace('+', '%20', urlencode($post->post_title));
		} else {
			$title = get_bloginfo( 'name' );
		}
		$content=strip_shortcodes( strip_tags( get_the_content() ) );
		$post_content=$content;
		$excerpt = '';
		$landscape = 'vertical';
		
		include( plugin_dir_path( __FILE__ ) . 'class-mo-openid-social-share.php');
	}
	
	/** Widget edit form at admin panel */ 
	function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'left_offset' => '20', 'right_offset' => '0', 'top_offset' => '100' , 'space_icons' => '10');
		
		foreach( $instance as $key => $value ){
			$instance[ $key ] = esc_attr( $value );
		}
		
		$instance = wp_parse_args( (array)$instance, $defaults );
		?> 
		<p> 
			<script>
			function moOpenIDVerticalSharingOffset(alignment){
				if(alignment == 'left'){
					jQuery('.moVerSharingLeftOffset').css('display', 'block');
					jQuery('.moVerSharingRightOffset').css('display', 'none');
				}else{
					jQuery('.moVerSharingLeftOffset').css('display', 'none');
					jQuery('.moVerSharingRightOffset').css('display', 'block');
				}
			}
			</script>
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>">Alignment</label> 
			<select onchange="moOpenIDVerticalSharingOffset(this.value)" style="width: 95%" id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="left" <?php echo $instance['alignment'] == 'left' ? 'selected' : ''; ?>>Left</option>
				<option value="right" <?php echo $instance['alignment'] == 'right' ? 'selected' : ''; ?>>Right</option>
			</select>
			<div class="moVerSharingLeftOffset" <?php echo $instance['alignment'] == 'right' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'left_offset' ); ?>">Left Offset</label> 
				<input style="width: 95%" id="<?php echo $this->get_field_id( 'left_offset' ); ?>" name="<?php echo $this->get_field_name( 'left_offset' ); ?>" type="text" value="<?php echo $instance['left_offset']; ?>" />px<br/>
			</div>
			<div class="moVerSharingRightOffset" <?php echo $instance['alignment'] == 'left' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'right_offset' ); ?>">Right Offset</label> 
				<input style="width: 95%" id="<?php echo $this->get_field_id( 'right_offset' ); ?>" name="<?php echo $this->get_field_name( 'right_offset' ); ?>" type="text" value="<?php echo $instance['right_offset']; ?>" />px<br/>
			</div>
			<label for="<?php echo $this->get_field_id( 'top_offset' ); ?>">Top Offset</label> 
			<input style="width: 95%" id="<?php echo $this->get_field_id( 'top_offset' ); ?>" name="<?php echo $this->get_field_name( 'top_offset' ); ?>" type="text" value="<?php echo $instance['top_offset']; ?>" />px<br/>
			<label for="<?php echo $this->get_field_id( 'space_icons' ); ?>">Space between icons</label> 
			<input style="width: 95%" id="<?php echo $this->get_field_id( 'space_icons' ); ?>" name="<?php echo $this->get_field_name( 'space_icons' ); ?>" type="text" value="<?php echo $instance['space_icons']; ?>" />px<br/>
		</p>
	<?php
	}

}
 

	function mo_openid_start_session() {
			if( !session_id() ) {
				session_start();
			}
	}

	function mo_openid_end_session() {
			session_destroy();
	}
	
	function mo_openid_widget_register_plugin_styles() {
		/*wp_enqueue_style( 'style_login_widget', plugins_url( 'miniorange-login-openid/includes/css/mo_openid_style.css' ) );
		wp_enqueue_style( 'mo-wp-bootstrap-social',plugins_url('includes/css/bootstrap-social.css', __FILE__), false );
		wp_enqueue_style( 'mo-wp-bootstrap-main',plugins_url('includes/css/bootstrap.min.css', __FILE__), false );
		wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.min.css', __FILE__), false );*/
	}

	function mo_openid_login_validate(){
		if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'getMoSocialLogin' ) !== false ) {
			$client_name = "wordpress";
			$timestamp = round( microtime(true) * 1000 );
			$api_key = get_option('mo_openid_admin_api_key');
			$token = $client_name . ':' . number_format($timestamp, 0, '', ''). ':' . $api_key;

			$customer_token = get_option('mo_openid_customer_token');
			$blocksize = 16;
			$pad = $blocksize - ( strlen( $token ) % $blocksize );
			$token =  $token . str_repeat( chr( $pad ), $pad );
			$token_params_encrypt = mcrypt_encrypt( MCRYPT_RIJNDAEL_128, $customer_token, $token, MCRYPT_MODE_ECB );
			$token_params_encode = base64_encode( $token_params_encrypt );
			$token_params = urlencode( $token_params_encode );
			
			if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
				$http = "https://";
			} else {
				$http =  "http://";
			}
			
			$base_return_url =  $http . $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"],'?');

    		$return_url = urlencode( $base_return_url . '/?option=moopenid' );

			$url = get_option('mo_openid_host_name') . '/moas/openid-connect/client-app/authenticate?token=' . $token_params . '&id=' . get_option('mo_openid_admin_customer_key') . '&encrypted=true&app=' . $_REQUEST['app_name'] . '_oauth&returnurl=' . $return_url;
			wp_redirect( $url );
			exit;
		}

		if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'moopenid' ) !== false ){
		
			//do stuff after returning from oAuth processing			
			$user_email = '';
			if( isset( $_POST['email']  ) ) {
				$user_email = $_POST['email'];
			} else if( isset( $_POST['username']  )){
				$user_name = $_POST['username'];
				$user_email = $user_name.'@instagram.com';
			}

			if( $user_email ) {
				if( email_exists( $user_email ) ) { // user is a member
					  $user 	= get_user_by('email', $user_email );
					  $user_id 	= $user->ID;
					  do_action( 'wp_login', $user->user_login, $user );
					  wp_set_auth_cookie( $user_id, true );
				} else { // this user is a guest
					if(get_option('mo_openid_auto_register_enable')) {
						  $random_password 	= wp_generate_password( 10, false );
						  $user_id 			= wp_create_user( $user_email, $random_password, $user_email );
						  $user 	= get_user_by('email', $user_email );
						  do_action( 'wp_login', $user->user_login, $user );
						  wp_set_auth_cookie( $user_id, true );
					}
				}
			}
			
			$redirect_url = mo_openid_get_redirect_url();
			wp_redirect($redirect_url);
			exit;

		}
		
		if(isset($_REQUEST['redirect']) and strpos($_REQUEST['redirect'],'true') !== false) {
			if(!is_user_logged_in() && !get_option('mo_openid_auto_register_enable')) {
				mo_openid_disabled_register_message();
			}
		}
	}
	
	function mo_openid_disabled_register_message() {
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script( 'mo-wp-settings-script',plugins_url('includes/js/settings_popup.js', __FILE__), array('jquery'));
		add_thickbox();
		$script = '<script>
						function getAutoRegisterDisabledMessage() {
							var disabledMessage = "' . get_option('mo_openid_register_disabled_message') . '";
							return disabledMessage;
						}
					</script>';
		echo $script;
	}
		
	function mo_openid_get_redirect_url() {
		$option = get_option( 'mo_openid_login_redirect' );
		$redirect_url = site_url();
		if( $option == 'same' ) {
			if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
				$http = "https://";
			} else {
				$http =  "http://";
			}
			$redirect_url = urldecode(html_entity_decode(esc_url($http . $_SERVER["HTTP_HOST"] . str_replace('?option=moopenid','',$_SERVER['REQUEST_URI']))));
			if(html_entity_decode(esc_url(remove_query_arg('ss_message', $redirect_url))) == wp_login_url() || strpos($_SERVER['REQUEST_URI'],'wp-login.php') !== FALSE || strpos($_SERVER['REQUEST_URI'],'wp-admin') !== FALSE){
				$redirect_url = site_url().'/';
			}
		} else if( $option == 'homepage' ) {
			$redirect_url = site_url();
		} else if( $option == 'dashboard' ) {
			$redirect_url = admin_url();
		} else if( $option == 'custom' ) {
			$redirect_url = get_option('mo_openid_login_redirect_url');
		}
		if(strpos($redirect_url,'?') !== FALSE) {
			$redirect_url .= '&redirect=true';
		} else{
			$redirect_url .= '?redirect=true';
		}
		return $redirect_url;
	}
	
	function mo_openid_redirect_after_logout($logout_url) {
		$option = get_option( 'mo_openid_logout_redirect' );
		$redirect_url = site_url();
		if( $option == 'homepage' ) {
			$redirect_url = $logout_url . '&redirect_to=' .home_url()  ;
		}
		else if($option == 'currentpage'){
			$redirect_url = $logout_url . '&redirect_to=' . get_permalink() ;
		}
		else if($option == 'login') {
			$redirect_url = $logout_url . '&redirect_to=' . site_url() . '/wp-admin' ;
		}
		else if($option == 'custom') {
			$redirect_url = $logout_url . '&redirect_to=' . site_url() . (null !== get_option('mo_openid_logout_redirect_url')?get_option('mo_openid_logout_redirect_url'):'');
		}
		return $redirect_url;
	}

add_action( 'widgets_init', create_function( '', 'register_widget( "mo_openid_login_wid" );' ) );
add_action( 'widgets_init', create_function( '', 'return register_widget( "mo_openid_sharing_ver_wid" );' ) );
add_action( 'widgets_init', create_function( '', 'return register_widget( "mo_openid_sharing_hor_wid" );' ) );

add_action( 'init', 'mo_openid_login_validate' );
add_action( 'wp_enqueue_scripts', 'mo_openid_widget_register_plugin_styles' );
add_action( 'init', 'mo_openid_start_session' );
add_action( 'wp_logout', 'mo_openid_end_session' );
add_filter( 'logout_url', 'mo_openid_redirect_after_logout',0,1);
}
?>