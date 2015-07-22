<?php
$url =  get_permalink();
$options = get_option('mo_enable_share_to_apps');
?>
<script>
	function popupCenter(pageURL, w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, "_blank",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}
</script>
<style>
a{
	cursor:pointer;
}
</style>

						 <a href="http://miniorange.com/single-sign-on-sso" hidden></a>
						 <div class="app-icons">
						 <p>Share with:
					<?php
						if( get_option('mo_openid_google_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" ><img src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="app-share-icons" ></a>
						<?php
						}

						if( get_option('mo_openid_facebook_enable') ) {

							$link = 'https://www.facebook.com/dialog/feed?app_id=766555246789034&amp;link='.$url.'&amp;caption='.$title.'&amp;redirect_uri=http://miniorange.com/social_share_redirect';
						?>
						

							<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" ><img src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="app-share-icons" ></a>

						<?php
						}
						if( get_option('mo_openid_linkedin_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" ><img src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="app-share-icons" ></a>
						<?php
						}
						?></p></div> <br>
						<?php

	31

?>