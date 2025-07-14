<?php
header('Content-Type: application/json');

try {
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo json_encode([
            'success' => true,
            'message' => 'POST request received successfully',
            'method' => $_SERVER['REQUEST_METHOD']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method',
            'method' => $_SERVER['REQUEST_METHOD']
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>