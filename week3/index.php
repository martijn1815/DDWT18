<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week3', 'ddwt18', 'ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

// Add routes here
/* mount for the API */
$router->mount('/api', function() use ($router, $db){
    http_content_type();

    /* GET for reading all series */
    $router->get('/series', function() use ($db) {
        $series = get_series($db);
        echo json_encode($series);
    });


});

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo 'Error: 404 Not Found';
});

/* Run the router */
$router->run();
