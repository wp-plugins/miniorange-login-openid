<?php

class mo_openid_login_wid extends WP_Widget {

	public function __construct() {
		
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'init', array( $this, 'mo_openid_start_session' ) );
		add_action( 'wp_logout', array( $this, 'mo_openid_end_session' ) );

		parent::__construct(
	 		'mo_openid_login_wid',
			'miniOrange Social Login Widget',
			array( 'description' => __( 'Login and share using Social Apps like Google, Facebook, LinkedIn.', 'flw' ), )
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
				$selected_theme = get_option('mo_openid_login_theme');
				$appsConfigured = get_option('mo_openid_google_enable') | get_option('mo_openid_salesforce_enable') | get_option('mo_openid_facebook_enable') | get_option('mo_openid_linkedin_enable') | get_option('mo_openid_instagram_enable') | get_option('mo_openid_amazon_enable') | get_option('mo_openid_windowslive_enable');
				if( ! is_user_logged_in() ) {

					if( $appsConfigured ) {
						$this->mo_openid_load_login_script();
					?>

						 <a href="http://miniorange.com/single-sign-on-sso" hidden></a>
						 
						 <div class="app-icons">
						
						 <p><?php   echo get_option('mo_openid_login_widget_customize_text'); ?>
						</p>
					<?php
						
						if( get_option('mo_openid_google_enable') ) {
							if($selected_theme == 'button'){
						?>
						
							<a href="javascript:void(0)" onClick="moOpenIdLogin('google');" class="btn btn-block btn-social btn-google" > <i class="fa fa-google-plus"></i><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Google</a>
						<?php }
						else{ ?>
						<a href="javascript:void(0)" onClick="moOpenIdLogin('google');" ><img src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
						<?php
						}
						}

						if( get_option('mo_openid_facebook_enable') ) {
							if($selected_theme == 'button'){					
						?> <a href="javascript:void(0)" onClick="moOpenIdLogin('facebook');" class="btn btn-block btn-social btn-facebook" > <i class="fa fa-facebook"></i><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Facebook</a>
						<?php }
						else{ ?>
			
							<a href="javascript:void(0)" onClick="moOpenIdLogin('facebook');"><img src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>

						<?php }
						
						}
					if( get_option('mo_openid_linkedin_enable') ) {
									if($selected_theme == 'button'){ ?> 
							<a href="javascript:void(0)" onClick="moOpenIdLogin('linkedin');" class="btn btn-block btn-social btn-linkedin" > <i class="fa fa-linkedin"></i><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> LinkedIn</a>
						<?php }
						else{ ?>
							<a href="javascript:void(0)" onClick="moOpenIdLogin('linkedin');"><img src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
								<?php }
						}if( get_option('mo_openid_instagram_enable') ) {
							if($selected_theme == 'button'){	?>				
						 <a href="javascript:void(0)" onClick="moOpenIdLogin('instagram');" class="btn btn-block btn-social btn-instagram" > <i class="fa fa-instagram"></i><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Instagram</a>
						<?php }
						else{ ?>
						

						<a href="javascript:void(0)" onClick="moOpenIdLogin('instagram');"><img  src="<?php echo plugins_url( 'includes/images/icons/instagram.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}if( get_option('mo_openid_amazon_enable') ) {
							if($selected_theme == 'button'){					
						?> <a href="javascript:void(0)" onClick="moOpenIdLogin('amazon');" class="btn btn-block btn-social btn-linkedin" ><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Amazon</a>
						<?php }
						else{ ?>

						<a href="javascript:void(0)" onClick="moOpenIdLogin('amazon');"><img  src="<?php echo plugins_url( 'includes/images/icons/amazon.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}if( get_option('mo_openid_salesforce_enable') ) {
								if($selected_theme == 'button'){					
						?> <a href="javascript:void(0)" onClick="moOpenIdLogin('salesforce');" class="btn btn-block btn-social btn-linkedin" > <?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Salesforce</a>
						<?php }
						else{ ?>
						

						<a href="javascript:void(0)" onClick="moOpenIdLogin('salesforce');"><img  src="<?php echo plugins_url( 'includes/images/icons/salesforce.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>" ></a>
						<?php }
						}if( get_option('mo_openid_windowslive_enable') ) {
							if($selected_theme == 'button'){					
						?> <a href="javascript:void(0)" onClick="moOpenIdLogin('windowslive');" class="btn btn-block btn-social btn-microsoft" > <i class="fa fa-windows"></i><?php   
									echo get_option('mo_openid_login_button_customize_text'); 	?> Microsoft</a>
						<?php }
						else{ ?>
					

						<a href="javascript:void(0)" onClick="moOpenIdLogin('windowslive');"><img  src="<?php echo plugins_url( 'includes/images/icons/windowslive.png', __FILE__ )?>" class="<?php echo $selected_theme; ?>"></a>
						<?php }
						}
						?></div> <br>
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
				<?php
					if ( strpos($_SERVER['REQUEST_URI'],'wp-login.php') !== FALSE){
							$redirect_url = site_url() . '/wp-login.php';

					}else{
					    	$redirect_url = site_url();
    				}
    			?>
					window.location.href = '<?php echo $redirect_url; ?>' + '/?option=getMoSocialLogin&app_name=' + app_name;
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
		wp_enqueue_style( 'style_login_widget', plugins_url( 'miniorange-login-openid/includes/css/mo_openid_style.css' ) );
		wp_enqueue_style( 'mo-wp-bootstrap-social',plugins_url('includes/css/bootstrap-social.css', __FILE__), false );
		wp_enqueue_style( 'mo-wp-bootstrap-main',plugins_url('includes/css/bootstrap.min.css', __FILE__), false );
		wp_enqueue_style( 'mo-wp-font-awesome',plugins_url('includes/css/font-awesome.min.css', __FILE__), false );
	}

}

function mo_openid_login_validate(){
	if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'getMoSocialLogin' ) !== false ) {
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

			if ( strpos($_SERVER['REQUEST_URI'],'wp-login.php') !== FALSE){
					$return_url = urlencode( site_url() . '/wp-admin/?option=moopenid' );
					echo $return_url;

			}else{
    			$return_url = urlencode( site_url() . '/?option=moopenid' );
    			echo "else";
    		}

			$url = get_option('mo_openid_host_name') . '/moas/openid-connect/client-app/authenticate?token=' . $token_params . '&id=' . get_option('mo_openid_admin_customer_key') . '&encrypted=true&app=' . $_REQUEST['app_name'] . '_oauth&returnurl=' . $return_url;
			wp_redirect( $url );
			exit;
		}

		if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'moopenid' ) !== false ){

			//do stuff after returning from oAuth processing

			$user_email = $_POST['email'];
			if( isset( $_POST['username']  )){
				$user_name = $_POST['username'];
				$user_email = $user_name.'@instagram.com';
			}

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

				$redirect_url = str_replace('?option=moopenid','',$_SERVER['REQUEST_URI']);
				
					wp_redirect($redirect_url);
					exit;
			
			}
		}
	
	



add_action( 'widgets_init', create_function( '', 'register_widget( "mo_openid_login_wid" );' ) );
add_action( 'init', 'mo_openid_login_validate' );
?>