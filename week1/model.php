<?php
/**
 * Model
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Check if the route exist
 * @param string $route_uri URI to be matched
 * @param string $request_type request method
 * @return bool
 *
 */
function new_route($route_uri, $request_type){
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/',parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    }
}

/**
 * Creates a new navigation array item using url and active status
 * @param string $url The url of the navigation item
 * @param bool $active Set the navigation item to active or inactive
 * @return array
 */
function na($url, $active){
    return [$url, $active];
}

/**
 * Creates filename to the template
 * @param string $template filename of the template without extension
 * @return string
 */
function use_template($template){
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

/**
 * Creates breadcrumb HTML code using given array
 * @param array $breadcrumbs Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the breadcrumbs
 */
function get_breadcrumbs($breadcrumbs) {
    $breadcrumbs_exp = '<nav aria-label="breadcrumb">';
    $breadcrumbs_exp .= '<ol class="breadcrumb">';
    foreach ($breadcrumbs as $name => $info) {
        if ($info[1]){
            $breadcrumbs_exp .= '<li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
        }else{
            $breadcrumbs_exp .= '<li class="breadcrumb-item"><a href="'.$info[0].'">'.$name.'</a></li>';
        }
    }
    $breadcrumbs_exp .= '</ol>';
    $breadcrumbs_exp .= '</nav>';
    return $breadcrumbs_exp;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($navigation){
    $navigation_exp = '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    $navigation_exp .= '<a class="navbar-brand">Series Overview</a>';
    $navigation_exp .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
    $navigation_exp .= '<span class="navbar-toggler-icon"></span>';
    $navigation_exp .= '</button>';
    $navigation_exp .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    $navigation_exp .= '<ul class="navbar-nav mr-auto">';
    foreach ($navigation as $name => $info) {
        if ($info[1]){
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="'.$info[0].'">'.$name.'</a>';
        }else{
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="'.$info[0].'">'.$name.'</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '</ul>';
    $navigation_exp .= '</div>';
    $navigation_exp .= '</nav>';
    return $navigation_exp;
}

/**
 * Pritty Print Array
 * @param $input
 */
function p_print($input){
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

/**
 * Creats HTML alert code with information about the success or failure
 * @param bool $type True if success, False if failure
 * @param string $message Error/Success message
 * @return string
 */
function get_error($feedback){
    $error_exp = '
        <div class="alert alert-'.$feedback['type'].'" role="alert">
            '.$feedback['message'].'
        </div>';
    return $error_exp;
}

/**
 * Initializing a DB connection
 * @param $host
 * @param $dbn
 * @param $user
 * @param $pass
 * @return PDO
 */
function connect_db($host, $dbn, $user, $pass){
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$dbn;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        /*echo "Connected successfully";*/
        echo '<script>console.log("Connected successfully")</script>';
    } catch (\PDOException $e) {
        echo sprintf("Failed to connect. %s", $e->getMessage());
    }
    return $pdo;
}

/**
 * Return the number of series listed in the database
 * @param PDO $pdo database object
 * @return mixed
 */
function count_series($pdo){
    $stmt = $pdo->prepare('SELECT * FROM series');
    $stmt->execute();
    return $stmt->rowCount();
}

/**
 * Returns an associative array with all the series listed in the database
 * @param PDO $pdo database object
 * @return mixed
 */
function get_series($pdo){
    $stmt = $pdo->prepare('SELECT * FROM series');
    $stmt->execute();
    $series = $stmt->fetchAll();

    /* Run htmlspecialchars on all values in array */
    foreach($series as $key1 => $serie){
        foreach($serie as $key2 => $value) {
            $series[$key1][$key2] = htmlspecialchars($value);
        }
    }
    return $series;
}

/**
 * Returns a string with the HTML code representing the table with all the series
 * @param $series
 * @return string
 */
function get_series_table($series){
    $table = '<table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Series</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>';
    foreach($series as $serie){
        $row = '<tr>
                    <th scope="row">'.$serie["name"].'</th>
                    <td><a href="/DDWT18/week1/serie/?serie_id='.$serie["id"].'" role="button" class="btn btn-primary">More info</a></td>
                </tr>';
        $table = $table.$row;
    }
    $table = $table.'</tbody>
                     </table>';
    return $table;
}

/**
 * Returns the information of a series with a specific series id
 * @param PDO $pdo database object
 * @param $serie_id
 * @return mixed
 */
function get_series_info($pdo, $serie_id){
    $stmt = $pdo->prepare('SELECT * FROM series WHERE id = ?');
    $stmt->execute([$serie_id]);
    $serie_info = $stmt->fetch();

    /* Run htmlspecialchars on all values in array */
    foreach($serie_info as $key => $value){
        $serie_info[$key] = htmlspecialchars($value);
    }
    return $serie_info;
}

/**
 * Add a serie to the database
 * @param PDO $pdo database object
 * @param $form_serie_info
 * @return array
 */
function add_series($pdo, $form_serie_info){
    /* Check if all fields are set */
    if (
        empty($form_serie_info['Name']) or
        empty($form_serie_info['Creator']) or
        empty($form_serie_info['Seasons']) or
        empty($form_serie_info['Abstract'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'Error; Not all fields were filled in.'
        ];
    }
    /* Check data type for Seasons */
    if (!is_numeric($form_serie_info['Seasons'])) {
        return [
            'type' => 'danger',
            'message' => 'Error; Input for Seasons must be numeric'
        ];
    }
    /* Check if Name already in Database */
    $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
    $stmt->execute([$form_serie_info['Name']]);
    $serie_exists = $stmt->rowCount();
    if ($serie_exists) {
        return [
            'type' => 'danger',
            'message' => 'Error; Name already in database'
        ];
    }
    /* Add serie to Database */
    $stmt = $pdo->prepare('INSERT INTO series (name, creator, seasons, abstract) VALUES(?, ?, ?, ?)');
    $stmt->execute([
        $form_serie_info['Name'],
        $form_serie_info['Creator'],
        $form_serie_info['Seasons'],
        $form_serie_info['Abstract']
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted == 1) {
        return [
            'type' => 'success',
            'message' => 'Series '.$form_serie_info['Name'].' added to database'
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'Error; The serie was not added to database. Try again.'
        ];
    }
}