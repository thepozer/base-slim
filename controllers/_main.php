<?php

	require_once 'controllers/_config.php';

	if ($arGlblSqlAccess) {
		ORM::configure($arGlblSqlAccess['sql_url']);
		ORM::configure('username', $arGlblSqlAccess['username']);
		ORM::configure('password', $arGlblSqlAccess['password']);
		ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	$oLog = new \Thepozer\Log\SimpleLog(fopen('logs/application-' . date('Y-m-d') . '.log', 'a+'), \Thepozer\Log\SimpleLog::ERROR);

	if ($bDevMode) {
		$oLog->setLogLevel(\Thepozer\Log\SimpleLog::DEBUG);

		if ($arGlblSqlAccess) {
			ORM::configure('logging', true);
			ORM::configure('logger', function($sLogString, $sQueryTime) {
				debug ("IdiORM - Query ({$sQueryTime}) : " . $sLogString);
			});
		}
	}

	/**
	 * Inclusion du fichier utilitaire
	 */
	require_once 'controllers/_utils.php';
