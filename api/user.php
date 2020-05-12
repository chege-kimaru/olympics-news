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

use \Firebase\JWT\JWT;

require_once 'config/Database.php';
require_once 'models/User.php';

try {
    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user->id = $_POST['id'];
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->role = $_POST['role'];
        $user->password = $_POST['password'];
        $user->location = $_POST['location'];

        if ($_GET['type'] === 'register') {
            $user->register();
            http_response_code(201);
            echo json_encode(array('data' => 'Successfully registered user'));
            exit;
        } else if ($_GET['type'] === 'login') {
            $res = $user->login();
            if ($res) {
                http_response_code(200);
                $token = array(
                    "data" => array(
                        "id" => $res->id
                    )
                );
                $jwt = JWT::encode($token, JWT_KEY);
                $res->jwt = $jwt;
                echo json_encode($res);
            } else {
                http_response_code(401);
                echo json_encode(array('data' => 'Wrong username or password'));
            }
            exit;
        } else if ($_GET['type'] === 'change-password') {
            isUser($loggedInUser);
            $user->id = $loggedInUser->id;
            $user->changePassword($_POST['password'], $_POST['newPassword']);
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully changed password'));
            exit;
        } else if ($_GET['type'] === 'change-role') {
            isSuperAdmin($loggedInUser);
            $user->changeRole();
            http_response_code(200);
            echo json_encode(array('data' => 'Successfully changed role'));
            exit;
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        http_response_code(200);
        echo json_encode($user->getUsers());
    }


} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => $e->getMessage()));
}