<?php
/*
Plugin Name: miniOrange OpenId Login Widget
Plugin URI: http://miniorange.com/
Description: This is a miniOrange login plugin as widget. It uses OpenID Connect for authentication from miniOrange. 
Version: 1.0
Author: miniOrange
Author URI: http://miniorange.com/
*/


include_once dirname( __FILE__ ) . '/login_mo_widget.php';


class openid_mo_login {
	
	function __construct() {
		add_action( 'admin_menu', array( $this, 'miniorange_login_widget_openid_menu' ) );
		add_action( 'admin_init',  array( $this, 'miniorange_login_widget_openid_save_settings' ) );
		add_action( 'plugins_loaded',  array( $this, 'mo_login_widget_text_domain' ) );
	}
	
	function  mo_login_widget_openid_options () {
		global $wpdb;
		$client_id = get_option('client_id');
		$client_secret = get_option('client_secret');
		
		?>
		<form name="f" method="post" action="">
		<input type="hidden" name="option" value="login_widget_openid_save_settings" />
		<table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px;">
		  <tr>
			<td width="45%"><h1>miniOrange Login Widget</h1></td>
			<td width="55%">&nbsp;</td>
		  </tr>
		  <tr>
			<td><strong>Client ID:</strong></td>
			<td><input type="text" name="client_id" value="<?php echo $client_id;?>" /></td>
		  </tr>
		  
		   <tr>
			<td><strong>Client Secret:</strong></td>
			 <td><input type="text" name="client_secret" value="<?php echo $client_secret;?>" /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
		  </tr>
		  <tr>
			<td colspan="2"><?php $this->mo_login_help();?></td>

		  </tr>
		</table>
		</form>
		<?php 
	}
	
