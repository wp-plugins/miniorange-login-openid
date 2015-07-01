=== miniOrange OpenID Connect SSO Login Widget ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: login form, login, widget, login widget, widget login, sidebar login, login form, user login, authentication, social login , sidebar login, widget login, WordPress login, widget, shortcode, shortcode login, login widget, social login, miniorange register, social user registration, user registration, open source single sign on for WordPress, single sign on, SSO, single sign on openid, single sign on saml, openid sso, openid connect, openid connect sso, sso saml, sso integration WordPress, sso openid connect, two step verification WordPress, 2-step verification WordPress, 2 step verification, two factor authentication WordPress, strong authentication WordPress, mobile authentication WordPress, OAuth 2.0 login
Requires at least: 2.0.2
Tested up to: 4.2.1
Stable tag: 2.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple and secure login for Wordpress through our miniOrange Provider(uses OpenID Connect).

== Description ==

miniOrange allows users to login to your Wordpress website using miniOrange Identity provider to securely Authenticate their account. This means, If you are logged in to miniOrange, you can login to your WordPress site by simply clicking a "Log in with miniOrange" button without having the necessity to provide a username or password!

If you require any other application or need any help with installing this plugin, please free to email us at info@miniorange.com or <a href="http://miniorange.com/contact">Contact us</a>.

= Features :- =

*	Login to your Wordpress site using miniOrange.
*	Valid user registrations verified by miniOrange.
*	Easily integrate the login link with your Wordpress website using widgets. Just drop it in a desirable place in your website.
*	Automatic user registration after login if the user is not already registered with your site.

= miniOrange specific features =

*  Single Sign On : miniOrange Single Sign On (SSO) Solution provides easy and seamless access to all enterprise resources with one set of credentials. miniOrange provides Single Sign On (SSO) to any type of devices or applications whether they are in the cloud or on-premise.

*  Strong Authentication : Secure your WordPress site from password thefts using multi factor authentication methods with 15+ authentication types provided by miniOrange. Our multi factor authentication methods prevent unauthorized users from accessing information and resources having password alone as authentication factor. Enabling second factor authentication for WordPress protects you against password thefts.

*  Fraud Prevention : miniOrange prevents frauds with its dynamic risk engine in conjunction with enterprise specific security policy. We support a combination of the Device ID, Location and Time of access as multi-factor authentication that can detect and block fraud in real-time, without any interaction with the user.

= Why should you pick our WordPress plugin over other plugins that are available? =

1. The most extensive range of 2 factor authentication methods
2. A single sign on service for 3000+ apps (whether they are standards based or not), besides WordPress, like Google apps, Salesforce etc.
3. A fraud prevention service that lets you define trusted devices, location, time of access and other parameters that are extensive
4. All the above bundled together and available instantly to you as a cloud service
5. REST APIs that can be called from anywhere anytime
6. Secure login APIs using standards such as SAML and OpenID Connect
7. APIs for Single Sign on, 2 Factor Authentication and Fraud Prevention for Any App
8. Plugin based login for non standard apps
9. Admin dashboard to manage your account
10. Self service dashboard for letting end users manage their profiles
11. Customization for look and feel and functionality

For more details - Refer: http://miniorange.com

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
