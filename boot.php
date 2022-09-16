<?php

defined('DS') or exit('No direct script access.');

System\Autoloader::map([
    'Esyede\Impersonate' => __DIR__.DS.'libraries'.DS.'impersonate.php',
]);
