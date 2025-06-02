<?php

require_once 'controllers/_config.php';

$oLog = new \Thepozer\Log\SimpleLog(fopen('logs/application-' . date('Y-m-d') . '.log', 'a+'), \Thepozer\Log\SimpleLog::ERROR);

if ($bDevMode) {
  $oLog->setLogLevel(\Thepozer\Log\SimpleLog::DEBUG);
}

/**
 * Inclusion du fichier utilitaire
 */
require_once 'controllers/_utils.php';
