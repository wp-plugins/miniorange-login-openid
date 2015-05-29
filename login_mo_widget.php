<?php
require('AuthorizeOpenIDRequest.php');
class mo_login_wid extends WP_Widget {
	private $appId,$appSecret;
	public function __construct() {
		$this->appId = get_option('client_id');
		$this->appSecret = get_option('client_secret');
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		parent::__construct(
	 		'mo_login_wid',
			'miniOrange Login Widget',
			array( 'description' => __( 'This is a miniOrange login form in the widget.', 'flw' ), )
		);
	 }

	public function widget( $args, $instance ) {
		extract( $args );
		
		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );
		
		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->loginForm();
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}


	public function form( $instance ) {
		$wid_title = $instance[ 'wid_title' ];
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title:'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('wid_title'); ?>" name="<?php echo $this->get_field_name('wid_title'); ?>" type="text" value="<?php echo $wid_title; ?>" />
		</p>
		<?php 
	}
	
	public function loginForm(){
		global $post;
		$this->error_message();
		$this->LoadScript();
		if(!is_user_logged_in()){
		?>
		<form name="login" id="login" method="post" action="">
		<input type="hidden" name="option" value="openid_user_login" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

		<li><font size="+1" style="vertical-align:top;"> </font> <a href="javascript:void(0)" onClick="MOLogin();">Login with miniOrange</a></li>
			</ul>
		</form>
		<?php 
		} else {
		global $current_user;
     	get_currentuserinfo();
		$link_with_username = __('Howdy,','flw').$current_user->display_name;
		?>
		<ul class="login_wid">
			<li><?php echo $link_with_username;?> | <a href="<?php echo wp_logout_url(site_url()); ?>" title="<?php _e('Logout','flw');?>"><?php _e('Logout','flw');?></a></li>
		</ul>
		<?php 
		}
	}
	
	private function LoadScript(){
	?>
	<script type="text/javascript">
window.moAsyncInit = function() {
	MO.init({
	appId      : "<?php echo $this->appId?>", // replace your app id here
	status     : true, 
	cookie     : true, 
	xmoml      : true  
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

function MOLogin(){
			window.location.href = "https://test.miniorange.com/moas/idp/openidsso?client_id=<?php echo get_option('client_id'); ?>&redirect_uri=<?php echo urlencode(site_url() . '?option=mologin'); ?>&state=kienvoeinc&nonce=eourvoeirn&response_type=code";
	
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
		wp_enqueue_style( 'style_login_widget', plugins_url( 'facebook-login-openid/style_login_widget.css' ) );
	}
	
} 

function mo_login_validate(){
	if(isset($_POST['option']) and $_POST['option'] == "openid_user_login"){
		global $post;
		if($_POST['user_username'] != "" and $_POST['user_password'] != ""){
			$creds = array();
			$creds['user_login'] = $_POST['user_username'];
			$creds['user_password'] = $_POST['user_password'];
			$creds['remember'] = true;
		
			$user = wp_signon( $creds, true );
			if($user->ID == ""){
				$_SESSION['msg_class'] = 'error_wid_login';
				$_SESSION['msg'] = __('Error in login!','flw');
			} else{
				wp_set_auth_cookie($user->ID);
				wp_redirect( site_url() );
				exit;
			}
		} else {
			$_SESSION['msg_class'] = 'error_wid_login';
			$_SESSION['msg'] = __('Username or password is empty!','flw');
		}
		
	}
	
	
	if(isset($_REQUEST['option']) and strpos($_REQUEST['option'],'mologin') !== false){

		global $wpdb;
		$appid 		= get_option('client_id');
		$appsecret  = get_option('client_secret');
		
		$codeArray= explode("=", $_REQUEST['option']);
		$code = $codeArray[1]; 
		$obj = new AuthorizeOpenIDRequest();
		$obj->authCode = $code;
		$obj->hostName = 'test.miniorange.com';
		$obj->clientSecret = $appsecret;
		
		$token = $obj->sendTokenRequest();
		$jObj = json_decode($token);
		$access_token = $jObj->access_token;
		
		$user_info = $obj->sendUserInfoRequest($access_token);
		$uinfo = json_decode($user_info, true);
		
		$user_email = $uinfo['email'];

		
		
		//Perform authentication OPENID
		
		
  
		  if( email_exists( $user_email )) { // user is a member 
			  $user = get_user_by('login', $user_email );
			  $user_id = $user->ID;
			  wp_set_auth_cookie( $user_id, true );
		   } else { // this user is a guest
			  $random_password = wp_generate_password( 10, false );
			  $user_id = wp_create_user( $user_email, $random_password, $user_email );
			  wp_set_auth_cookie( $user_id, true );
		   }
		   
   			wp_redirect( site_url() );
			exit;
   
		}		
	}


add_action( 'widgets_init', create_function( '', 'register_widget( "mo_login_wid" );' ) );
add_action( 'init', 'mo_login_validate' );
?>