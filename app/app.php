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

		$app->delete("/stylist/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->deleteStylist();
        $current_stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array('stylist' => $current_stylists));
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

		$app->get("/stylist/{id}/view/{client_id}", function ($id) use ($app) {
			$stylist = Stylist::find($id);
    	$current_client = Client::find($id);
    	return $app['twig']->render("view_client.html.twig", array('stylist' => $stylist,
    		'client' => $current_client
    	));
    });

		$app->get("/stylist/{id}/edit/{client_id}", function ($id, $client_id) use ($app) {
			$stylist = Stylist::find($id);
    	$client = Client::find($client_id);
    	return $app['twig']->render("edit_client.html.twig", array('stylist' => $stylist,
    		'client' => $client
    	));
    });

		$app->patch("/stylist/{id}/client_edit/{client_id}", function ($id, $client_id) use ($app) {
			$stylist = Stylist::find($id);
    	$client = Client::find($client_id);
			$name = $_POST['new_name'];
			$client->updateName($name);
			$current_clients = $stylist->getClients();
    	return $app['twig']->render("current_stylist.html.twig", array('stylist' => $stylist,
    		'clients' => $current_clients
    	));
    });

		$app->delete("/stylist/{id}/delete/{client_id}", function($id, $client_id) use ($app) {
        $stylist = Stylist::find($id);
        $client = Client::find($client_id);
        $client->deleteClient();
        $current_clients = $stylist->getClients();
        return $app['twig']->render('current_stylist.html.twig', array('stylist' => $stylist, 'clients' => $current_clients));
    });

    return $app;

?>
