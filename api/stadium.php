<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE, PATCH');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Access-Control-Allow-Origin, Content-Type, X-Requested-With, Authorization');
header('Access-Control-Request-Headers: Access-Control-Allow-Methods, Access-Control-Allow-Origin, Content-Type, X-Requested-With, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once 'config/constants.php';
require_once 'validate-token.php';

require_once 'config/Database.php';
require_once 'models/Stadium.php';

try {
    $database = new Database();
    $db = $database->connect();
    $stadium = new Stadium($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        isAdmin($loggedInUser);

        $stadium->name = $_POST['name'];
        $stadium->location = $_POST['location'];

        if ($_FILES['image'] && $_FILES['image']['name']) {
            $fileName = time() . '-' . $_FILES['image']['name'];
            $savePath = 'api/public/' . $fileName;
            $path = __DIR__ . '/public/' . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                $stadium->image = $savePath;
            } else {
                throw new Exception('Could not upload image');
            }
        }

        if ($_POST['id']) {
            $stadium->id = $_POST['id'];

            $s = $stadium->getStadiumById();
            $stadium->image = $stadium->image ? $stadium->image : $s->image;

            $stadium->updateStadium();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully updated stadium'));
            exit;
        } else {
            $stadium->addStadium();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully added stadium'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        http_response_code(200);
        echo json_encode($stadium->getStadiums());
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        isAdmin($loggedInUser);
        http_response_code(200);
        $stadium->id = $_GET['id'];
        $stadium->deleteStadium();
        echo json_encode(array('data' => 'Successfully deleted stadium'));
        exit;
    }


} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}