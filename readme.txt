=== Single Sign on between Wordpress sites ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: single sign-on, sso, sso integration WordPress, Single Sign on wordpress,SSO wordpress,sso openid connect, sso saml, open source single sign on for WordPress, single sign on openid connect, single sign on saml, sso openid, single sign on openid
Requires at least: 2.0.2
Tested up to: 4.2.1
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple and secure single sign on into your WordPress sites using miniOrange(uses OpenID Connect).

== Description ==

miniOrange allows users to single sign on (sso) into your WordPress site using miniOrange Identity provider. This means, you can login to your WordPress site by simply clicking a "Log in with miniOrange" button without having the necessity to provide a username or password!

This plugin also allows Single Sign On between two wordpress sites that you own.

When can this plugin be used?

*	Use this for Single Sign On from one Wordpress site to another site. That is if the user is logged in to one Wordpress site for example, they can simply click their way through one login button to login to another Wordpress site with the same user.
*	Both Wordpress site share the same secret key. Use this as a simple and secure login from one site to another.
*	The user must exist on both the Wordpress site. Also, this plugin must be installed on both the Wordpress site, where you want the login to be shared.


If you require any other application or need any help with installing this plugin, please free to email us at <b>info@miniorange.com</b> or <a href="http://miniorange.com/contact">Contact us</a>.

= Features :- =

*	SSO into your WordPress site using miniOrange.
*	Single Sign On between two Wordpress sites.
*	Valid user registrations verified by miniOrange.
*	Easily integrate the login link with your Wordpress website using widgets. Just drop it in a desirable place in your website.
*	Automatic user registration after login if the user is not already registered with your site if single sign on using miniOrange.

== Installation ==

= Setting up miniOrange OpenID =
1. Go to <a href="https://auth.miniorange.com/moas/login" target="_blank">miniOrange login</a> . Register a new account by clicking on `Sign up for a Free Trial`.
2. Go back to <a href="https://auth.miniorange.com/moas/login" target="_blank">miniOrange login</a> and login with your credentials.
3. Go to `Users/Groups-> Manage Users/Groups-> Add User` and add users.
4. Go to `Apps`. Then click on `Configure Apps` button.
5. Go to `OpenID`. Select `OpenId Connect` and click on `Add App`.
6. Enter your WordPress application name in `Client Name`. And in the `Redirect URL` add : `<your-WordPress-site-url>/?option=mologin`. Optionally add `Description`.
7. Click save. Go to `Edit` link beside Application Name. Note the `Client ID` and `Client Secret`.
8. Go to `Policies-> App Authentication Policy-> Add Policy`. 
9. Select your application name from the dropdown list. Select the group of your users, add a policy name and select your authentication type.

= Plugin installation =
1. Upload `miniorange-login-openid.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. Go to `Settings-> MO Login Widget`, and follow the instructions. Copy-paste the `Client Id` and `Client Secret` here.
4. Go to `Appearance->Widgets` ,in available widgets you will find `miniOrange Login Widget`, drag it to chosen widget area where you want it to appear.
5. Now logout and go to your site. You will see a login link where you placed that widget. That's All. Have fun :)

== Frequently Asked Questions ==

= For any kind of problem =

Please email us at info@miniorange.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>.

== Screenshots ==

1. Add OpenID in miniOrange
2. miniOrange option in Settings
3. Settings for miniOrange Login Widget
4. Adding miniOrange Login Widget to website

== Changelog ==

= 1.0.0 =
* this is the first release.

== Upgrade Notice ==

= 1.0 =
I will update this plugin when ever it is required.
