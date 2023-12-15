<?php
session_start();

// Function to send a message
function sendMessage($message) {
    $date = date('Y-m-d H:i:s');
    $formattedMessage = "<p><strong>$date:</strong><em> $message</em></p>";

    file_put_contents('chat.html', $formattedMessage, FILE_APPEND);
}

// Check if a message is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    // Send the message
    sendMessage($message);

    // Return a simple JSON response
    $response = array(
        'success' => true,
        'message' => $message,
    );

    echo json_encode($response);
} else {
    // Return the initial chat content
    echo file_get_contents('chat.html');
}
?>
