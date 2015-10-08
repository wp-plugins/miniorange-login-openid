<?php

//shortcode for horizontal sharing
function mo_openid_share_shortcode( $atts = '', $title = '', $excerpt = '' ) {	
	$url =  get_permalink();
	if(!$url) {
		$url = get_site_url();
	}

	$html = '';
	$selected_theme = isset( $atts['shape'] )? $atts['shape'] : get_option('mo_openid_share_theme');
	$selected_direction = get_option('mo_openid_share_widget_customize_direction');
	$sharingSize = isset( $atts['size'] )? $atts['size'] : get_option('mo_sharing_icon_custom_size');
	$custom_color = isset( $atts['backgroundcolor'] )? $atts['backgroundcolor'] : get_option('mo_sharing_icon_custom_color');
	$custom_theme = isset( $atts['theme'] )? $atts['theme'] : get_option('mo_openid_share_custom_theme');
	$fontColor = isset( $atts['fontcolor'] )? $atts['fontcolor'] : get_option('mo_sharing_icon_custom_font');
	$spaceBetweenIcons = isset( $atts['space'] )? $atts['space'] : get_option('mo_sharing_icon_space');
	$twitter_username = get_option('mo_openid_share_twitter_username');
	
	
	
	if($custom_theme == 'custombackground'){
		$custom_theme = 'custom';
	}
	if($custom_theme == 'nobackground'){
		$custom_theme = 'customFont';
	}
	
	$orientation = 'hor';
	/*if($landscape) {
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
	}*/
	
	$html .= '<a href="http://miniorange.com/single-sign-on-sso" hidden></a>';
	$html .= '<div class="mo-openid-app-icons circle ">';
	$html .= '<p>';
	if( $orientation == 'hor' ) {
		$html .=  get_option('mo_openid_share_widget_customize_text');
		$html .= "<div class='horizontal'>";
		if($custom_theme == 'custom'){
			

			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .= "<a title='Facebook' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-facebook' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .= "<a title='Twitter' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-twitter' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
				$link = 'https://plus.google.com/share?url='.$url;
				$html .= "<a title='Google' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-google-plus' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .= "<a title='Vkontakte' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-vk' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Tumblr' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-tumblr' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='StumbleUpon' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-stumbleupon' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
					$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
					

					$html .= "<a title='LinkedIn' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-linkedin' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			
			}
			
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Reddit' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-reddit' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_pinterest_share_enable') ) {
				$html .= "<a title='Pinterest' href='javascript:pinIt();' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-pinterest' style='padding-top:3px;text-align:center;color:#ffffff;font-size:" .($sharingSize-10). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
		
			}
						
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Pocket' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-get-pocket' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Digg' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-digg' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .= "<a title='Delicious' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-delicious' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .= "<a title='Odnoklassniki' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-4) . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-odnoklassniki' style='padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
		}
						
		else if($custom_theme == 'customFont') {
			
			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .= "<a title='Facebook' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-facebook' style='padding-top:4px;text-align:center;color:#" . $fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .= "<a title='Twitter' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-twitter' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
						
				$link = 'https://plus.google.com/share?url='.$url;
				$html .= "<a title='Google' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class='fa fa-google-plus' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .= "<a title='Vkontakte' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-vk' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Tumblr' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-tumblr' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='StumbleUpon' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-stumbleupon' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
				$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
				$html .= "<a title='LinkedIn' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-linkedin' style='padding-top:4px;text-align:center;color:#" . $fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Reddit' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-reddit' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}			
			if( get_option('mo_openid_pinterest_share_enable') ) {	
				$html .= "<a title='Pinterest' href='javascript:pinIt();' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-pinterest' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Pocket' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-get-pocket' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Digg' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-digg' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .= "<a title='Delicious' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-delicious' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .= "<a title='Odnoklassniki' onclick='popupCenter(". '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " .($spaceBetweenIcons-6) . "px !important'><i class=' " .$selected_theme. " fa fa-odnoklassniki' style='padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			
							
		}
						
		else {

			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .= "<a title='Facebook' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 400);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/facebook.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .= "<a title='Twitter' onclick='popupCenter(" . '"' . $link . '"' . ", 600, 300);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/twitter.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
				$link = 'https://plus.google.com/share?url='.$url;
				$html .=	"<a title='Google' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;background-color: " . $selected_theme . "' src='" . plugins_url( 'includes/images/icons/google.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .= "<a title='Vkontakte' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/vk.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Tumblr' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/tumblr.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='StumbleUpon' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/stumble.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
				$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
				$html .= "<a title='LinkedIn' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/linkedin.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Reddit' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/reddit.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
				
			if( get_option('mo_openid_pinterest_share_enable') ) {
				$html .= "<a title='Pinterest'  href='javascript:pinIt();' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" .  plugins_url( 'includes/images/icons/pininterest.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
					
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Pocket' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/pocket.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Digg' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/digg.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .= "<a title='Delicious' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/delicious.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .= "<a title='Odnoklassniki' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-left : " . ($spaceBetweenIcons-4) . "px !important'><img style= 'height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='"  . plugins_url( 'includes/images/icons/odnoklassniki.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			
			
		}
		$html .= "</div>";
	}

	
							
		$html .= "</p></div><br/>";


 							

	$html .= '<script>';
	
	$html .= 'function popupCenter(pageURL, w,h) {';
	$html .= 'var left = (screen.width/2)-(w/2);';
	$html .= 'var top = (screen.height/2)-(h/2);';
	$html .= "var targetWin = window.open (pageURL, '_blank','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);}";
	
	$html .= 'function pinIt(){';
    $html .= 'var e = document.createElement("script");';
    $html .= "e.setAttribute('type','text/javascript');";
    $html .= "e.setAttribute('charset','UTF-8');";
    $html .= "e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);
	document.body.appendChild(e);}";
	$html .= '</script>';
	
	return $html;
}

function mo_openid_vertical_share_shortcode( $atts = '', $title = '', $excerpt = '' ) {
	//$url = get_site_url();
	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$html = '';
	$selected_theme = isset( $atts['shape'] )? $atts['shape'] : get_option('mo_openid_share_theme');
	$selected_direction = get_option('mo_openid_share_widget_customize_direction');
	$sharingSize = isset( $atts['size'] )? $atts['size'] : get_option('mo_sharing_icon_custom_size');
	$custom_color = isset( $atts['backgroundcolor'] )? $atts['backgroundcolor'] : get_option('mo_sharing_icon_custom_color');
	$custom_theme = isset( $atts['theme'] )? $atts['theme'] : get_option('mo_openid_share_custom_theme');
	$fontColor = isset( $atts['fontcolor'] )? $atts['fontcolor'] : get_option('mo_sharing_icon_custom_font');
	$spaceBetweenIcons = isset( $atts['space'] )? $atts['space'] : '10';
	
	$alignment =  isset( $atts['alignment'] )? $atts['alignment'] : 'left';
	$left_offset = isset( $atts['leftoffset'] )? $atts['leftoffset'] : '20';
	$right_offset = isset( $atts['rightoffset'] )? $atts['rightoffset'] : '10'; 
	$top_offset = isset( $atts['topoffset'] )? $atts['topoffset'] : '100';
	
	
	$twitter_username = get_option('mo_openid_share_twitter_username');
	
	if($custom_theme == 'custombackground'){
		$custom_theme = 'custom';
	}
	if($custom_theme == 'nobackground'){
		$custom_theme = 'customFont';
	}
	
	//$orientation = 'ver';
	
	$html .= "<div class='mo_openid_vertical' style='" .(isset($alignment) && $alignment != ''  ? $alignment .': '. (${$alignment.'_offset'} == '' ? 0 :  ${$alignment.'_offset'} ) .'px;' : '').(isset($top_offset) ? 'top: '. ( $top_offset == '' ? 0 : $top_offset ) .'px;' : '') ."'>";
	
	
	
	$html .= '<a href="http://miniorange.com/single-sign-on-sso" hidden></a>';
	$html .= '<div class="mo-openid-app-icons circle ">';
	$html .= '<p>';
	//if( $orientation == 'ver' ) {
		
		$html .= "<div>";
		if($custom_theme == 'custom'){
			
			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .= "<a title='Facebook' onclick='popupCenter(" . '"' . $link . '"' .", 1000, 500);' class='mo-openid-share-link' style='margin-bottom : " .$spaceBetweenIcons . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-facebook' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .= "<a title='Twitter' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-twitter' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
				$link = "https://plus.google.com/share?url=".$url;
				$html .= "<a title='Google' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' style='margin-bottom : " .$spaceBetweenIcons . "px !important'><i class='mo-custom-share-icon " .$selected_theme. " fa fa-google-plus' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
				
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .= "<a title='Vkontakte' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-vk' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Tumblr' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-tumblr' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='StumbleUpon' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-stumbleupon' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
					$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
					

					$html .= "<a title='LinkedIn' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-linkedin' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			
			}
				
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Reddit' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-reddit' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_pinterest_share_enable') ) {
				$html .= "<a title='Pinterest' href='javascript:pinIt();' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-pinterest' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:3px;text-align:center;color:#ffffff;font-size:" .($sharingSize-10). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
		
			}
			
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Pocket' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-get-pocket' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Digg' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-digg' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .= "<a title='Delicious' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-delicious' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .= "<a title='Odnoklassniki' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='mo-custom-share-icon " .$selected_theme. " fa fa-odnoklassniki' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:8px;text-align:center;color:#ffffff;font-size:" .($sharingSize-16). "px !important;background-color:#" .$custom_color. ";height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			
							
		}
						
		else if($custom_theme == 'customFont') {
			
			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .= "<a title='Facebook' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-facebook' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .= "<a title='Twitter' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-twitter' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
						
				$link = 'https://plus.google.com/share?url='.$url;
				$html .= "<a title='Google' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link'><i class='fa fa-google-plus' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .= "<a title='Vkontakte' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-vk' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Tumblr' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-tumblr' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='StumbleUpon' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-stumbleupon' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
				$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
				$html .= "<a title='LinkedIn' onclick='popupCenter(". '"' . $link . '"' .", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-linkedin' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Reddit' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-reddit' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}			
			if( get_option('mo_openid_pinterest_share_enable') ) {	
				$html .= "<a title='Pinterest' href='javascript:pinIt();' class='mo-openid-share-link' ><i class='fa fa-pinterest' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .($sharingSize-5). "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
				}
						
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Pocket' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-get-pocket' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .= "<a title='Digg' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-digg' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .= "<a title='Delicious' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-delicious' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .= "<a title='Odnoklassniki' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link' ><i class='fa fa-odnoklassniki' style='margin-bottom : " . ($spaceBetweenIcons-4) . "px !important;padding-top:4px;text-align:center;color:#" .$fontColor . ";font-size:" .$sharingSize. "px !important;height:" .$sharingSize. "px !important;width:" .$sharingSize. "px !important;'></i></a>";
			}
			
			
							
		}
						
		else {
			
			if( get_option('mo_openid_facebook_share_enable') ) {
				$link = 'https://www.facebook.com/dialog/share?app_id=766555246789034&amp;display=popup&amp;href='.$url.'&amp;redirect_uri=http%3A%2F%2Fminiorange.com%2Fsocial_share_redirect';
				$html .=	"<a title='Facebook' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/facebook.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			if( get_option('mo_openid_twitter_share_enable') ) {
				$link = empty($twitter_username) ? 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url : 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url. '&amp;via='.$twitter_username;
				$html .=	"<a title='Twitter' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/twitter.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			if( get_option('mo_openid_google_share_enable') ) {
				$link = 'https://plus.google.com/share?url='.$url;
				
				$html .=	"<a title='Google' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/google.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_vkontakte_share_enable') ) {
				$link = 'http://vk.com/share.php?url='.$url.'&amp;title='.$title.'&amp;description='.$excerpt;
				$html .=	"<a title='Vkontakte' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/vk.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_tumblr_share_enable') ) {
				$link = 'http://www.tumblr.com/share/link?url='.$url.'&amp;title='.$title;
				$html .=	"<a title='Tumblr' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/tumblr.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_stumble_share_enable') ) {
				$link = 'http://www.stumbleupon.com/submit?url='.$url.'&amp;title='.$title;
				$html .=	"<a title='StumbleUpon' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/stumble.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_linkedin_share_enable') ) {
				$link = 'https://www.linkedin.com/shareArticle?mini=true&amp;title='.$title.'&amp;url='.$url.'&amp;summary='.$excerpt;
				$html .=	"<a title='LinkedIn' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/linkedin.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_reddit_share_enable') ) {
				$link = 'http://www.reddit.com/submit?url='.$url.'&amp;title='.$title;
				$html .=	"<a title='Reddit' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/reddit.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}		
			if( get_option('mo_openid_pinterest_share_enable') ) {
				$html .=	"<a title='Pinterest' href='javascript:pinIt();' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/pininterest.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_pocket_share_enable') ) {
				$link = 'https://getpocket.com/save?url='.$url.'&amp;title='.$title;
				$html .=	"<a title='Pocket' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/pocket.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_digg_share_enable') ) {
				$link = 'http://digg.com/submit?url='.$url.'&amp;title='.$title;
				$html .=	"<a title='Digg' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/digg.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_delicious_share_enable') ) {
				$link = 'http://www.delicious.com/save?v=5&noui&jump=close&url='.$url.'&amp;title='.$title;
				$html .=	"<a title='Delicious' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/delicious.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			if( get_option('mo_openid_odnoklassniki_share_enable') ) {
				$link = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments='.$excerpt.'&amp;st._surl='.$url;
				$html .=	"<a title='Odnoklassniki' onclick='popupCenter(" . '"' . $link . '"' . ", 800, 500);' class='mo-openid-share-link'><img style= 'margin-bottom : " . ($spaceBetweenIcons-6) . "px !important;height: " . $sharingSize . "px !important;width: " . $sharingSize . "px !important;' src='" . plugins_url( 'includes/images/icons/odnoklassniki.png', __FILE__ ) . "' class='mo-openid-app-share-icons " . $selected_theme . "' ></a>";
			}
			
			
		}
		$html .= "</div>";
	//}

	
							
		$html .= "</p></div></div>";


 							

	$html .= '<script>';
	
	$html .= 'function popupCenter(pageURL, w,h) {';
	$html .= 'var left = (screen.width/2)-(w/2);';
	$html .= 'var top = (screen.height/2)-(h/2);';
	$html .= "var targetWin = window.open (pageURL, '_blank','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);}";
	
	$html .= 'function pinIt(){';
    $html .= 'var e = document.createElement("script");';
    $html .= "e.setAttribute('type','text/javascript');";
    $html .= "e.setAttribute('charset','UTF-8');";
    $html .= "e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);";
	$html .= "document.body.appendChild(e);}";
	$html .= '</script>';
	
	return $html;
}
?>