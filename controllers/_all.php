<?php

/**
 * Fichier d'initialisation de l'objet Global Slim
 */

session_start();

require_once 'controllers/_config.php';

if ($arGlblSqlAccess) {
	ORM::configure($arGlblSqlAccess['sql_url']);
	ORM::configure('username', $arGlblSqlAccess['username']);
	ORM::configure('password', $arGlblSqlAccess['password']);
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$sFilePart = date('Y-m-d');
use \Tools\Log\LogDateWriter as LogDateWriter;
$oLog = new LogDateWriter(fopen('logs/application-' . $sFilePart . '.log', 'a+'), LogDateWriter::ERROR);

// Create container
$oContainer = new \Slim\Container();
// Register component on container
$oContainer['view'] = function ($c) {
    return new \SiteView();
};
$oContainer['adminView'] = function ($c) {
    return new \Tools\View\SimpleView('views/admin/');
};
$oContainer['log'] = $oLog;

/**
 * Charge le fichier de configuration de dev si il existe, celui de prod sinon
 */
if ($bDevMode) {
	$oContainer['settings']['displayErrorDetails'] = true;
	
	$oLog->setLogLevel(LogDateWriter::DEBUG);
	$oContainer['log'] = $oLog;
	
	if ($arGlblSqlAccess) {
		ORM::configure('logging', true);
		ORM::configure('logger', function($sLogString, $sQueryTime) {
			debug ("IdiORM - Query ({$sQueryTime}) : " . $sLogString);
		});
	}
}

$oGlobalApp = new \Slim\App($oContainer);

/**
 * Inclusion du fichier utilitaire
 */
require_once 'controllers/_utils.php';

/**
 * Inclusion des fichiers de controller (fichier ne commencant pas par un '_'
 */
foreach (glob('controllers/[^_]*.php') as $sCntrlFile) {
    include_once $sCntrlFile;
}

$oGlobalApp->run();
