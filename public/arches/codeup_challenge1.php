<?
// GET USER INPUT FUNCTION-------
function get_input($upper = FALSE) 
{
    $user = trim(fgets(STDIN));
    return $upper ? strtoupper($user) : $user;
}
 
// CHECK USER INPUT FUNCTION
function option($choice){
	switch ($choice) {
		case 'L':
			return list_file();
			break;
		case 'S':
			return search(open());
			break;
	}
}
// ---------------------------------
 
 
// OPEN FILE FUNCTION----------------
function open(){
 
		$filename = 'data/states.txt';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
 
		$states = explode("\n", $contents);
 
		return $states;
}
// ---------------------------------
 
 
// LIST ALL CONTENTS WITHIN THE FILE
function list_file(){
 
		$filename = 'data/states.txt';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
 
		$states = explode("\n", $contents);
		var_dump($states);
 
		echo PHP_EOL . "State / Capital / State Bird" . PHP_EOL . "___________________" . PHP_EOL;
		foreach ($states as $state) {
			echo "$state" . PHP_EOL;
		}
		echo PHP_EOL;
}
// -----------------------------------
 
 
// SEARCH MENU------------------------
function search($list){
	echo "(S)tate | (C)apitol | (B)ird : ";
	$filter = get_input(TRUE);
	$array = $list;
 
	switch ($filter) {
		case 'S':
			echo "Type in the first letter of a State: ";
			$state = get_input(TRUE);
			$filtered = filter_state($array , $state);
			return $filtered;
			break;
		case 'C':
			echo "Enter First Letter of Capitol: ";
			$input = get_input(TRUE);
			$capitols = filter_capitol($array , $input);
			return $capitols;
			break;
		case 'B':
			echo "Search Birds by letter. Enter letter: ";
			$b = get_input(TRUE);
			$birds = filter_bird($array , $b);
			return $birds;
			break;
				
		default:
			
			break;
	}
 
}
// -------------------------------
 
 
// FILTER FUNCTIONS---------------
function filter_state($array, $var) {
	foreach($array as $state){
		if ($state[0] === $var){
			echo PHP_EOL . $state . PHP_EOL . PHP_EOL;
		}
	}
}
 
function filter_capitol($array, $var) {
	foreach($array as $state){
		$newstate = explode(", " , $state);
		if(substr($newstate[1], 0, 1) == $var){
			echo PHP_EOL . $state . PHP_EOL . PHP_EOL;
		}
	}
}
 
 
function filter_bird($array, $var) {
	foreach($array as $state){
		$newstate = explode(", " , $state);
		if(substr($newstate[2], 0, 1) == $var){
			echo PHP_EOL . $state . PHP_EOL . PHP_EOL;
		}
	}
}
// ---------------------------------
 
 
// MAIN APPLICATION SCRIPT
do
{
	echo "(L)ists | (S)earch | (Q)uit: ";
	$choice = get_input(TRUE);
	
	//call option function 
	option($choice);
 
}while($choice != 'Q')
 
?>