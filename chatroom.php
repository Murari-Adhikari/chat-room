<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=message;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

session_start();
date_default_timezone_set("Asia/Seoul");

function sendMessage($message, $userId) {
    $date = date('Y-m-d H:i:s');
    $formattedMessage = "$date: $message";

    // Store the message in a session variable
    if (!isset($_SESSION['chat_messages'])) {
        $_SESSION['chat_messages'] = array();
    }

    array_push($_SESSION['chat_messages'], $formattedMessage);
}

function getMessages() {
    if (isset($_SESSION['chat_messages'])) {
        return array_reverse($_SESSION['chat_messages']);
    } else {
        return array();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $userId = $_POST['userId'];

    // Validate/sanitize $userId and $message here if needed

    sendMessage($message, $userId);

    $response = array(
        'success' => true,
        'message' => $message,
        'userId' => $userId,
        'date' => date('Y-m-d H:i:s'),
    );

    // Insert into the database
    try {
        $stmt = $db->prepare("INSERT INTO chat (pseudo, message, date_created) VALUES (:userId, :message, NOW())");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $ex) {
        // Log or handle the database error
        $response['success'] = false;
        $response['error'] = 'Database error: ' . $ex->getMessage();
    }

    echo json_encode($response);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $messages = getMessages();
    echo json_encode($messages);
}
?>
