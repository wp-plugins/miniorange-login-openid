<?php
/** miniOrange Connect For Joomla enables user to use "Login with miniOrange" using OpenId Connect protocol for Secure SSO and String authentication.
    Copyright (C) <year>  <name of author>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
* @package 		miniOrange Connect Extension (joomla 3.x)
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
/**
This library is miniOrange Authentication Service. 
Contains Request Calls to Token and Userinfo Endpoints
to the miniOrange OpenID Connect provider service.

**/
class AuthorizeOpenIDRequest{
	
	public $hostName;
	public $authCode;
	public $clientSecret;
	
	
	//This function send a token request and gains access token for the comming user info request.	
	function sendTokenRequest()
	{
	$ch = curl_init("https://" . $this->hostName . "/moas/rest/token/accesstoken");
	$fields = array(
			'code' => $this->authCode,
			'grant_type' => 'Bearer'
		       );
		       
	$field_string = http_build_query($fields);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt( $ch, CURLOPT_ENCODING, "" );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
	
	curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Authorization: Basic ' . $this->clientSecret
	    ));
	curl_setopt( $ch, CURLOPT_POST, true);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, "code=" . $this->authCode . "&grant_type=Bearer");
	$content = curl_exec($ch);

	if(curl_errno($ch)){
	    echo 'Request Error:' . curl_error($ch);
	   exit();
	}
	

	curl_close($ch);

	return $content;
	}
	
	
	//This endpoint request the userinfo with the help of access_token granted from tokenEndpoint.
	function sendUserInfoRequest($access_tkn)
	{
	
	$ch = curl_init("https://" . $this->hostName . "/moas/rest/protected/userinfo");

	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt( $ch, CURLOPT_ENCODING, "" );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Authorization: Bearer ' . $access_tkn
	    ));
	
	$content = curl_exec($ch);

	if(curl_errno($ch))
		{
		    echo 'error:' . curl_error($ch);
		    exit();
		}
	
	curl_close($ch);
	
	return $content;
	}
	
	
}
?>