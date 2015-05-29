=== miniOrange OpenID Connect SSO Login Widget ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: miniOrange, mo, login form, miniorange login, miniorange widget, miniorange login widget, mo widget login, mo sidebar login, miniorange login form, mo user login, miniorange authentication, twitter, twitter login, social login, google, google login, sidebar login, widget login, wordpress login, widget, shortcode, shortcode login, login widget, social login, miniorange register, social user registration, user registration
Requires at least: 2.0.2
Tested up to: 4.2.1
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a miniOrange login plugin as widget.

== Description ==

This is a miniOrange login plugin as widget for secure login and Single Sign On (SSO) using OpenId Connect protocol. A miniOrange application needs to be created to setup this plugin. The setup is simple. Instructions are provided below.

= Important =

You need to create a new miniOrange OpenID Application to setup this plugin. Please follow the instructions provided below.
			
* <strong>1.</strong> Go to https://auth.miniorange.com/moas/login miniOrange Admin Console.
* <strong>2.</strong> Click on "Apps" menu. Then click on Configure Apps button.
* <strong>3.</strong> From applications Select "OpenID Application".
* <strong>4.</strong> Enter your wordpress application name, description. And in the redirect URL add : "your-wordpress-site-url/?option=mologin". 
* <strong>5.</strong> Click save. Go to Edit Application and Note Client ID and Client Secret.
* <strong>6.</strong> Now in the Wordpress admin go to Settings > MO Login Widget. Copy-paste the Client Id and Client Secret here.
* <strong>7.</strong> Go to Appearances> Widgets and add "miniOrange Login Widget" at desired location. That's All. Have fun :)

Features :-

Single Sign On
miniOrange Single Sign On (SSO) Solution provides easy and seamless access to all enterprise resources with one set of credentials. miniOrange provides Single Sign On (SSO) to any type of devices or applications whether they are in the cloud or on-premise.

Strong Authentication
Secure your Wordpress site from password thefts using multi factor authentication methods with 15+ authentication types provided by miniOrange. Our multi factor authentication methods prevent unauthorized users from accessing information and resources having password alone as authentication factor. Enabling second factor authentication for wordpress protects you against password thefts.

Fraud Prevention
miniOrange prevents frauds with its dynamic risk engine in conjunction with enterprise specific security policy. We support a combination of the Device Id, Location and Time of access as multi-factor authentication that can detect and block fraud in real-time, without any interaction with the user.

Why should you pick our Wordpress plugin over other plugins that are available?

1) The most extensive range of 2 factor authentication methods
2) A single sign on service for 3000+ apps (whether they are standards based or not), besides Wordpress, like Google apps, Salesforce etc.
3) A fraud prevention service that lets you define trusted devices, location, time of access and other parameters that are extensive
4) All the above bundled together and available instantly to you as a cloud service
5) REST APIs that can be called from anywhere anytime
6) Secure login APIs using standards such as SAML and OpenID Connect
7) APIs for Single Sign on, 2 Factor Authentication and Fraud Prevention for Any App
8) Plugin based login for non standard apps
9) Admin dashboard to manage your account
10) Self service dashboard for letting end users manage their profiles
11) Customization for look and feel and functionality

open source single sign on for Wordpress
sso saml, sso integration Wordpress, sso openid connect
two step verification Wordpress
2-step verification Wordpress
2 step verification
two factor authentication Wordpress
strong authentication Wordpress
mobile authentication Wordpress

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
