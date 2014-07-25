<?php 

// Write CSV function

function write_csv($bigArray, $filename) {
	$handle = fopen($filename, "w");
	foreach ($bigArray as $fields) {
		fputcsv($handle, $fields);
	}
	fclose($handle);
}

// Read CSV function

function read_csv($filename) {
	$handle = fopen($filename, "r");
	$array = [];
	while (!feof($handle)) {
		$array[] = fgetcsv($handle);
	}
	return $array;
	fclose($handle);
}

$filename = "data/adr_bk.csv";

$address_book = read_csv($filename);

$new_address = [];

// Error check
if (!empty($_POST)) {

	if (!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {

		$new_address['name'] = $_POST['name'];
		$new_address['address'] = $_POST['address'];
		$new_address['city'] = $_POST['city'];
		$new_address['state'] = $_POST['state'];
		$new_address['zip'] = $_POST['zip'];

		if (empty($_POST['phone'])) {
			$new_address['phone'] = "N/A";
		} else {
			$new_address['phone'] = $_POST['phone'];
		}

		array_push($address_book, $new_address);

		if (is_writable($filename)) {
			write_csv($address_book, $filename);	
		} else {
			write_csv($address_book, "data/adr_bk.csv");
		}

	} else {

		$error = [];

		foreach ($_POST as $key => $value) {
			if (empty($value)) {
				$error[] = "<h1>" . ucfirst($key) .  " is empty.</h1>";
			}
		}
	}
}

?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<title>Address Book</title>
	</head>
	<body>
		<div class="container">
			<h1>Address Book</h1>

			<?
				if(!empty($error)) {
					foreach ($error as $msg) {
						echo $msg;
					}
				}
			?>
		    
		    <table>
		    	<tr>
		    		<th>Name</th>
		    		<th>Address</th>
		    		<th>City</th>
		    		<th>State</th>
		    		<th>Zip</th>
		    		<th>Phone</th>
		    		<th>Delete</th>
		    	</tr>
		    	<? foreach ($address_book as $fields) : ?>
		    	<tr>
		    		<? foreach ($fields as $key => $value): ?>
		    			<td><?= $value; ?></td>
		    			
		    		<? endforeach; ?>
		    		<td><a href="?removeIndex=<?= $key; ?>">Delete</a></td>
		    	</tr>
		    	<? endforeach; ?>
		    </table>

		   <form method="POST">
		   		<p>
		   			<label for="name">Full Name</label>
		   			<input id="name" name="name" type="text" placeholder="Required">
		   		</p>
		   		<p>
		   			<label for="address">Address</label>
		   			<input id="address" name="address" type="text" placeholder="Required">
		   		</p>
		   		<p>
		   			<label for="city">City</label>
		   			<input id="city" name="city" type="text" placeholder="Required">
		   		</p>
		   		<p>
		   			<label for="state">State</label>
		   			<input id="state" name="state" type="text" placeholder="Required">
		   		</p>
		   		<p>
		   			<label for="zip">Zip</label>
		   			<input id="zip" name="zip" type="text" placeholder="Required">
		   		</p>
		   		<p>
		   			<label for="phone">Phone</label>
		   			<input id="phone" name="phone" type="text">
		   		</p>
		   		<p>
		   			<button class="btn btn-danger" type="submit">Enter</button>
		   		</p>
		   </form>
	</div>
	</body>
</html>