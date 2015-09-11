<?php

/**
* Plugin Name: Social Login, Social Sharing by miniOrange
* Plugin URI: http://miniorange.com
* Description: Allow your users to login, comment and share with Facebook, Google, Twitter, LinkedIn etc using customizable buttons.
* Version: 4.2.1
* Author: miniOrange
* Author URI: http://miniorange.com
* License: GPL2
*/

require('miniorange_openid_sso_settings_page.php');
include_once dirname( __FILE__ ) . '/class-mo-openid-login-widget.php';
require('class-mo-openid-sso-customer.php');
require('class-mo-openid-sso-shortcode-buttons.php');



class Miniorange_OpenID_SSO {
	
	

	function __construct() {
		    
			add_action( 'admin_menu', array( $this, 'miniorange_openid_menu' ) );
			add_action( 'admin_init',  array( $this, 'miniorange_openid_save_settings' ) );
			
			add_action( 'plugins_loaded',  array( $this, 'mo_login_widget_text_domain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_openid_plugin_settings_style' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_openid_plugin_settings_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'mo_openid_plugin_settings_style' ) ,5);
			
			register_deactivation_hook(__FILE__, array( $this, 'mo_openid_deactivate'));
			register_activation_hook( __FILE__, array( $this, 'mo_openid_activate' ) );
			
			// add social login icons to default login form
			if(get_option('mo_openid_default_login_enable') == 1){
				add_action( 'login_form', array($this, 'mo_openid_add_social_login') );
				add_action( 'login_enqueue_scripts', array( $this, 'mo_custom_login_stylesheet' ) );
			}
			
			// add social login icons to default registration form
			if(get_option('mo_openid_default_register_enable') == 1){
				
						add_action( 'register_form', array($this, 'mo_openid_add_social_login') );

			}
			
			//add shortcode
			add_shortcode( 'miniorange_social_login', array($this, 'mo_get_output') );
			add_shortcode( 'miniorange_social_sharing', array($this, 'mo_get_sharing_output') );
			add_shortcode( 'miniorange_social_sharing_vertical', array($this, 'mo_get_vertical_sharing_output') );
			
			// add social login icons to comment form
			if(get_option('mo_openid_default_comment_enable') == 1 ){
				add_action('comment_form_must_log_in_after', array($this, 'mo_openid_add_social_login')); 
			   add_action('comment_form_top', array($this, 'mo_openid_add_social_login'));
			}
			
			add_filter( 'the_content', array( $this, 'mo_openid_add_social_share_links' ) );
			add_filter( 'the_excerpt', array( $this, 'mo_openid_add_social_share_links' ) );
						
			remove_action( 'admin_notices', array( $this, 'mo_openid_success_message') );
		    remove_action( 'admin_notices', array( $this, 'mo_openid_error_message') );
			
			//set default values
			add_option( 'mo_openid_login_redirect', 'same' );
			add_option( 'mo_openid_login_theme', 'longbutton' );
			add_option( 'mo_openid_share_theme', 'oval' );
			add_option( 'mo_share_options_enable_post_position', 'before');
			add_option( 'mo_openid_default_login_enable', '1');
			add_option( 'mo_openid_login_widget_customize_text', 'Connect with:' );
			add_option( 'mo_openid_share_widget_customize_text', 'Share with:' );
			add_option( 'mo_openid_login_button_customize_text', 'Login with' );
			add_option( 'mo_openid_google_share_enable','1' );
			add_option( 'mo_openid_facebook_share_enable', '1');
			add_option( 'mo_openid_linkedin_share_enable','1' );
			add_option( 'mo_openid_twitter_share_enable','1' );
			add_option( 'mo_openid_pinterest_share_enable', '1');
			add_option( 'mo_openid_reddit_share_enable','1' );
			add_option('mo_openid_share_widget_customize_direction_horizontal','1');
			add_option('mo_sharing_icon_custom_size','35');
			add_option( 'mo_openid_share_custom_theme', 'default' );
			add_option( 'mo_sharing_icon_custom_color', '000000' );
			add_option( 'mo_sharing_icon_space', '4' );
			add_option( 'mo_sharing_icon_custom_font', '000000' );
			add_option('mo_login_icon_custom_size','35');
			add_option('mo_login_icon_space','4');
			add_option('mo_login_icon_custom_width','200');
			add_option('mo_login_icon_custom_height','35');
			add_option( 'mo_openid_login_custom_theme', 'default' );
			add_option( 'mo_login_icon_custom_color', '2B41FF' );
			add_option( 'mo_openid_logout_redirect', 'currentpage' );
			add_option( 'mo_openid_auto_register_enable', '1');
			add_option( 'mo_openid_register_disabled_message', 'Registration is disabled for this website. Please contact the administrator for any queries.' );
	}
		
