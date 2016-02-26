<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__.'/../src/Stylist.php';
	require_once __DIR__.'/../src/Client.php';

	$app = new Silex\Application();

	// $server = 'mysql:host=localhost:8889;dbname=hair_salon'; <-- LOCAL LAPTOP
	$server = 'mysql:host=localhost;dbname=hair_salon';
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
    	return $app['twig']->render("stylist.html.twig", array('stylists',
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

		$app->get("/stylist/{id}", function ($id) use ($app) {
    	$stylist = Stylist::find($id);
			$current_clients = $stylist->getClients();
    	return $app['twig']->render("current_stylist.html.twig", array(
    		'stylist' => $stylist, 'clients' => $current_clients
    	));
    });

		$app->post("/stylist/{id}", function ($id) use ($app) {
    	$stylist = Stylist::find($id);
			$new_client = new Client($_POST['name'], $id);
			$new_client->save();
    	return $app['twig']->render("current_stylist.html.twig", array(
    		'stylist' => $stylist, 'clients' => $stylist->getClients()
    	));
    });

		$app->get("/client/{id}", function ($id) use ($app) {
			$stylist = Stylist::find($id);
    	$client = Client::find($id);
    	return $app['twig']->render("current_client.html.twig", array('stylist' => $stylist,
    		'clients' => $client
    	));
    });

		$app->get("/stylist/{id}/edit/{client_id}", function ($id, $client_id) use ($app) {
			$stylist = Stylist::find($id);
    	$client = Client::find($client_id);
    	return $app['twig']->render("current_client.html.twig", array('stylist' => $stylist,
    		'clients' => $client
    	));
    });
    return $app;

?>
