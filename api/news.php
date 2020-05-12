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
require_once 'models/News.php';

try {
    $database = new Database();
    $db = $database->connect();
    $news = new News($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        isAdmin($loggedInUser);
        $news->game_id = $_POST['game_id'];
        $news->title = $_POST['title'];
        $news->about = $_POST['about'];
        $news->image = $_POST['image'];
        $news->created_by = $loggedInUser->id;
        $news->type = $_POST['type'];
        $news->event_date = $_POST['event_date'];
        $news->stadium_id = $_POST['stadium_id'];

        if ($_FILES['image'] && $_FILES['image']['name'] ) {
            $fileName = time() . '-' . $_FILES['image']['name'];
            $savePath = 'api/public/' . $fileName;
            $path = __DIR__ . '/public/' . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                $news->image = $savePath;
            } else {
                throw new Exception('Could not upload image');
            }
        }

        $images = [];
        if ($_FILES['images'] && $_FILES['images']['name'] && count($_FILES['images']['name']) > 0) {
            $total = count($_FILES['images']['name']);
            for ($i = 0; $i < $total; $i++) {
                $fileName = time() . '-' . $_FILES['images']['name'][$i];
                $savePath = 'api/public/' . $fileName;
                $path = __DIR__ . '/public/' . $fileName;
                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $path)) {
                    array_push($images, $savePath);
                } else {
                    throw new Exception('Could not upload images');
                }
            }
        }

        if ($_GET['type'] === 'addImages') {
            $news->id = $_POST['id'];
            foreach ($images as $image) {
                $news->addNewsImage($image);
            }
            echo json_encode(array('data' => 'Successfully added news images'));
            exit;
        } else if ($_GET['type'] === 'deleteImage') {
            http_response_code(200);
            $news->deleteNewsImage($_GET['imageId']);
            echo json_encode(array('data' => 'Successfully deleted news image'));
            exit;
        } else if ($_POST['id']) {
            $news->id = $_POST['id'];

            $n = $news->getNewsById();
            $news->image = $news->image ? $news->image : $n->image;

            $news->updateNews();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully updated news'));
            exit;
        } else {
            $news->addNews($images);
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully added news'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if($_GET['news-id']) {
            $news->id = $_GET['news-id'];
            http_response_code(200);
            echo json_encode($news->getNewsById());
            exit;
        } else {
            http_response_code(200);
            $news->type = $_GET['type'];
            echo json_encode($news->getNews());
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        isAdmin($loggedInUser);
        http_response_code(200);
        $news->id = $_GET['id'];
        $news->deleteNews();
        echo json_encode(array('data' => 'Successfully deleted news'));
        exit;
    }


} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}