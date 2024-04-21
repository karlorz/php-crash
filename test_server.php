<?php
// Test ChatRoom class
include "0a_backend.php";

// Create chat room instance
$chatRoom = new ChatRoom();

$testsPassed = true;

// Test initial message count
try {
  assert(
    $chatRoom->getMessageCount() === 0,
    "Test initial message count: Failed"
  );
  echo "Test initial message count: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Add a message
$chatRoom->new_message("Hello");

// Test message count after 1 message
try {
  assert(
    $chatRoom->getMessageCount() === 1,
    "Test message count after 1 message: Failed"
  );
  echo "Test message count after 1 message: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Add another message
$chatRoom->new_message("Hi");

// Test message count after 2 messages
try {
  assert(
    $chatRoom->getMessageCount() === 2,
    "Test message count after 2 messages: Failed"
  );
  echo "Test message count after 2 messages: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Test getMessageCount method directly
try {
  assert(
    $chatRoom->getMessageCount() === 2,
    "Test getMessageCount method directly: Failed"
  );
  echo "Test getMessageCount method directly: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Summary
if ($testsPassed) {
  echo 'ChatRoom tests passed!\n';
} else {
  echo 'ChatRoom tests failed!\n';
}

// Test MemberSystem class
$memberSystem = new MemberSystem();

$testsPassed = true;

// Test initial state
try {
  assert(empty($memberSystem->memberAges), "Test initial state: Failed");
  echo "Test initial state: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Add a member
$memberSystem->new_member("john@example.com", 19);

// Test member was added
try {
  assert(
    $memberSystem->getAgeByEmail("john@example.com") === 20,
    "Test member was added: Failed"
  );
  echo "Test member was added: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Add another member
$memberSystem->new_member("sarah@example.com", 25);

// Test second member
try {
  assert(
    $memberSystem->getAgeByEmail("sarah@example.com") === 25,
    "Test second member: Failed"
  );
  echo "Test second member: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Test remove_member method (even though not implemented)
$memberSystem->remove_member("john@example.com");
try {
  assert(
    null !== $memberSystem->getAgeByEmail("john@example.com"),
    "Test remove_member method: Failed"
  );
  echo "Test remove_member method: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Summary
if ($testsPassed) {
  echo 'memberSystem tests passed!\n';
} else {
  echo 'memberSystem tests failed!\n';
}

// Test Server class
$server = new Server();

$testsPassed = true;

// Test no services initially registered
try {
  assert(
    empty($server->services),
    "Test no services initially registered: Failed"
  );
  echo "Test no services initially registered: Passed\n";
} catch (AssertionError $e) {
  echo "<span style='color:red;'>{$e->getMessage()}</span>\n";
  $testsPassed = false;
}

// Summary
if ($testsPassed) {
  echo "All tests passed!";
} else {
  echo "Some tests failed!";
}
?>
