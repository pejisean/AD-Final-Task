<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);

    // Fallback if JSON input is empty
    if(!$input){
        $input = $_POST;
    }

    $username = trim($input['codename'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($username) || empty($password)){
        echo json_encode([
            'success' => false,
            'message' => 'Username and password are required'
        ]);
        exit();
    }

    $result = AuthUtil::login($username, $password);
    echo json_encode($result);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);

}

?>