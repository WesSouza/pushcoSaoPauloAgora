<?php

class CURL
{
	static function run ( $url, $postData = false, $putData = false, $customHeaders = false )
	{
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		if ( $postData )
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
		if ( $putData )
		{
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $putData );
		}
		if ( $customHeaders )
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $customHeaders );
		return curl_exec( $ch );
	}
}