	function mo_login_widget_text_domain(){
		load_plugin_textdomain('flw', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
	function mo_login_help(){ ?>
		<p><font color="#FF0000"><strong>Note*</strong></font>
			    <br />
		      You need to create a new <b>miniOrange OpenID Application</b> to setup this plugin. Please follow the instructions provided below.
			</p>
			  <p>
			 <strong>1.</strong> Go to <a href="https://auth.miniorange.com/moas/login target="_blank">miniOrange Admin Console</a><br/>
			 <strong>2.</strong> Click on <b>"Apps"</b> menu. Then click on <b>Configure Apps</b> button.<br/>
			 <strong>3.</strong> From applications Select <b>"OpenID Application"</b>.<br/>
			 <strong>4.</strong> Enter your wordpress application name, description. And in the redirect URL add : <b>"http://(your-wordpress-site-url)/?option=mologin"</b>. <br/>
			 <strong>5.</strong> Click save. Go to Edit Application and Note <b>Client ID</b> and <b>Client Secret</b>.<br/>
			 <strong>6.</strong> Copy paste the Client Id and Client Secret here. That's All. Have fun :)<br/>

			  </p>
			  
	<?php }
	
	function mo_comment_plugin_addon_options(){
	global $wpdb;
	$mo_comment_addon = new openid_mo_comment_settings;
	$mo_comments_color_scheme = get_option('mo_comments_color_scheme');
	$mo_comments_width = get_option('mo_comments_width');
	$mo_comments_no = get_option('mo_comments_no');
	?>
	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="save_openid_mo_comment_settings" />
	<table width="100%" border="0" style="background-color:#FFFFFF; margin-top:20px; width:98%; padding:5px; border:1px solid #999999; ">
	  <tr>
		<td colspan="2"><h1>Social Comments Settings</h1></td>
	  </tr>
	  <?php do_action('mo_comments_settings_top');?>
	   <tr>
		<td><h3>Facebook Comments</h3></td>
		<td></td>
	  </tr>
	   <tr>
		<td><strong>Language</strong></td>
		<td><select name="mo_comments_language">
			<option value=""> -- </option>
			<?php echo $mo_comment_addon->language_selected($mo_comments_language);?>
		</select>
		</td>
	  </tr>
	 <tr>
		<td><strong>Color Scheme</strong></td>
		<td><select name="mo_comments_color_scheme">
			<?php echo $mo_comment_addon->get_color_scheme_selected($mo_comments_color_scheme);?>
		</select>
		</td>
	  </tr>
	   <tr>
		<td><strong>Width</strong></td>
		<td><input type="text" name="mo_comments_width" value="<?php echo $mo_comments_width;?>"/> In Percent (%)</td>
	  </tr>
	   <tr>
		<td><strong>No of Comments</strong></td>
		<td><input type="text" name="mo_comments_no" value="<?php echo $mo_comments_no;?>"/> Default is 10</td>
	  </tr>
	  <?php do_action('mo_comments_settings_bottom');?>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="2">Use <span style="color:#000066;">[social_comments]</span> shortcode to display Facebook / Disqus Comments in post or page.<br />
		 Example: <span style="color:#000066;">[social_comments title="Comments"]</span>
		 <br /> <br />
		 Or else<br /> <br />
		 You can use this function <span style="color:#000066;">social_comments()</span> in your template to display the Facebook Comments. <br />
		 Example: <span style="color:#000066;">&lt;?php social_comments("Comments");?&gt;</span>
		 </td>
	  </tr>
	</table>
	</form>
	<?php 
	}
	
	function miniorange_login_widget_openid_save_settings(){
		if(isset($_POST['option']) and $_POST['option'] == "login_widget_openid_save_settings"){
			update_option( 'client_id', $_POST['client_id'] );
			update_option( 'client_secret', $_POST['client_secret'] );
		}
	}
	
	function miniorange_login_widget_openid_menu () {
		add_options_page( 'MO Login Widget', 'MO Login Widget', 'activate_plugins', 'mo_login_widget_openid', array( $this, 'mo_login_widget_openid_options' ));
	}
	
	function help_support(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px;">
	  <tr>
		<td align="right"><a href="http://aviplugins.com/support.php" target="_blank">Help and Support</a></td>
	  </tr>
	</table>
	<?php
	}
	
	function mo_login_pro_add(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px;">
  <tr>
    <td><p>There is a PRO version of this plugin that supports login with <strong>Facebook</strong>, <strong>Google</strong>,  <strong>Twitter</strong> and <strong>LinkedIn</strong>. You can get it <a href="http://aviplugins.com/mo-login-widget-pro/" target="_blank">here</a> in <strong>USD 3.00</strong> </p></td>
  </tr>
</table>
	<?php }
	
	function mo_comment_addon_add(){ 
		if ( !is_plugin_active( 'mo-comments-openid-addon/mo_comment.php' ) ) {
	?>
		<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px;">
	  <tr>
		<td><p>There is a <strong>Facebook Comments Addon</strong> for this plugin. The plugin replace the default <strong>Wordpress</strong> Comments module and enable <strong>Facebook</strong>/<strong>Disqus</strong> Comments Module. You can get it <a href="http://www.aviplugins.com/mo-comments-openid-addon/" target="_blank">here</a> in <strong>USD 1.00</strong> </p></td>
	  </tr>
	</table>
	<?php 
		}
	}
	
	function donate_form_miniorange_login(){
		if ( !is_plugin_active( 'mo-comments-openid-addon/mo_comment.php' ) ) {
	?>
		<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; margin:2px;">
		 <tr>
		 <td align="right"><h3>Even $0.60 Can Make A Difference</h3></td>
			<td><form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				  <input type="hidden" name="cmd" value="_xclick">
				  <input type="hidden" name="business" value="avifoujdar@gmail.com">
				  <input type="hidden" name="item_name" value="Donation for plugins (MO Login)">
				  <input type="hidden" name="currency_code" value="USD">
				  <input type="hidden" name="amount" value="0.60">
				  <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Make a donation with PayPal">
				</form></td>
		  </tr>
		</table>
	<?php }
	}
}
new openid_mo_login;