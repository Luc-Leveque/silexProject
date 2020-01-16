<?php

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../model/dao_produits.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../../templates',
));

$app['debug'] = true;

function toJson($resultat, $httpCode=200) {
    global $app ;

    $retour['success'] = true ;
    $retour['result']['nb'] = count($resultat);
    $retour['result']['users'] = $resultat ;
    return $app->json($retour, $httpCode);
}

$app->get('/silexProject/produits', function () use ($app) {
    $resultat = DaoProduits::findAll();
    return $app['twig']->render('produits.html.twig', array(
        'produits' => $resultat
    ));
});


$app->get('/produit/{id}', function ($id){
    $resultat = DaoUser::find($id);
    return toJson($resultat);
});

$app->post('/users', function (Request $request){

    if( 0 === strpos($request->headers->get('Content-Type'),'application/json')){
        $data = json_decode($request->getContent(),true);
        $request->request->replace(is_array($data)? $data : array());
        $newUser = DaoUser::add($data);
        return toJson($newUser,201);
    }
});

$app->run();