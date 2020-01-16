<?php
/*
require_once('dao_user.php');

header('Content-type: application/json');

function getUser($idUser = null) {
    $resultat = ($idUser != null)?DaoUser::find($idUser):DaoUser::findAll();
    $retour['success'] = true ;
    $retour['result']['nb'] = count($resultat);
    $retour['result']['users'] = $resultat ;
    return json_encode($retour);
}

$id = (empty($_GET['id']))?null:$_GET['id'];

echo getUser($id);

*/

require_once('dao_user.php');

define("REST_URI_BASE", "/phpRest/");

header('Content-type: application/json');

function getUser($idUser = null) {
    $resultat = ($idUser != null)?DaoUser::find($idUser):DaoUser::findAll();
    $retour['success'] = true ;
    $retour['result']['nb'] = count($resultat);
    $retour['result']['users'] = $resultat ;
    return json_encode($retour);
}

function addUser($user = null) {
    $resultat = '';
    if($user != null){ $resultat = DaoUser::add($user);}
    $retour['success'] = true ;
    $retour['result']['nb'] = count($resultat);
    $retour['result']['users'] = $resultat ;
    return json_encode($retour);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uriRessource = str_replace(REST_URI_BASE, "", $uri);


if(!empty($uriRessource)){
    $operation = $_SERVER['REQUEST_METHOD'] ;

    $params = explode('/' , $uriRessource );

    if(isset($params[1])){
        if($params[1] == 'users'){
            $id = ( $params[2] ?? null) ;
            if( $operation == "GET") {
                echo getUser($id);
            }
            if( $operation == "POST") {
                $json = file_get_contents('php://input');
                $data = json_decode($json);
                
                $data = get_object_vars($data);

               

                echo addUser($data);
            }
        }
    }
}



?>