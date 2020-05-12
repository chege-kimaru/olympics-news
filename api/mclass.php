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
require_once 'models/MClass.php';

try {
    $database = new Database();
    $db = $database->connect();
    $mclass = new MClass($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mclass->game_id = $_POST['game_id'];
        $mclass->stadium_id = $_POST['stadium_id'];
        $mclass->location = $_POST['location'];
        $mclass->title = $_POST['title'];
        $mclass->about = $_POST['about'];
        $mclass->mfrom = $_POST['from'];
        $mclass->mto = $_POST['to'];

        if ($_GET['type'] === 'join') {
            isUser($loggedInUser);
            $user_id = $loggedInUser->id;
            $mclass->id = $_GET['class-id'];

            $mclass->joinClass($user_id);
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully joined class'));
            exit;
        } else if ($_GET['type'] === 'leave') {
            isUser($loggedInUser);
            $user_id = $loggedInUser->id;
            $mclass->id = $_POST['id'];

            $mclass->leaveClass($user_id);
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully left class'));
            exit;
        } else if ($_POST['id']) {
            isAdmin($loggedInUser);
            $mclass->id = $_POST['id'];
            $mclass->updateMClass();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully updated class'));
            exit;
        } else {
            isAdmin($loggedInUser);
            $mclass->addMClass();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully added class'));
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['type'] === 'members') {
            $mclass->id = $_GET['class-id'];
            isAdmin($loggedInUser);
            http_response_code(200);
            echo json_encode($mclass->getClassMembers());
            exit;
        } else if ($_GET['type'] === 'joined') {
            isUser($loggedInUser);
            http_response_code(200);
            echo json_encode($mclass->getJoinedClasses());
            exit;
        } else {
            http_response_code(200);
            error_log("+++++++++++++++++++++++++++++++");
            error_log($loggedInUser->id);
            if ($loggedInUser)
                echo json_encode($mclass->getMClasses($loggedInUser->id));
            else
                echo json_encode($mclass->getMClasses());
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        isAdmin($loggedInUser);
        http_response_code(200);
        $mclass->id = $_GET['id'];
        $mclass->deleteClass();
        echo json_encode(array('data' => 'Successfully deleted class'));
        exit;
    }


} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}