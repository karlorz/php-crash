<?php
class Server
{
  private $services = [];

  public function __construct()
  {
    // $this->services = [];
  }

  // Register a service
  public function registerService($serviceName, $service)
  {
    $this->services[$serviceName] = $service;
  }

  // Remove a service
  public function removeService($serviceName)
  {
    // unset($this->services[$name]);
  }

  public function handle($payload)
  {
    // Handle JSON payload
    $requests = json_decode($payload, true);

    foreach ($requests as $request) {
      $methodParts = explode(".", $request["method"]);
      $serviceName = $methodParts[0];
      $methodName = $methodParts[1];

      if (isset($this->services[$serviceName])) {
        $service = $this->services[$serviceName];
        $this->invokeMethod($service, $methodName, $request["params"]);
      }
    }
  }

  private function invokeMethod($service, $methodName, $params)
  {
    if ($params) {
      $paramTypes = [];
      $paramValues = [];
      foreach ($params as $key => $value) {
        $paramTypes[] = gettype($value);
        $paramValues[] = $value;

        // Handle double to int conversion
        //   if ($paramTypes[$key] == 'double') {
        //     $paramTypes[$key] = 'integer';
        //     $paramValues[$key] = (int)$value;
        //   }
      }
    }

    $reflection = new ReflectionClass($service);
    try {
      $method = $reflection->getMethod($methodName);
    } catch (ReflectionException $e) {
      // Method doesn't exist
      echo "Caught exception: ", $e->getMessage(), PHP_EOL;
      return;
    }
    //   $method = $reflection->getMethod($methodName);
    $method->invokeArgs($service, $paramValues);
    // Invoke method using reflection
  }
}
class ChatRoom
{
  private $messageCount;

  public function __construct()
  {
    // $this->messageCount = 0;
    session_start();
    $this->loadMessageCount();
  }

  public function new_message($message)
  {
    // echo "New message: " . $message . PHP_EOL;
    // $this->messageCount++;
    $this->messageCount++;
    $this->saveMessageCount();
    return $this->messageCount;
  }

  public function getMessageCount()
  {
    return $this->messageCount;
  }

  private function loadMessageCount()
  {
      if (isset($_SESSION['messageCount'])) {
          $this->messageCount = (int)$_SESSION['messageCount'];
      } else {
          $this->messageCount = 0;
      }
  }

  private function saveMessageCount()
  {
      $_SESSION['messageCount'] = $this->messageCount;
  }
}

class MemberSystem
{
  private $memberAges = [];

  public function __construct()
  {
  }

  public function new_member($email, $age)
  {
    // ...
    // var_dump($age);
    $this->memberAges[$email] = $age;
  }

  public function getAgeByEmail($email)
  {
    // ...
    return $this->memberAges[$email];
  }

  // Remove a member by email (not implemented)
  public function remove_member($email)
  {
    // Not implemented
  }
}

// $server = new Server();
// $chatRoom = new ChatRoom();
// $memberSystem = new MemberSystem();

// // Register the chatRoom and memberSystem services to the server
// $server->registerService("chatroom", $chatRoom);
// $server->registerService("member", $memberSystem);

// JSON payload containing multiple requests
// $jsonPayload = '[
//     {
//         "method": "chatroom.new_message",
//         "params": {
//             "message": "Foo"
//         }
//     },
//     {
//         "method": "chatroom.new_message",
//         "params": {
//             "message": "Hello"
//         }
//     },
//     {
//         "method": "member.new_member",
//         "params": {
//             "email": "jason@example.com",
//             "age": 12
//         }
//     },
//     {
//         "method": "member.remove_member",
//         "params": {
//             "email": "tony@example.com"
//         }
//     }
// ]';

// // Handle the JSON payload
// $server->handle($jsonPayload);

// // Print the results
// echo "Chat room message count: " .
//   $chatRoom->getMessageCount() .
//   " (Expected: 2)" .
//   PHP_EOL;
// echo "Jason's age: " .
//   $memberSystem->getAgeByEmail("jason@example.com") .
//   " (Expected: 12)" .
//   PHP_EOL;

$server = new Server();
$chatRoom = new ChatRoom();
$memberSystem = new MemberSystem();

// Register the chatRoom and memberSystem services to the server
$server->registerService("chatroom", $chatRoom);
$server->registerService("member", $memberSystem);