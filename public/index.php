<?php
define('APP_DIR', dirname( dirname(__FILE__)));

chdir(APP_DIR);

require 'vendor/autoload.php';

require 'controllers/_all.php';
