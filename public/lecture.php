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

    // Allow name to be set on instantiation
    function __construct($name = '') {
        $this->name = $name;
    }

    function __destruct() {
        echo "Goodbye, {$this->name}\n";
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

$conversation = new Conversation();


?>
</body>
</html>