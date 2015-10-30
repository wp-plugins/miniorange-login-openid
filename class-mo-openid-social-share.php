<?php
if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
	$http = "https://";
} else {
	$http =  "http://";
}
$url = $http . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];

	
	$selected_theme = get_option('mo_openid_share_theme');
	$selected_direction = get_option('mo_openid_share_widget_customize_direction');
	$sharingSize = get_option('mo_sharing_icon_custom_size');
	$custom_color = get_option('mo_sharing_icon_custom_color');
	$custom_theme = get_option('mo_openid_share_custom_theme');
	$fontColor = get_option('mo_sharing_icon_custom_font');
	$spaceBetweenIcons = get_option('mo_sharing_icon_space');
	$twitter_username = get_option('mo_openid_share_twitter_username');
	
	$orientation = 'hor';
	if($landscape) {
		if($landscape == 'horizontal') {
			$orientation = 'hor';
		} else if($landscape == 'vertical') {
			$orientation = 'ver';
		}
	} else {
		if(get_option('mo_openid_share_widget_customize_direction_horizontal')) {
			$orientation = 'hor';
		} else if(get_option('mo_openid_share_widget_customize_direction_vertical')) {
			$orientation = 'ver';
		}
	}
	
	if($orientation == 'ver') {
		$url = get_site_url();
	}
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
						 <div class="mo-openid-app-icons circle ">
						 <p><?php 
							if( $orientation == 'hor' ) {
								echo get_option('mo_openid_share_widget_customize_text');
						 ?>
						 <div class="horizontal">
					<?php
					
						if($custom_theme == 'custom'){

						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-facebook" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>

						<?php
						}
						
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-twitter" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-google-plus" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;"></i></a>
						<?php
						}if( get_option('mo_openid_vkontakte_share_enable') ) {
								$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
								<a title="Vkontakte"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-vk" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
								
						?>
								<a title="Tumblr"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-tumblr" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
						?>
								<a title="StumbleUpon"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-stumbleupon" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
							
						<?php
						}
						
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkekIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-linkedin" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-reddit" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest"  href='javascript:pinIt();' class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-pinterest" style="padding-top:3px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-10); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}if( get_option('mo_openid_pocket_share_enable') ) {
								$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
						?>
								<a title="Pocket"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-get-pocket" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
							
						<?php
						}if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
						?>
								<a title="Digg"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-digg" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								 
						?>
								<a title="Delicious"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-delicious" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
						?>
								<a title="Odnoklassniki"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-odnoklassniki" style="padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}			
												
							
						}
						
						else if($custom_theme == 'customFont'){
						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-facebook" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>

						<?php
						}
						
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-twitter" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-google-plus" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_vkontakte_share_enable') ) {
							$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
						<a title="Vkontakte" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-vk" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
								?>

								<a title="Tumblr"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-tumblr" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="StumbleUpon"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-stumbleupon" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkedIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-linkedin" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-reddit" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest"  href='javascript:pinIt();' class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-pinterest" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pocket_share_enable') ) {
								$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
								?>

								<a title="Pocket"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-get-pocket" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Digg"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-digg" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								?>

								<a title="Delicious"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-delicious" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
								?>

								<a title="Odnoklassniki"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-6?>px !important"><i class=" <?php echo $selected_theme; ?> fa fa-odnoklassniki" style="padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-4; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						
						
						
							
						}
						
						else{
						

						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>

						<?php
						}
						
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/twitter.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img  style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color: <?php echo $selected_theme; ?>' src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						if( get_option('mo_openid_vkontakte_share_enable') ) {
							$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
						<a title="Vkontakte" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img  style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color: <?php echo $selected_theme; ?>' src="<?php echo plugins_url( 'includes/images/icons/vk.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
								?>

								<a title="Tumblr"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/tumblr.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="StumbleUpon"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/stumble.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkedIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/reddit.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest"  href='javascript:pinIt();' class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/pininterest.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_pocket_share_enable') ) {
								$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
								?>

								<a title="Pocket"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/pocket.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Digg"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/digg.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								?>

								<a title="Delicious"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/delicious.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
								?>

								<a title="Odnoklassniki"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-left : <?php echo $spaceBetweenIcons-4?>px !important"><img style= 'height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/odnoklassniki.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						
						
						
						}
							?></p></div><?php }?>


						
						
						
						
						
						
						
						
				<?php if( $orientation == 'ver' ) {?>

					<div>
					<?php
					
						if($custom_theme == 'custom'){
							

						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link" style="margin-bottom:<?php echo $space_icons?>px !important;"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-facebook" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>

						<?php
						}
						
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-twitter" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-bottom:<?php echo $space_icons?>px !important;"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-google-plus" style="margin-bottom:<?php echo $space_icons-4?>px!important; padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_vkontakte_share_enable') ) {
							$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
						<a title="Vkontakte" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" style="margin-bottom:<?php echo $space_icons?>px !important;"><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-vk" style="margin-bottom:<?php echo $space_icons-4?>px!important; padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
								?>

								<a title="Tumblr"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-tumblr" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="StumbleUpon"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-stumbleupon" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkedIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-linkedin" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-reddit" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest"  href='javascript:pinIt();' class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-pinterest" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:3px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-10); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pocket_share_enable') ) {
								$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
								?>

								<a title="Pocket"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-get-pocket" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Digg"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-digg" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								?>

								<a title="Delicious"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-delicious" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
								?>

								<a title="Odnoklassniki"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class="mo-custom-share-icon <?php echo $selected_theme; ?> fa fa-odnoklassniki" style="margin-bottom:<?php echo $space_icons-4?>px!important;padding-top:8px;text-align:center;color:#ffffff;font-size:<?php echo ($sharingSize-16); ?>px !important;background-color:#<?php echo $custom_color?>;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
							
						}
						
						else if($custom_theme == 'customFont'){
							

						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link"><i class=" <?php echo $selected_theme; ?> fa fa-facebook" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top : 4px !important;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>

						<?php
						}
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-twitter" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link"><i class=" <?php echo $selected_theme; ?> fa fa-google-plus" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
						if( get_option('mo_openid_vkontakte_share_enable') ) {
							$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
						<a title="Vkontakte" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link"><i class=" <?php echo $selected_theme; ?> fa fa-vk" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
								?>

								<a title="Tumblr" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-tumblr" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="StumbleUpon" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-stumbleupon" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkedIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-linkedin" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px !important;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-reddit" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest" href='javascript:pinIt();' class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-pinterest" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize-5; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_pocket_share_enable') ) {
							$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
								?>

								<a title="Pocket" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-get-pocket" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Digg" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-digg" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								?>

								<a title="Delicious" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-delicious" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
								?>

								<a title="Odnoklassniki" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><i class=" <?php echo $selected_theme; ?> fa fa-odnoklassniki" style="margin-bottom:<?php echo $space_icons-4?>px !important;padding-top:4px;text-align:center;color:#<?php echo $fontColor ?> !important;font-size:<?php echo $sharingSize; ?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important"></i></a>
						<?php
						}
						
												
						}
						
						
						else{
						

						if( get_option('mo_openid_facebook_share_enable') ) {
							$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
						?>
						

							<a title="Facebook" onclick="popupCenter('<?php echo $link; ?>', 800, 400);" class="mo-openid-share-link"><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color:white;' src="<?php echo plugins_url( 'includes/images/icons/facebook.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>

						<?php
						}
						
						if( get_option('mo_openid_twitter_share_enable') ) {
								$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
								?>

								<a title="Twitter" onclick="popupCenter('<?php echo $link; ?>', 600, 300);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color:white;' src="<?php echo plugins_url( 'includes/images/icons/twitter.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						if( get_option('mo_openid_google_share_enable') ) {
							$link = 'https://plus.google.com/share?url='.$url;
						?>
						<a title="Google" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link"><img  style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color: <?php echo $selected_theme; ?>' src="<?php echo plugins_url( 'includes/images/icons/google.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						if( get_option('mo_openid_vkontakte_share_enable') ) {
							$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
						?>
						<a title="Vkontakte" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link"><img  style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color: <?php echo $selected_theme; ?>' src="<?php echo plugins_url( 'includes/images/icons/vk.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_tumblr_share_enable') ) {
								$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
								?>

								<a title="Tumblr"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/tumblr.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_stumble_share_enable') ) {
								$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="StumbleUpon"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/stumble.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_linkedin_share_enable') ) {
								$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
								?>

								<a title="LinkedIn" onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;background-color:white;' src="<?php echo plugins_url( 'includes/images/icons/linkedin.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_reddit_share_enable') ) {
								$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Reddit"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/reddit.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_pinterest_share_enable') ) {
								
								?>

								<a title="Pinterest"  href='javascript:pinIt();' class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/pininterest.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_pocket_share_enable') ) {
								$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
								?>

								<a title="Pocket"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/pocket.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_digg_share_enable') ) {
								$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
								?>

								<a title="Digg"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/digg.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_delicious_share_enable') ) {
								$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
								?>

								<a title="Delicious"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/delicious.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						if( get_option('mo_openid_odnoklassniki_share_enable') ) {
								$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
								?>

								<a title="Odnoklassniki"  onclick="popupCenter('<?php echo $link; ?>', 800, 500);" class="mo-openid-share-link" ><img style= 'margin-bottom:<?php echo $space_icons-6?>px !important;height:<?php echo $sharingSize; ?>px !important;width:<?php echo $sharingSize; ?>px !important;' src="<?php echo plugins_url( 'includes/images/icons/odnoklassniki.png', __FILE__ )?>" class="mo-openid-app-share-icons <?php echo $selected_theme; ?>" ></a>
						<?php
						}
						
						
						
						
						}
							?></p></div>
						


						<?php }?>
							</div><br>
						<?php

	31

?>