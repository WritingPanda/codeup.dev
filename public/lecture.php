<!doctype html>
<html>
<head>
    <title>Classes</title>
</head>
<body>

<?php 

class Conversation {
    // Property to hold name
    public $name = '';
    public $lastname = '';

    // Method to say hello to name
    function say_hello($newline = FALSE) {
        $greeting = "Hello {$this->name} {$this->lastname}.";

        if ($newline == FALSE) {
            return $greeting;
        } else{
            return $greeting . PHP_EOL;
        }
    }
}

// Create a new instance of Conversation
$chat = new Conversation();

// Set the $name variable
$chat->name = 'Codeup';
$chat->lastname = 'Cohort';

// Output greeting to $name
echo $chat->say_hello();

echo "New line test.";
?>
</body>
</html>