# São Paulo Agora

São Paulo Agora is an application that gathers relevant information from São Paulo's area and
pushes them to Push.co on a timed basis, so users always get the latest information as they need
them.

Currently it supports:

* Morning feed with today's forecast
* Important news from the city and its surroundings
* Traffic alerts on peak hours


## Configuration

`bootstrap.php` file has a $__config variable that needs to have the Push.co API keys properly
configured.


## Usage

São Paulo Agora relies on PHP to work, and each channel has its own cli command:

`php run.php [command] sao-paulo`

In this, `[command]` is either `weather`, `news` or `traffic`. When called, the most relevant data is
retrieved from the other services' APIs and pushed to their respective channel.

Also, `sao-paulo` exists because the app has the ability to be configured for a different city, but
this requires more implementation code.


## Author

Visit http://wex.vc for meeting who did this.
