<?php
$url =  get_permalink();

	
	$selected_theme = get_option('mo_openid_share_theme');


?>
<script>
	function popupCenter(pageURL, w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, "_blank",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}
	function pinIt()
	{
       var e = document.createElement('script');
       e.setAttribute('type','text/javascript');
       e.setAttribute('charset','UTF-8');
       e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
	   document.body.appendChild(e);
	   
       
	}
</script>


						 <a href="http://miniorange.com/single-sign-on-sso" hidden></a>
						 <div class="app-icons circle">
						 <p><?php echo get_option('mo_openid_share_widget_customize_text');?>
					<?php
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" class="share-link"><img src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}

						if( get_option('mo_openid_facebook_share_enable') ) {

							$link = 'https://www.facebook.com/dialog/feed?app_id=766555246789034&amp;link='.$url.'&amp;caption='.$title.'&amp;redirect_uri=http://miniorange.com/social_share_redirect';
						?>
						

							<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" class="share-link"><img src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>

						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" class="share-link" ><img src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}if( get_option('mo_openid_twitter_share_enable') ) {
								$link = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url;
								?>

								<a onclick="popupCenter('<?php echo $link; ?>', 600, 600);" class="share-link" ><img src="<?php echo plugins_url( 'includes/images/icons/twitter.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a  href='javascript:pinIt();' class="share-link" ><img src="<?php echo plugins_url( 'includes/images/icons/pininterest.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a  onclick="popupCenter('<?php echo $link; ?>', 600, 600);" class="share-link" ><img src="<?php echo plugins_url( 'includes/images/icons/reddit.png', __FILE__ )?>" class="app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						?></p></div> <br>
						<?php

	31

?>