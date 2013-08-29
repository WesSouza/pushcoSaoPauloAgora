<?php

require 'bootstrap.php';

$woodpecker = new Woodpecker( $__config[ $argv[2] ] );
$woodpecker->run( $argv[1] );