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
    function say_hello() {
        return "Hello {$this->name} {$this->lastname}.";
    }
}

// Create a new instance of Conversation
$chat = new Conversation();

// Set the $name variable
$chat->name = 'Codeup';
$chat->lastname = 'Cohort';

// Output greeting to $name
echo $chat->say_hello();
?>
</body>
</html>