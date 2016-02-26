<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__.'/../src/Stylist.php';
	require_once __DIR__.'/../src/Client.php';

	$app = new Silex\Application();

	$server = 'mysql:host=localhost:8889;dbname=hair_salon';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	$app->register(new Silex\Provider\TwigServiceProvider, array(
	 'twig.path' => __DIR__.'/../views'
	));

	use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function () use ($app) {
    	return $app['twig']->render("index.html.twig");
    });

    $app->get("/stylists", function () use ($app) {
    	return $app['twig']->render("stylist.html.twig", array( 'stylists',
    		Stylist::getAll()
    	));
    });

    $app->post("/stylists", function () use ($app) {
    	$new_stylist = new Stylist($_POST['name']);
    	$new_stylist->save();
    	return $app['twig']->render("stylist.html.twig", array(
    		'stylists' => Stylist::getAll()
    	));
    });
    return $app;

?>