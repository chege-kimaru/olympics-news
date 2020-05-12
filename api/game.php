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
require_once 'models/Game.php';

try {
    $database = new Database();
    $db = $database->connect();
    $game = new Game($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        isAdmin($loggedInUser);

        $game->name = $_POST['name'];

        if ($_FILES['image'] && $_FILES['image']['name']) {
            $fileName = time() . '-' . $_FILES['image']['name'];
            $savePath = 'api/public/' . $fileName;
            $path = __DIR__ . '/public/' . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                $game->image = $savePath;
            } else {
                throw new Exception('Could not upload image');
            }
        }

        if ($_POST['id']) {
            $game->id = $_POST['id'];
            $c = $game->getGameById();
            $game->image = $game->image ? $game->image : $c->image;

            $game->updateGame();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully updated game'));
            exit;
        } else {
            $game->addGame();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully added game'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        http_response_code(200);
        if($_GET['id']) {
            $game->id = $_GET['id'];
            echo json_encode($game->getGameById());
            exit;
        }
        echo json_encode($game->getGames());
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        isAdmin($loggedInUser);
        $game->id = $_GET['id'];
        $game->deleteGame();
        http_response_code(200);
        echo json_encode(array('data' => 'Successfully deleted game'));
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}