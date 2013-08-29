<?php

class Traffic
{
	private $mode;
	
	public function __construct ( $mode )
	{
		$this->mode = $mode;
	}
	
	private function apiCall ( $url, array $postData = array() )
	{
		$result = CURL::run( $url, $postData );
		
		if ( !$result )
			throw new Exception( 'Invalid result.' );
		
		$result = @json_decode( $result );
		
		if ( !$result )
			throw new Exception( 'Invalid JSON.' );
		
		return $result;
	}
	
	public function getStreets ( $apiUrl )
	{
		$return = array();
		switch ( $this->mode )
		{
			case 'radar-g1':
				$data = $this->apiCall( $apiUrl );
				$congestedLevels = array();
				foreach ( $data as $i => $street )
					$congestedLevels[ $i ] = $street->lvCongested;
				array_multisort( $congestedLevels, SORT_DESC, SORT_NUMERIC, $data );
				
				foreach ( $data as $street )
					if ( $street->lvCongested >= 3 )
						$return[] = (object) array
						(
							'name' => $street->name,
							'latitude' => $street->py,
							'longitude' => $street->px,
						);
				
				break;
		}
		return $return;
	}
}