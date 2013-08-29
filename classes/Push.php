<?php

class Push
{
	private $apiKey;
	private $apiSecret;
	private $channel = false;
	
	public function __construct ( $apiKey, $apiSecret )
	{
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
	}
	
	private function apiCall ( $url, array $postData = array() )
	{
		$postData['api_key'] = $this->apiKey;
		$postData['api_secret'] = $this->apiSecret;
		$result = CURL::run( 'http://api.push.co/1.0/'. $url, $postData );
		
		if ( !$result )
			throw new Exception( 'Invalid result.' );
		
		$result = @json_decode( $result );
		
		if ( !$result )
			throw new Exception( 'Invalid JSON.' );
		
		if ( !$result->success )
			throw new Exception( 'API error: '. $result->error .'.' );
		
		return $result;
	}
	
	public function setChannel ( $channel )
	{
		$this->channel = $channel;
	}
	
	private function send ( $arguments )
	{
		if ( $this->channel !== false )
			$arguments['notification_type'] = $this->channel;
		$this->apiCall( 'push', $arguments );
	}
	
	public function sendMessage ( $message )
	{
		$arguments = array();
		$arguments['message'] = $message;
		$arguments['view_type'] = 0;
		
		$this->send( $arguments );
	}
	
	public function sendArticle ( $message, $article = '', $imageUrl = '' )
	{
		$arguments = array();
		$arguments['message'] = $message;
		$arguments['view_type'] = 0;
		$arguments['article'] = $article;
		$arguments['image'] = $imageUrl;
		
		$this->send( $arguments );
	}
	
	public function sendUrl ( $message, $url )
	{
		$arguments = array();
		$arguments['message'] = $message;
		$arguments['view_type'] = 1;
		$arguments['url'] = $url;
		
		$this->send( $arguments );
	}
	
	public function sendMap ( $message, $latitude, $longitude )
	{
		$arguments = array();
		$arguments['message'] = $message;
		$arguments['view_type'] = 2;
		$arguments['latitude'] = $latitude;
		$arguments['longitude'] = $longitude;
		
		print_r( $arguments );
		
		$this->send( $arguments );
	}
}