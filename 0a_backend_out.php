<?php
include '0a_backend.php'; 

$server = new Server();
$chatRoom = new ChatRoom();
$memberSystem = new MemberSystem();

// Register the chatRoom and memberSystem services to the server
$server->registerService("chatroom", $chatRoom);
$server->registerService("member", $memberSystem);

// JSON payload containing multiple requests
$jsonPayload = '[
    {
        "method": "chatroom.new_message",
        "params": {
            "message": "Foo"
        }
    },
    {
        "method": "chatroom.new_message",
        "params": {
            "message": "Hello"
        }
    },
    {
        "method": "member.new_member",
        "params": {
            "email": "jason@example.com",
            "age": 12
        }
    },
    {
        "method": "member.remove_member",
        "params": {
            "email": "tony@example.com"
        }
    }
]';

$jsonPayload1 = '[
    {
        "method": "chatroom.new_message",
        "params": {
            "message": "Foo"
        }
    },
    {
        "method": "chatroom.new_message",
        "params": {
            "message": "Hello"
        }
    },
    {
        "method": "chatroom.new_message",
        "params": {
            "message": "World"
        }
    }
]';

// Handle the JSON payload
$server->handle($jsonPayload);
$server->handle($jsonPayload1);

// Print the results
echo "Chat room message count: " .
  $chatRoom->getMessageCount() .
  " (Expected: 2)" .
  PHP_EOL;
echo "Jason's age: " .
  $memberSystem->getAgeByEmail("jason@example.com") .
  " (Expected: 12)" .
  PHP_EOL;
?>
