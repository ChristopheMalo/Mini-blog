<?php
$db_config = array();
$db_config['DRIVER']        = 'mysql';
$db_config['HOST']          = 'localhost';
$db_config['DB_NAME']       = 'miniblog';
$db_config['USER']          = 'root';                        // LOCAL
//$db_config['USER']        = 'nom_user_serveur';            // SERVEUR EXEMPLE
$db_config['PASSWORD']      = 'root';                        // LOCAL
//$db_config['PASSWORD']    = 'pass_serveur';                // SERVEUR EXEMPLE
$db_config['OPTIONS']       = array(
                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Affichage message précis si erreur
                                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                                   );

try
{
    // Connexion à la base
    $bdd = new PDO($db_config['DRIVER'] .':host='. $db_config['HOST'] .';dbname='. $db_config['DB_NAME'],
                   $db_config['USER'],
                   $db_config['PASSWORD'],
                   $db_config['OPTIONS']
                   );
    
    //$bdd->exec("SET NAMES 'utf8'");
}
catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
    die();
}