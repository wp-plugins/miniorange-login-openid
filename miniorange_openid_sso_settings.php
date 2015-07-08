<?php
/**
* Plugin Name: miniOrange OpenID SSO
* Plugin URI: http://miniorange.com
* Description: This plugin enables login with google using openid connect.
* Version: 1.0.1
* Author: miniOrange
* Author URI: http://miniorange.com
* License: GPL2
*/

include_once dirname( __FILE__ ) . '/class-mo-openid-login-widget.php';
require('miniorange_openid_sso_settings_page.php');
require('class-mo-openid-sso-customer.php');
require('miniorange_openid_sso_support.php');



class Miniorange_OpenID_SSO {

	function __construct() {
			add_action( 'admin_menu', array( $this, 'miniorange_openid_menu' ) );
			add_action( 'admin_init',  array( $this, 'miniorange_openid_save_settings' ) );
			register_deactivation_hook(__FILE__, array( $this, 'mo_openid_login_deactivate'));
			add_action( 'plugins_loaded',  array( $this, 'mo_login_widget_text_domain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_style' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'plugin_settings_script' ) );
			remove_action( 'admin_notices', array( $this, 'mo_openid_success_message') );
		    remove_action( 'admin_notices', array( $this, 'mo_openid_error_message') );
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

		function plugin_settings_style() {
				wp_enqueue_style( 'mo_openid_admin_settings_style', plugins_url('includes/css/style_settings.css', __FILE__));
				wp_enqueue_style( 'mo_openid_admin_settings_phone_style', plugins_url('includes/css/phone.css', __FILE__));
			}

			function plugin_settings_script() {
				wp_enqueue_script( 'mo_openid_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__ ));
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

		public function mo_openid_login_deactivate() {
			//delete all stored key-value pairs

			delete_option('mo_openid_host_name');
			delete_option('mo_openid_new_registration');
			delete_option('mo_openid_admin_email');
			delete_option('mo_openid_admin_password');
			delete_option('mo_openid_admin_phone');
			delete_option('mo_openid_verify_customer');

			delete_option('mo_openid_customer_token');
			delete_option('mo_openid_message');
			delete_option('mo_openid_admin_customer_key');
			delete_option('mo_openid_admin_api_key');
		    delete_option('mo_openid_google_enable');


		}

		function mo_login_widget_text_domain(){
			load_plugin_textdomain('flw', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
		}




		function miniorange_openid_save_settings(){
if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_connect_register_customer" ) {	//register the admin to miniOrange

			//validation and sanitization
			$email = '';
			$phone = '';
			$password = '';
			$confirmPassword = '';
			if( $this->mo_openid_check_empty_or_null( $_POST['email'] ) || $this->mo_openid_check_empty_or_null( $_POST['phone'] ) || $this->mo_openid_check_empty_or_null( $_POST['password'] ) || $this->mo_openid_check_empty_or_null( $_POST['confirmPassword'] ) ) {
				update_option( 'mo_openid_message', 'All the fields are required. Please enter valid entries.');
				$this->mo_openid_show_error_message();
				return;
			} else if( strlen( $_POST['password'] ) < 6 || strlen( $_POST['confirmPassword'] ) < 6){	//check password is of minimum length 6
						update_option( 'mo_openid_message', 'Choose a password with minimum length 6.');
						$this->mo_openid_show_error_message();
						return;
			} else{
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
				$customerKey = json_decode( $customer->create_customer(), true );

				if( strcasecmp( $customerKey['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0 ) {
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
				} else if( strcasecmp( $customerKey['status'], 'SUCCESS' ) == 0 ) {
					update_option( 'mo_openid_admin_customer_key', $customerKey['id'] );
					update_option( 'mo_openid_admin_api_key', $customerKey['apiKey'] );
					update_option( 'mo_openid_customer_token', $customerKey['token'] );
					update_option('mo_openid_admin_password', '');
					update_option( 'mo_openid_message', 'Registration complete!');
					delete_option('mo_openid_verify_customer');
					delete_option('mo_openid_new_registration');
					$this->mo_openid_show_success_message();
				}
			} else {
				update_option( 'mo_openid_message', 'Passwords do not match.');
				delete_option('mo_openid_verify_customer');
				$this->mo_openid_show_error_message();
			}
			update_option('mo_openid_admin_password', '');
		}
			if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_connect_verify_customer" ) {	//register the admin to miniOrange

						//validation and sanitization
						$email = '';
						$password = '';
						if( $this->mo_openid_check_empty_or_null( $_POST['email'] ) || $this->mo_openid_check_empty_or_null( $_POST['password'] ) ) {
							update_option( 'mo_openid_message', 'All the fields are required. Please enter valid entries.');
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
		else if( isset( $_POST['option'] ) and $_POST['option'] == "mo_openid_google" ) {


			if(mo_openid_is_customer_registered()) {
				update_option( 'mo_openid_google_enable', isset( $_POST['mo_openid_google_enable']) ? $_POST['mo_openid_google_enable'] : 0);

						update_option( 'mo_openid_message', 'Your settings are saved successfully.' );
						$this->mo_openid_show_success_message();


			} else {
				update_option('mo_openid_message', 'Please register customer before trying to save other configurations');
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

	}


		function miniorange_openid_menu() {

			//Add miniOrange plugin to the menu
			$page = add_menu_page( 'MO OpenID Settings ' . __( 'Configure OpenID', 'mo_openid_settings' ), 'Google OpenID Connect', 'administrator',
			'mo_openid_settings', array( $this, 'mo_login_widget_openid_options' ),plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png');



		}
}






new Miniorange_OpenID_SSO;
?>