<?php
/**
 * Fichier des fonctions utilitaires
 */

// ***** Fonctions de logs

/**
 * Fonction de logging gloable - niveau debug
 * 
 * @global object $oGlobalApp Objet Application Slim
 * @param string $sMessage Message à enregistrer
 */
function debug (string $sMessage) {
  global $oLog;
    
  $oLog->debug($sMessage);
}
  
  /**
 * Fonction de logging gloable - niveau error
 * 
 * @global object $oGlobalApp Objet Application Slim
 * @param string $sMessage Message à enregistrer
 */
function error (string $sMessage) {
  global $oLog;
  
  $oLog->error($sMessage);
}
  
// ***** Fonctions utilitaires
/** Insère la variable dans un objet, le transforme en JSON et l'affiche sur la sortie standard
 * 
 * En cas d'erreur de génération, le code d'erreur et le message associé est affiché
 * 
 * @param mixed   $mContent  Contenu à retourner en JSON
 * @param int $iError    Code d'erreur à retourner (0 par défaut)
 * @param string $sErrorMsg Message d'erreur à retourner (vide par defaut)
 */
function _returnEnclosedJson(string|array|null $mContent, int $iError = 0, string $sErrorMsg = ''): void {
  if ($iError) {
    $sReturnJson = json_encode(array('content' => null, 'error' => $iError, 'message' => $sErrorMsg));
  } else {
    $sReturnJson = json_encode(array('content' => $mContent, 'error' => 0, 'message' => ''));
  }
  
  if (json_last_error() != 0) {
    $sReturnJson = json_encode(array('content' => null, 'error' => json_last_error(), 'message' => json_last_error_msg()));
  }
  echo $sReturnJson;
}

/** Récupère et nettoye la valeur d'une variable de type String
 * 
 * @param string $sRawValue Valeur à filtrer
 * @return string Valeur filtrée
 */
function _filterVarStringstring ($sRawValue): mixed {
  return filter_var($sRawValue, FILTER_SANITIZE_STRING, 
    array('flags' => array(
      FILTER_FLAG_NO_ENCODE_QUOTES, 
      FILTER_FLAG_STRIP_LOW, 
      FILTER_FLAG_STRIP_HIGH))
  );
}

/** Récupère et nettoye la valeur d'une variable de type Integer
 * 
 * @param string $sRawValue Valeur à filtrer
 * @param int $iDefault Valeur par défaut
 * @return int Valeur filtrée
 */
function _filterVarInteger(string $sRawValue, int $iDefault = -1) {
  return filter_var($sRawValue, FILTER_VALIDATE_INT,
    array('options' => array('default' => $iDefault))
  );
}
