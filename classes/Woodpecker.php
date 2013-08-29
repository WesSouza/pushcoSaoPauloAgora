<?php

class Woodpecker
{
	private $config;
	private $push;
	
	public function __construct ( $config )
	{
		$this->config = $config;
		$this->push = new Push( $config['push']['apiKey'], $config['push']['apiSecret'] );
	}
	
	public function run ( $channel )
	{
		switch ( $channel )
		{
			case 'morning':
				$weather = new Weather( $this->config['weather']['cityId'], $this->config['temperatureUnit'] );
				$forecast = $weather->getForecastForTomorrow();
				if ( $forecast->weather == 'sky is clear' )
					$forecast->weather = 'a clear sky';
				$message = "Good morning, today there will be ". $forecast->weather .".";
				$article = "The minimum temperature is ". $forecast->minimum .", the maximum is ". $forecast->maximum .". At night it will be ". $forecast->night .".";
				
				$this->push->sendArticle( $message, $article, $forecast->image );
				break;
			
			case 'news':
				$rss = new RSS();
				$items = $rss->parse( $this->config['news']['feedUrl'] );
				if ( empty( $items ) )
					break;
				$message = $items[0]->title;
				$url = $items[0]->link;
				
				$this->push->sendUrl( $message, $url );
				break;
			
			case 'traffic':
				$traffic = new Traffic( $this->config['traffic']['mode'] );
				$streets = $traffic->getStreets( $this->config['traffic']['apiUrl'] );
				if ( empty( $streets ) )
					break;
				$message = 'Heavy traffic on '. $streets[0]->name;
				$latitude = $streets[0]->latitude;
				$longitude = $streets[0]->longitude;
				
				$this->push->sendMap( $message, $latitude, $longitude );
				break;
		}
	}
}