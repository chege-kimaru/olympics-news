<?php
/**
 * Created by PhpStorm.
 * User: Kevin Chege
 * Date: 03/12/2018
 * Time: 22:20
 */

include_once 'config/Database.php';
include_once 'models/User.php';
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;

foreach (apache_request_headers() as $header=>$value) {
    if($header == 'Authorization') {
        $jwt = $value;
    }
}
$loggedInUser = null;
if($jwt){
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, JWT_KEY, array('HS256'));

        $database = new Database();
        $db = $database->connect();

        $user = new User($db);
        $user->id = $decoded->data->id;
        $loggedInUser = $user->getUserById();

    } catch (Exception $e) {
        $loggedInUser = null;
    }
}

function isSuperAdmin($user) {
    if ($user == null || $user->role < 3) {
        http_response_code(401);
        echo json_encode(array('error' => 'You are not authorized.'));
        exit;
    }
}

function isAdmin($user) {
    if ($user == null || $user->role < 2) {
        http_response_code(401);
        echo json_encode(array('error' => 'You are not authorized.'));
        exit;
    }
}

function isUser($user) {
    if ($user == null || $user->role < 1) {
        http_response_code(401);
        echo json_encode(array('error' => 'You are not authorized.'));
        exit;
    }
}