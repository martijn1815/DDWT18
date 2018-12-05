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

    /* GET for reading individual series */
    $router->get('/series/(\d+)', function($id) use ($db) {
        $serie_info = get_serieinfo($db, $id);
        echo json_encode($serie_info);
    });

    /* GET for deleting individual series */
    $router->get('/series/delete/(\d+)', function($id) use ($db) {
        $feedback = remove_serie($db, $id);
        echo json_encode($feedback);
    });

    /* POST for adding series */
    $router->post('/series', function() use ($db) {
        $feedback = add_serie($pdo, $_POST);
        echo json_encode($feedback);
    });

    /* PUT for updating series */
    $router->put('/series/(\d+)', function($id) use ($db) {
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);

        $serie_info = $_PUT + ["serie_id" => $id];
        $feedback = update_serie($db, $serie_info);
        echo json_encode($feedback);
    });

});

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo 'Error: 404 Not Found';
});

/* Run the router */
$router->run();