	function mo_openid_deactivate() {
			delete_option('mo_openid_host_name');
			delete_option('mo_openid_transactionId');
			delete_option('mo_openid_admin_password');
			delete_option('mo_openid_registration_status');
			delete_option('mo_openid_admin_phone');
			delete_option('mo_openid_new_registration');
			delete_option('mo_openid_admin_customer_key');
			delete_option('mo_openid_admin_api_key');
			delete_option('mo_openid_customer_token');
			delete_option('mo_openid_verify_customer');
			delete_option('mo_openid_message');
	}
	
	function mo_openid_activate() {
		add_option('Activated_Plugin','Plugin-Slug');	
	}	
		
	
	function mo_openid_add_social_login(){

		if(!is_user_logged_in() && mo_openid_is_customer_registered()){
				$mo_login_widget = new mo_openid_login_wid();
				$mo_login_widget->openidloginForm();
		}
	}
		
	function mo_openid_add_social_share_links($content) {
			global $post;
			$post_content=$content;
			$title = str_replace('+', '%20', urlencode($post->post_title));
			$content=strip_shortcodes( strip_tags( get_the_content() ) );
			$excerpt = '';
			$landscape = 'hor';
			
			if(is_front_page() && get_option('mo_share_options_enable_home_page')==1){
					$html_content = mo_openid_share_shortcode('', $title);
					return  $html_content . $post_content;
			}else if(is_page() && get_option('mo_share_options_enable_static_pages')==1){
					$html_content = mo_openid_share_shortcode('', $title);
					return  $html_content . $post_content;
			}else if(is_single() && get_option('mo_share_options_enable_post') == 1 ){
				$html_content = mo_openid_share_shortcode('', $title);
				
				if ( get_option('mo_share_options_enable_post_position') == 'before' ) {
					return  $html_content . $post_content;
				}

				else if ( get_option('mo_share_options_enable_post_position') == 'after' ) {
					 return   $post_content . $html_content;
				}

				else if ( get_option('mo_share_options_enable_post_position') == 'both' ) {
					 return $html_content . $post_content . $html_content;
				}
			}
			else
				return $post_content;
            				 
	}
	

	function mo_openid_success_message() {
		$class = "error";
		$message = get_option('mo_openid_message');
		echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
	}

	function mo_openid_error_message() {
			$class = "updated";
			$message = get_option('mo_openid_message');
			echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
	}
		
	function mo_custom_login_stylesheet()
	{
					   
						 wp_enqueue_style( 'mo-wp-style',plugins_url('includes/css/mo_openid_style.css', __FILE__), false );
						  wp_enqueue_style( 'mo-wp-bootstrap-social',plugins_url('includes/css/bootstrap-social.css', __FILE__), false );
						  wp_enqueue_style( 'mo-wp-bootstrap-main',plugins_url('includes/css/bootstrap.min.css', __FILE__), false );
						  wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.min.css', __FILE__), false );
						wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.css', __FILE__), false );
	}	
		
	function mo_openid_plugin_settings_style() {
			wp_enqueue_style( 'mo_openid_admin_settings_style', plugins_url('includes/css/mo_openid_style.css', __FILE__));
			wp_enqueue_style( 'mo_openid_admin_settings_phone_style', plugins_url('includes/css/phone.css', __FILE__));				
			wp_enqueue_style( 'mo-wp-bootstrap-social',plugins_url('includes/css/bootstrap-social.css', __FILE__), false );
			wp_enqueue_style( 'mo-wp-bootstrap-main',plugins_url('includes/css/bootstrap.min-preview.css', __FILE__), false );
			wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.min.css', __FILE__), false );
			wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.css', __FILE__), false );
	}

