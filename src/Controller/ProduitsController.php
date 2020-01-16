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


$app->get('/silexProject/produits/{id}', function ($id) use ($app){
    $resultat = DaoProduits::findAll();
    $resultat2 = DaoProduits::find($id);
    return $app['twig']->render('produit.html.twig', array(
        'produit' => $resultat2,
        'produits' => $resultat
    ));
});

$app->get('/silexProject/produits/new/', function () use ($app){
    $resultat = DaoProduits::findAll();
    return $app['twig']->render('produit.html.twig', array(
        'produits' => $resultat
    ));
});


$app->put('/silexProject/produits/', function (Request $request) {
    if( 0 === strpos($request->headers->get('Content-Type'),'application/json')){
        $data = json_decode($request->getContent(),true);
        $request->request->replace(is_array($data)? $data : array());
        $newUser = DaoProduits::update($data);
        
        return toJson($newUser,201);

    }
});

$app->post('/silexProject/produits/', function (Request $request) {
    if( 0 === strpos($request->headers->get('Content-Type'),'application/json')){
        $data = json_decode($request->getContent(),true);
        $request->request->replace(is_array($data)? $data : array());
        $newUser = DaoProduits::add($data);
        
        return toJson($newUser,201);

    }
});

$app->delete('/silexProject/produits/{id}', function ($id) use ($app){
    $resultat2 = DaoProduits::delete($id);

    return true;
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