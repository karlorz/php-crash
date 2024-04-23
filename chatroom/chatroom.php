<?php

// Start the session
session_start();

// Function to count the number of messages in the chat room
function countMessages() {
    if (isset($_SESSION['messages'])) {
        return count($_SESSION['messages']);
    }

    return 0;
}

// Check if the request is a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the message count
    $messageCount = countMessages();

    // Prepare the response JSON
    $response = [
        'message' => 'Success',
        'count' => $messageCount
    ];

    // Set the response headers
    header('Content-Type: application/json');
    http_response_code(200);

    // Send the response JSON
    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request to add a new message
    $message = $_POST['message'];

    if (!empty($message)) {
        // Initialize the messages array if it doesn't exist
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }

        // Add the new message
        $_SESSION['messages'][] = [
            'message' => $message,
            'timestamp' => time()
        ];

        // Redirect back to the chat room page
        header('Location: index.html');
        exit();
    }
} else {
    // Handle unsupported request methods
    http_response_code(405); // Method Not Allowed
    echo 'Unsupported request method';
}
?>