<?php

	/**
	 * Fichier d'initialisation de l'objet Global Slim
	 */

	session_start();
	
	require_once "controllers/_main.php";
	
	// Create container
	$oContainer = new \Slim\Container();

	// Register components in container
	$oContainer['view'] = function ($c) {
		return new \Thepozer\View\SimpleView();
	};
	$oContainer['log'] = $oLog;

	/**
	 * Charge le fichier de configuration de dev si il existe, celui de prod sinon
	 */
	if ($bDevMode) {
		$oContainer['settings']['displayErrorDetails'] = true;
	}

	$oGlobalApp = new \Slim\App($oContainer);

	/**
	 * Inclusion des fichiers de controller (fichier ne commencant pas par un '_'
	 */
	foreach (glob('controllers/[^_]*.php') as $sCntrlFile) {
		include_once $sCntrlFile;
	}

	$oGlobalApp->run();
