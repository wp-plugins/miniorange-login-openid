<?php

class mo_openid_login_wid extends WP_Widget {

	public function __construct() {
		update_option( 'mo_openid_host_name', 'https://auth.miniorange.com' );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'init', array( $this, 'mo_openid_start_session' ) );
		add_action( 'wp_logout', array( $this, 'mo_openid_end_session' ) );

		parent::__construct(
	 		'mo_openid_login_wid',
			'miniOrange OpenID Login Widget',
			array( 'description' => __( 'Login to wordpress with OpenID Connect Providers like google, salesforce.', 'flw' ), )
		);
	 }

	function mo_openid_start_session() {
			if( ! session_id() ) {
				session_start();
			}
		}

		function mo_openid_end_session() {
			session_destroy();
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
				$appsConfigured = get_option('mo_openid_google_enable') | get_option('mo_openid_salesforce_enable');
				if( ! is_user_logged_in() ) {

					if( $appsConfigured ) {
						$this->mo_openid_load_login_script();
					?>
						 <a href="http://miniorange.com/cloud-identity-broker-service" hidden></a>
						 <div class="app-icons">
					<?php
						if( get_option('mo_openid_google_enable') ) {
						?>
						<a href="javascript:void(0)" onClick="moOpenIdLogin('google');" ><img src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" ></a>
						<?php
						}
						if( get_option('mo_openid_salesforce_enable') ) {
						?>

						<a href="javascript:void(0)" onClick="moOpenIdLogin('salesforce');"><img src="<?php echo plugins_url( 'includes/images/icons/salesforce.png', __FILE__ )?>" ></a>
						<?php
						}


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
					<div id="logged_in_user" class="openid_login_wid">
						<li><?php echo $link_with_username;?> | <a href="<?php echo wp_logout_url( site_url() ); ?>" title="<?php _e('Logout','flw');?>"><?php _e('Logout','flw');?></a></li>
					</div>
					<?php
				}
			}

			private function mo_openid_load_login_script() {
			?>
			<script type="text/javascript">
				function moOpenIdLogin(app_name) {
					window.location.href = '<?php echo site_url() ?>' + '/?option=generateDynmicUrl&app_name=' + app_name;
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

	public function register_plugin_styles() {
		wp_enqueue_style( 'style_login_widget', plugins_url( 'miniorange-login-openid/includes/css/style_settings.css' ) );
	}

}

function mo_openid_login_validate(){
	if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'generateDynmicUrl' ) !== false ) {
			$client_name = "wordpress";
			$timestamp = round( microtime(true) * 1000 );
			$api_key = get_option('mo_openid_admin_api_key');
			$token = $client_name . ':' . $timestamp . ':' . $api_key;

			$customer_token = get_option('mo_openid_customer_token');
			$blocksize = 16;
			$pad = $blocksize - ( strlen( $token ) % $blocksize );
			$token =  $token . str_repeat( chr( $pad ), $pad );
			$token_params_encrypt = mcrypt_encrypt( MCRYPT_RIJNDAEL_128, $customer_token, $token, MCRYPT_MODE_ECB );
			$token_params_encode = base64_encode( $token_params_encrypt );
			$token_params = urlencode( $token_params_encode );

			$return_url = urlencode( site_url() . '/?option=moopenid' );
			$url = get_option('mo_openid_host_name') . '/moas/openid-connect/client-app/authenticate?token=' . $token_params . '&id=' . get_option('mo_openid_admin_customer_key') . '&encrypted=true&app=' . $_REQUEST['app_name'] . '_oauth&returnurl=' . $return_url;
			wp_redirect( $url );
			exit;
		}

		if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'moopenid' ) !== false ){

			//do stuff after returning from oAuth processing

			$user_email = $_POST['email'];


			if( $user_email ) {
				if( email_exists( $user_email ) ) { // user is a member
					  $user 	= get_user_by('email', $user_email );
					  $user_id 	= $user->ID;
					  wp_set_auth_cookie( $user_id, true );
				} else { // this user is a guest
					  $random_password 	= wp_generate_password( 10, false );
					  $user_id 			= wp_create_user( $user_email, $random_password, $user_email );
					  wp_set_auth_cookie( $user_id, true );
				}
			}

			wp_redirect( site_url() );
			exit;

		}
	}

add_action( 'widgets_init', create_function( '', 'register_widget( "mo_openid_login_wid" );' ) );
add_action( 'init', 'mo_openid_login_validate' );
?>