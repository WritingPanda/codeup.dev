<?php 

class Conversation {
    // Property to hold name
    public $name = '';
    public $lastname = '';

    // Method to say hello to name
    function say_hello($paragraph = TRUE) {
        $greeting = "Hello {$this->name} {$this->lastname}.";

        if ($paragraph == TRUE) {
            return "<p>$greeting</p>";
        } else{
            return $greeting . PHP_EOL;
        }
    }

    // Method to say goodbye
    function say_goodbye() {
        return "Goodbye, {$this->name} {$this->lastname}!";
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Classes</title>
</head>
<body>
<?php 

// Create a new instance of Conversation
$chat = new Conversation();

// Set the $name variable
$chat->name = 'Omar';
$chat->lastname = 'Quimbaya';

// Output greeting to $name
echo $chat->say_hello(FALSE);

echo $chat->say_hello(TRUE);

echo $chat->say_goodbye();

?>
</body>
</html>