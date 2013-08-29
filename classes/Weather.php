<?php

class Weather
{
	private $cityId;
	private $unit = 'C';
	
	public function __construct ( $cityId, $unit = 'C' )
	{
		$this->cityId = $cityId;
		$this->unit = $unit;
	}
	
	private function apiCall ( $uri, array $postData = array() )
	{
		$result = CURL::run( 'http://api.openweathermap.org/data/2.5/'. $uri, $postData );
		
		if ( !$result )
			throw new Exception( 'Invalid result.' );
		
		$result = @json_decode( $result );
		
		if ( !$result )
			throw new Exception( 'Invalid JSON.' );
		
		if ( $result->cod != "200" )
			throw new Exception( 'API error.' );
		
		return $result;
	}
	
	private function convertTemperature ( $temperature )
	{
		switch ( $this->unit )
		{
			case 'C':
				return number_format( $temperature - 273.15, 1, ',', '' ) .' C';
			
			case 'F':
				return number_format( ($temperature - 273.15) * 9 / 5 + 32, 1, '.', '' ) .' F';
		}
		return $temperature;
	}
	
	public function getForecastForTomorrow ( )
	{
		$result = $this->apiCall( 'forecast/daily?id='. rawurlencode( $this->cityId ) );
		if ( !empty( $result->list ) )
		{
			return (object) array
			(
				'image' => 'http://push.wex.vc/assets/images/weather_'. ( strpos( $result->list[0]->weather[0]->description, 'rain' ) !== false || strpos( $result->list[0]->weather[0]->description, 'thunder' ) !== false ? 'rain' : 'clear' ) .'.jpg',
				'weather' => $result->list[0]->weather[0]->description,
				'minimum' => $this->convertTemperature( $result->list[0]->temp->min ),
				'maximum' => $this->convertTemperature( $result->list[0]->temp->max ),
				'night' => $this->convertTemperature( $result->list[0]->temp->night ),
			);
		}
		else
			throw new Exception( "No forecast found." );
			
	}
}