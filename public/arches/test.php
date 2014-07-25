<?php 

echo "Welcome to alphabet soup!" . PHP_EOL;
sleep(2);
echo "Please enter a word or phrase: ";
$str = fgets(STDIN);
echo PHP_EOL;

function alphaSoup($string) {
	$array = str_split($string);
	sort($array);
	return $array;
}

$array = alphaSoup($str);

print_r($array);

?>