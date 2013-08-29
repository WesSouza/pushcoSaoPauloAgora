<?php

class RSS
{
	public function parse ( $url )
	{
		$result = CURL::run( $url );
		
		if ( !$result )
			throw new Exception( 'Invalid result.' );
		
		$result = new SimpleXMLElement( $result );
		
		if ( !$result || empty( $result->channel ) )
			throw new Exception( 'Invalid XML format.' );
		
		$items = array();
		foreach ( $result->channel->item as $item )
			$items[] = $item;
		return $items;
	}
}