	function mo_openid_plugin_settings_script() {
		wp_enqueue_script( 'mo_openid_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__ ));
		wp_enqueue_script( 'mo_openid_admin_settings_color_script', plugins_url('includes/jscolor/jscolor.js', __FILE__ ));
		wp_enqueue_script( 'mo_openid_admin_settings_script', plugins_url('includes/js/settings.js', __FILE__ ), array('jquery'));
		wp_enqueue_script( 'mo_openid_admin_settings_phone_script', plugins_url('includes/js/bootstrap.min.js', __FILE__ ));
	}

	private function mo_openid_show_success_message() {
			remove_action( 'admin_notices', array( $this, 'mo_openid_success_message') );
			add_action( 'admin_notices', array( $this, 'mo_openid_error_message') );
	}

	private function mo_openid_show_error_message() {
			remove_action( 'admin_notices', array( $this, 'mo_openid_error_message') );
			add_action( 'admin_notices', array( $this, 'mo_openid_success_message') );
	}

	public function mo_openid_check_empty_or_null( $value ) {
			if( ! isset( $value ) || empty( $value ) ) {
				return true;
			}
			return false;
	}

	function  mo_login_widget_openid_options() {
		global $wpdb;
		update_option( 'mo_openid_host_name', 'https://auth.miniorange.com' );
		mo_register_openid();
	}

		

	function mo_login_widget_text_domain(){
		load_plugin_textdomain('flw', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}

	function miniorange_openid_save_settings(){
		if(is_admin() && get_option('Activated_Plugin')=='Plugin-Slug') {
			update_option( 'mo_openid_host_name', 'https://auth.miniorange.com' );
			
			delete_option('Activated_Plugin');
			$customer = new CustomerOpenID();
			global $current_user;
			get_currentuserinfo();
			$email = $current_user->user_email;
			$phone='+1';
			$query='User activated Social login, Social sharing by miniOrange.';
			$submitted = $customer->submit_contact_us( $email, $phone, $query );
			if($submitted) {
				update_option('mo_openid_message','Go to plugin <b><a href="admin.php?page=mo_openid_settings">settings</a></b> to enable Social Login, Social Sharing by miniOrange.');
				$this->mo_openid_show_success_message();
			}
		}
		
		if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_connect_register_customer" ) {	//register the admin to miniOrange

			//validation and sanitization
			$email = '';
			$phone = '';
			$password = '';
			$confirmPassword = '';
			$illegal = "#$%^*()+=[]';,/{}|:<>?~";
			$illegal = $illegal . '"';
			if( $this->mo_openid_check_empty_or_null( $_POST['email'] ) || $this->mo_openid_check_empty_or_null( $_POST['password'] ) || $this->mo_openid_check_empty_or_null( $_POST['confirmPassword'] ) ) {
				update_option( 'mo_openid_message', 'All the fields are required. Please enter valid entries.');
				$this->mo_openid_show_error_message();
				return;
			} else if( strlen( $_POST['password'] ) < 6 || strlen( $_POST['confirmPassword'] ) < 6){	//check password is of minimum length 6
						update_option( 'mo_openid_message', 'Choose a password with minimum length 6.');
						$this->mo_openid_show_error_message();
						return;
			} else if(strpbrk($_POST['email'],$illegal)) {
				update_option( 'mo_openid_message', 'Please match the format of Email. No special characters are allowed.');
				$this->mo_openid_show_error_message();
				return;
			} else {
				$email = sanitize_email( $_POST['email'] );
				$phone = sanitize_text_field( $_POST['phone'] );
				$password = sanitize_text_field( $_POST['password'] );
				$confirmPassword = sanitize_text_field( $_POST['confirmPassword'] );
			}

			update_option( 'mo_openid_admin_email', $email );
			update_option( 'mo_openid_admin_phone', $phone );
			if( strcmp( $password, $confirmPassword) == 0 ) {
				update_option( 'mo_openid_admin_password', $password );

				$customer = new CustomerOpenID();
				$content = json_decode($customer->check_customer(), true);
				if( strcasecmp( $content['status'], 'CUSTOMER_NOT_FOUND') == 0 ){
					$content = json_decode($customer->send_otp_token(), true);
										if(strcasecmp($content['status'], 'SUCCESS') == 0) {
											update_option( 'mo_openid_message', ' A passcode is sent to ' . get_option('mo_openid_admin_email') . '. Please enter the otp here to verify your email.');
											update_option('mo_openid_transactionId',$content['txId']);
											update_option('mo_openid_registration_status','MO_OTP_DELIVERED_SUCCESS');

											$this->mo_openid_show_success_message();
										}else{
											update_option('mo_openid_message','There was an error in sending email. Please click on Resend OTP to try again.');
											update_option('mo_openid_registration_status','MO_OTP_DELIVERED_FAILURE');
											$this->mo_openid_show_error_message();
										}
				}else{
						$this->get_current_customer();
				}

			} else {
				update_option( 'mo_openid_message', 'Passwords do not match.');
				delete_option('mo_openid_verify_customer');
				$this->mo_openid_show_error_message();
			}

		}else if(isset($_POST['option']) and $_POST['option'] == "mo_openid_validate_otp"){

			//validation and sanitization
			$otp_token = '';
			if( $this->mo_openid_check_empty_or_null( $_POST['otp_token'] ) ) {
				update_option( 'mo_openid_message', 'Please enter a value in OTP field.');
				update_option('mo_openid_registration_status','MO_OTP_VALIDATION_FAILURE');
				$this->mo_openid_show_error_message();
				return;
			} else if(!preg_match('/^[]0-9]*$/', $_POST['otp_token'])) {
				update_option( 'mo_openid_message', 'Please enter a valid value in OTP field.');
				update_option('mo_openid_registration_status','MO_OTP_VALIDATION_FAILURE');
				$this->mo_openid_show_error_message();
				return;
			} else{
				$otp_token = sanitize_text_field( $_POST['otp_token'] );
			}

			$customer = new CustomerOpenID();
			$content = json_decode($customer->validate_otp_token(get_option('mo_openid_transactionId'), $otp_token ),true);
			if(strcasecmp($content['status'], 'SUCCESS') == 0) {

					$this->create_customer();
			}else{
				update_option( 'mo_openid_message','Invalid one time passcode. Please enter a valid passcode.');
				update_option('mo_openid_registration_status','MO_OTP_VALIDATION_FAILURE');
				$this->mo_openid_show_error_message();
			}
		}
        else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_connect_verify_customer" ) {	//register the admin to miniOrange

						//validation and sanitization
						$email = '';
						$password = '';
						$illegal = "#$%^*()+=[]';,/{}|:<>?~";
						$illegal = $illegal . '"';
						if( $this->mo_openid_check_empty_or_null( $_POST['email'] ) || $this->mo_openid_check_empty_or_null( $_POST['password'] ) ) {
							update_option( 'mo_openid_message', 'All the fields are required. Please enter valid entries.');
							$this->mo_openid_show_error_message();
							return;
						} else if(strpbrk($_POST['email'],$illegal)) {
							update_option( 'mo_openid_message', 'Please match the format of Email. No special characters are allowed.');
							$this->mo_openid_show_error_message();
							return;
						} else{
							$email = sanitize_email( $_POST['email'] );
							$password = sanitize_text_field( $_POST['password'] );
						}

						update_option( 'mo_openid_admin_email', $email );
						update_option( 'mo_openid_admin_password', $password );
						$customer = new CustomerOpenID();
						$content = $customer->get_customer_key();
						$customerKey = json_decode( $content, true );
						if( json_last_error() == JSON_ERROR_NONE ) {
							update_option( 'mo_openid_admin_customer_key', $customerKey['id'] );
							update_option( 'mo_openid_admin_api_key', $customerKey['apiKey'] );
							update_option( 'mo_openid_customer_token', $customerKey['token'] );
							update_option( 'mo_openid_admin_phone', $customerKey['phone'] );
							update_option('mo_openid_admin_password', '');
							update_option( 'mo_openid_message', 'Your account has been retrieved successfully.');
							delete_option('mo_openid_verify_customer');
							$this->mo_openid_show_success_message();
						} else {
							update_option( 'mo_openid_message', 'Invalid username or password. Please try again.');
							$this->mo_openid_show_error_message();
						}
						update_option('mo_openid_admin_password', '');
		}
		else if(isset($_POST['option']) and $_POST['option'] == 'mo_openid_forgot_password'){
			$email = get_option('mo_openid_admin_email');
			$customer = new CustomerOpenID();
				$content = json_decode($customer->forgot_password($email),true);
					if(strcasecmp($content['status'], 'SUCCESS') == 0){
						update_option( 'mo_openid_message','You password has been reset successfully. Please enter the new password sent to your registered mail here.');
						$this->mo_openid_show_success_message();
					}else{
						update_option( 'mo_openid_message','An error occured while processing your request. Please try again.');
						$this->mo_openid_show_error_message();
					}
					
				
		}
		else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_enable_apps" ) {
			if(mo_openid_is_customer_registered()) {
				update_option( 'mo_openid_google_enable', isset( $_POST['mo_openid_google_enable']) ? $_POST['mo_openid_google_enable'] : 0);
				update_option( 'mo_openid_salesforce_enable', isset( $_POST['mo_openid_salesforce_enable']) ? $_POST['mo_openid_salesforce_enable'] : 0);
				update_option( 'mo_openid_facebook_enable', isset( $_POST['mo_openid_facebook_enable']) ? $_POST['mo_openid_facebook_enable'] : 0);
				update_option( 'mo_openid_linkedin_enable', isset( $_POST['mo_openid_linkedin_enable']) ? $_POST['mo_openid_linkedin_enable'] : 0);
				update_option( 'mo_openid_windowslive_enable', isset( $_POST['mo_openid_windowslive_enable']) ? $_POST['mo_openid_windowslive_enable'] : 0);
				update_option( 'mo_openid_amazon_enable', isset( $_POST['mo_openid_amazon_enable']) ? $_POST['mo_openid_amazon_enable'] : 0);
				update_option( 'mo_openid_instagram_enable', isset( $_POST['mo_openid_instagram_enable']) ? $_POST['mo_openid_instagram_enable'] : 0);
				update_option( 'mo_openid_twitter_enable', isset( $_POST['mo_openid_twitter_enable']) ? $_POST['mo_openid_twitter_enable'] : 0);
				
				update_option( 'mo_openid_default_login_enable', isset( $_POST['mo_openid_default_login_enable']) ? $_POST['mo_openid_default_login_enable'] : 0);
			    update_option( 'mo_openid_default_register_enable', isset( $_POST['mo_openid_default_register_enable']) ? $_POST['mo_openid_default_register_enable'] : 0);
			    update_option( 'mo_openid_default_comment_enable', isset( $_POST['mo_openid_default_comment_enable']) ? $_POST['mo_openid_default_comment_enable'] : 0);
				
				//Redirect URL
				update_option( 'mo_openid_login_redirect', $_POST['mo_openid_login_redirect']);
				update_option( 'mo_openid_login_redirect_url', $_POST['mo_openid_login_redirect_url'] );
				
				//Logout Url
				update_option( 'mo_openid_logout_redirect', $_POST['mo_openid_logout_redirect']);
				update_option( 'mo_openid_logout_redirect_url', $_POST['mo_openid_logout_redirect_url'] );
				
				//auto register
				update_option( 'mo_openid_auto_register_enable', isset( $_POST['mo_openid_auto_register_enable']) ? $_POST['mo_openid_auto_register_enable'] : 0);
				update_option( 'mo_openid_register_disabled_message', $_POST['mo_openid_register_disabled_message']);
				
			    update_option('mo_openid_login_widget_customize_text',$_POST['mo_openid_login_widget_customize_text'] );
			    update_option( 'mo_openid_login_button_customize_text',$_POST['mo_openid_login_button_customize_text'] );
			    update_option('mo_openid_login_theme',$_POST['mo_openid_login_theme'] );
				update_option( 'mo_openid_message', 'Your settings are saved successfully.' );
				
				//customization of icons
				update_option('mo_login_icon_custom_size',$_POST['mo_login_icon_custom_size'] );
				update_option('mo_login_icon_space',$_POST['mo_login_icon_space'] );
				update_option('mo_login_icon_custom_width',$_POST['mo_login_icon_custom_width'] );
				update_option('mo_login_icon_custom_height',$_POST['mo_login_icon_custom_height'] );
				update_option('mo_openid_login_custom_theme',$_POST['mo_openid_login_custom_theme'] );
				update_option( 'mo_login_icon_custom_color', $_POST['mo_login_icon_custom_color'] );
			
				
						$this->mo_openid_show_success_message();
						
			} else {
				update_option('mo_openid_message', 'Please register an account before trying to enable any app');
				$this->mo_openid_show_error_message();
			}
		}else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_contact_us_query_option" ) {
			// Contact Us query
			$email = $_POST['mo_openid_contact_us_email'];
			$phone = $_POST['mo_openid_contact_us_phone'];
			$query = $_POST['mo_openid_contact_us_query'];
			$customer = new CustomerOpenID();
			if ( $this->mo_openid_check_empty_or_null( $email ) || $this->mo_openid_check_empty_or_null( $query ) ) {
				update_option('mo_openid_message', 'Please fill up Email and Query fields to submit your query.');
				$this->mo_openid_show_error_message();
			} else {
				$submited = $customer->submit_contact_us( $email, $phone, $query );
				if ( $submited == false ) {
					update_option('mo_openid_message', 'Your query could not be submitted. Please try again.');
					$this->mo_openid_show_error_message();
				} else {
					update_option('mo_openid_message', 'Thanks for getting in touch! We shall get back to you shortly.');
					$this->mo_openid_show_success_message();
				}
			}
		}
		else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_resend_otp" ) {

					    $customer = new CustomerOpenID();
						$content = json_decode($customer->send_otp_token(), true);
									if(strcasecmp($content['status'], 'SUCCESS') == 0) {
											update_option( 'mo_openid_message', ' A one time passcode is sent to ' . get_option('mo_openid_admin_email') . ' again. Please check if you got the otp and enter it here.');
											update_option('mo_openid_transactionId',$content['txId']);
											update_option('mo_openid_registration_status','MO_OTP_DELIVERED_SUCCESS');
											$this->mo_openid_show_success_message();
									}else{
											update_option('mo_openid_message','There was an error in sending email. Please click on Resend OTP to try again.');
											update_option('mo_openid_registration_status','MO_OTP_DELIVERED_FAILURE');
											$this->mo_openid_show_error_message();
									}

		}else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_go_back" ){
				update_option('mo_openid_registration_status','');
				delete_option('mo_openid_new_registration');
				delete_option('mo_openid_admin_email');

		}else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_save_other_settings" ){
			if(mo_openid_is_customer_registered()) {
				update_option( 'mo_openid_google_share_enable', isset( $_POST['mo_openid_google_share_enable']) ? $_POST['mo_openid_google_share_enable'] : 0);
				update_option( 'mo_openid_facebook_share_enable', isset( $_POST['mo_openid_facebook_share_enable']) ? $_POST['mo_openid_facebook_share_enable'] : 0);
				update_option( 'mo_openid_linkedin_share_enable', isset( $_POST['mo_openid_linkedin_share_enable']) ? $_POST['mo_openid_linkedin_share_enable'] : 0);
				update_option( 'mo_openid_reddit_share_enable', isset( $_POST['mo_openid_reddit_share_enable']) ? $_POST['mo_openid_reddit_share_enable'] : 0);
				update_option( 'mo_openid_pinterest_share_enable', isset( $_POST['mo_openid_pinterest_share_enable']) ? $_POST['mo_openid_pinterest_share_enable'] : 0);
				update_option( 'mo_openid_twitter_share_enable', isset( $_POST['mo_openid_twitter_share_enable']) ? $_POST['mo_openid_twitter_share_enable'] : 0);
				update_option('mo_share_options_enable_home_page',isset( $_POST['mo_share_options_home_page']) ? $_POST['mo_share_options_home_page'] : 0);
				update_option('mo_share_options_enable_post',isset( $_POST['mo_share_options_post']) ? $_POST['mo_share_options_post'] : 0);
				update_option('mo_share_options_enable_static_pages',isset( $_POST['mo_share_options_static_pages']) ? $_POST['mo_share_options_static_pages'] : 0);
				update_option('mo_share_options_enable_post_position',$_POST['mo_share_options_enable_post_position'] );
				update_option('mo_openid_share_theme',$_POST['mo_openid_share_theme'] );
				
				
				update_option('mo_openid_share_widget_customize_text',$_POST['mo_openid_share_widget_customize_text'] );
				update_option('mo_openid_share_twitter_username', sanitize_text_field($_POST['mo_openid_share_twitter_username'])) ;
				update_option('mo_openid_share_widget_customize_direction_horizontal',isset( $_POST['mo_openid_share_widget_customize_direction_horizontal']) ? $_POST['mo_openid_share_widget_customize_direction_horizontal'] : 0);
				update_option('mo_openid_share_widget_customize_direction_vertical',isset( $_POST['mo_openid_share_widget_customize_direction_vertical']) ? $_POST['mo_openid_share_widget_customize_direction_vertical'] : 0);
				update_option('mo_sharing_icon_custom_size',isset( $_POST['mo_sharing_icon_custom_size']) ? $_POST['mo_sharing_icon_custom_size'] : 35);
				update_option('mo_sharing_icon_custom_color',$_POST['mo_sharing_icon_custom_color'] );
				update_option('mo_openid_share_custom_theme',$_POST['mo_openid_share_custom_theme'] );
				update_option('mo_sharing_icon_custom_font',$_POST['mo_sharing_icon_custom_font'] );
				update_option('mo_sharing_icon_space',$_POST['mo_sharing_icon_space'] );
				update_option( 'mo_openid_message', 'Your settings are saved successfully.' );
				$this->mo_openid_show_success_message();
			}  else {
				update_option('mo_openid_message', 'Please register an account before trying to enable any app');
				$this->mo_openid_show_error_message();
			}

		}
		
		

	}

	function create_customer(){
		$customer = new CustomerOpenID();
		$customerKey = json_decode( $customer->create_customer(), true );
		if( strcasecmp( $customerKey['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0 ) {
					$this->get_current_customer();
		} else if( strcasecmp( $customerKey['status'], 'SUCCESS' ) == 0 ) {
										update_option( 'mo_openid_admin_customer_key', $customerKey['id'] );
										update_option( 'mo_openid_admin_api_key', $customerKey['apiKey'] );
										update_option( 'mo_openid_customer_token', $customerKey['token'] );
										update_option('mo_openid_admin_password', '');
										update_option( 'mo_openid_message', 'Registration complete!');
										update_option('mo_openid_registration_status','MO_OPENID_REGISTRATION_COMPLETE');
										delete_option('mo_openid_verify_customer');
										delete_option('mo_openid_new_registration');
										$this->mo_openid_show_success_message();
		}
		update_option('mo_openid_admin_password', '');
	}

	function get_current_customer(){
		$customer = new CustomerOpenID();
		$content = $customer->get_customer_key();
		$customerKey = json_decode( $content, true );

					if( json_last_error() == JSON_ERROR_NONE ) {

								update_option( 'mo_openid_admin_customer_key', $customerKey['id'] );
								update_option( 'mo_openid_admin_api_key', $customerKey['apiKey'] );
								update_option( 'mo_openid_customer_token', $customerKey['token'] );
								update_option('mo_openid_admin_password', '' );
								update_option( 'mo_openid_message', 'Your account has been retrieved successfully.' );
								delete_option('mo_openid_verify_customer');
								delete_option('mo_openid_new_registration');
								$this->mo_openid_show_success_message();

					} else {
								update_option( 'mo_openid_message', 'You already have an account with miniOrange. Please enter a valid password.');
								update_option('mo_openid_verify_customer', 'true');
								delete_option('mo_openid_new_registration');
								$this->mo_openid_show_error_message();

					}

	}


	function miniorange_openid_menu() {

		//Add miniOrange plugin to the menu
		$page = add_menu_page( 'MO OpenID Settings ' . __( 'Configure OpenID', 'mo_openid_settings' ), 'miniOrange Social Login, Sharing', 'administrator',
		'mo_openid_settings', array( $this, 'mo_login_widget_openid_options' ),plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png');
	}
	
	public function mo_get_output( $atts ){
		if(!is_user_logged_in() && mo_openid_is_customer_registered()){
			$miniorange_widget = new mo_openid_login_wid();
			$html = $miniorange_widget->openidloginFormShortCode( $atts );
			return $html;
		}
	}
	public function mo_get_sharing_output( $atts ){
		if(mo_openid_is_customer_registered()){
			global $post;
			$content=get_the_content();
			$title = str_replace('+', '%20', urlencode($post->post_title));
			$content=strip_shortcodes( strip_tags( get_the_content() ) );
			$html = mo_openid_share_shortcode( $atts, $title);
			return $html;
		}
	}
	
	public function mo_get_vertical_sharing_output( $atts ){
		if(mo_openid_is_customer_registered()){
			global $post;
			$content=get_the_content();
			$title = str_replace('+', '%20', urlencode($post->post_title));
			$content=strip_shortcodes( strip_tags( get_the_content() ) );
			$html = mo_openid_vertical_share_shortcode( $atts, $title);
			return $html;
		}
	}
	
}

new Miniorange_OpenID_SSO;
?>