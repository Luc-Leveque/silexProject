<?php

$data = file_get_contents('http://localhost/phprest/rest_user_server_vo.php?id=3');

var_dump($data);

$obj_data = json_decode($data);

$users = $obj_data->result->users;

if(count($users) > 0 ){
    $user = $users[0];
    var_dump($user);
    echo $user->id_user. " : ". $user->nom. " - " . $user->prenom . " - " . $user->email;
}

$data = file_get_contents('http://localhost/phprest/rest_user_server_vo.php');

var_dump($data);

$obj_data = json_decode($data);

$users = $obj_data->result->users;

foreach($users as $user ) {
    echo $user->id_user. " : ". $user->nom. " - " . $user->prenom . " - " . $user->email. "</br>" ;
}




?>