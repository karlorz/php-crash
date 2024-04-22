<?php
include 'server.php'; 

$server = new Server();
$chatRoom = new ChatRoom();
$memberSystem = new MemberSystem();

// Register the chatRoom and memberSystem services to the server
$server->registerService("chatroom", $chatRoom);
$server->registerService("member", $memberSystem);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonPayloadget = file_get_contents('php://input');

    // // Handle the JSON payload
    $server->handle($jsonPayloadget);
    $message_count = $chatRoom->getMessageCount();

    echo "Chat room message count: " . $message_count . PHP_EOL;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
</head>
<body>
    <h1>Chat Room</h1>
    <form id="chatForm">
        <label for="message">New Message:</label>
        <input type="text" id="message" name="message" required>
        <button type="submit">Send</button>
    </form>
    <div id="response"></div>

    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var message = document.getElementById('message').value;
            sendMessage(message);
        });

        function sendMessage(message) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('response').innerHTML = xhr.responseText;
                }
            };
            var jsonPayload = '[{"method":"chatroom.new_message","params":{"message":"' + message + '"}}]';
            xhr.send(jsonPayload);
        }
    </script>
</body>
</html>