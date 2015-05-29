=== miniOrange OpenID Connect Login Widget ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: miniOrange, mo, login form, miniorange login, miniorange widget, miniorange login widget, mo widget login, mo sidebar login, miniorange login form, mo user login, miniorange authentication, twitter, twitter login, social login, google, google login, sidebar login, widget login, wordpress login, widget, shortcode, shortcode login, login widget, social login, facebook register, social user registration, user registration
Requires at least: 2.0.2
Tested up to: 4.2.1
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a miniOrange login plugin as widget.

== Description ==

This is a miniOrange login plugin as widget. A miniOrange application needs to be created to setup this plugin. The setup is simple. Instructions are provided below.

= Important =

You need to create a new miniOrange OpenID Application to setup this plugin. Please follow the instructions provided below.
			
* <strong>1.</strong> Go to <a href="https://auth.miniorange.com/moas/login target="_blank">miniOrange Admin Console</a>
* <strong>2.</strong> Click on "Apps" menu. Then click on Configure Apps button.
* <strong>3.</strong> From applications Select "OpenID Application".
* <strong>4.</strong> Enter your wordpress application name, description. And in the redirect URL add : "your-wordpress-site-url/?option=mologin". 
* <strong>5.</strong> Click save. Go to Edit Application and Note Client ID and Client Secret.
* <strong>6.</strong> Now in the Wordpress admin go to Settings > MO Login Widget. Copy-paste the Client Id and Client Secret here. That's All. Have fun :)

For more details - Refer: http://miniorange.com

== Installation ==


1. Upload `miniorange-login-openid.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to `Settings-> MO Login Widget`, and follow the instructions.
4. Go to `Appearance->Widgets` ,in available widgets you will find `miniOrange Login Widget` widget, drag it to chosen widget area where you want it to appear.
5. Now visit your site and you will see the login form section.

== Frequently Asked Questions ==

= For any kind of problem =

1. Please contact us at http://miniorange.com

== Screenshots ==

1. front end widget view
2. settings page view

== Changelog ==

= 1.0.0 =
* this is the first release.

== Upgrade Notice ==

= 1.0 =
I will update this plugin when ever it is required.
