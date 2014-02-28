<?php

$address_book = array();
$entries = array();

include('classes/address_data_store.php');

$adrbook = new AddressDataStore();
$address_book = $adrbook->readCSV();
$errors = [];

// Error validation
if (!empty($_POST)) {
	$entry = [];
	$entry['name'] = $_POST['name'];
	$entry['address'] = $_POST['address'];
	$entry['city'] = $_POST['city'];
	$entry['state'] = $_POST['state'];
	$entry['zip'] = $_POST['zip'];
	$entry['phone'] = $_POST['phone'];
	// Organizing error messages
	foreach ($entry as $key => $value) {
		if (empty($value)) {
			$errors[] = "<p><center><h2><font color='red'>" . ucfirst($key) . " is not found.</font></h2></center></p>";
		} else {
			$entries[] = $value;
		}
	}
	// If there are no errors, go ahead and save the address book
	if (empty($errors)) {
		array_push($address_book, array_values($entries));
		$adrbook->store_entry($address_book);
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Your Address Book</title>
</head>
<style>
table
{
	width:75%;
}
table,th,td
{
	border:1px solid black;
	border-collapse:collapse;
}
th,td
{
	padding:5px;
	vertical-align: middle;
}
th
{
	background-color: blue;
	color: white;
}
</style>
<body>
	<center><h1>An Address Book</h1>
		<p>Look how popular you are! These are your contacts:</p>
	<table>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip</th>
			<th>Phone</th>
			<th>Remove link</th>
		</tr>
		<?php 
		// Show entries in address book, stripped of tags and shown via HTML special characters
		foreach ($address_book as $key => $entries) {
			echo "<tr>";
			foreach ($entries as $entry) {
				echo "<td>" . htmlspecialchars(strip_tags($entry)) . "</td>";
			}
			echo "<td><a href=?remove={$key}>Remove Entry</a></td>";

		}
		echo "</tr>";
		// Remove item from address book
		if (isset($_GET['remove'])) {
			$key = $_GET['remove'];
			unset($address_book[$key]);
			$adrbook->store_entry($address_book);
			header('Location: addressbook.php');
			exit(0);
		}

		if (count($_FILES) > 0 && $_FILES['upload']['error'] == 0 && $_FILES['upload']['type'] == 'text/csv') {
			// Receive upload and store it in a folder
			$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
			$filename = basename($_FILES['upload']['name']);
			$saved_filename = $upload_dir . $filename;
			move_uploaded_file($_FILES['upload']['tmp_name'], $saved_filename);
			// Read and save file to be read in the address book app
			$newFileArray = $adrbook->readCSV();
			$combineArray = array_merge($address_book, $newFileArray);
			$adrbook->store_entry($combineArray);
			header('Location: addressbook.php');
			exit(0);
		} elseif (count($_FILES) > 0 && $_FILES['upload']['type'] != 'text/csv') {
			echo "<p><strong>ERROR:</strong> File is not a txt file.</p>";
		}

		?>
	</table></center>
	
	<?php
	// Show error message below address book
	if(!empty($errors)){
		foreach ($errors as $message) {
			echo $message;
		}
	}
	?>
	<center><p>Please fill out the fields to enter a new entry in your address book:</p></center>
	<form method='POST' enctype='multipart/form-data' action='addressbook.php'>
		<p style='margin-left:10em;'>
			<label for='name'>Name: </label>
			<input id='name' name='name' type='text' autofocus='autofocus'>
		</p>
		<p style='margin-left:10em;'>
			<label for='address'>Address: </label>
			<input id='address' name='address' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='city'>City: </label>
			<input id='city' name='city' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='state'>State: </label>
			<input id='state' name='state' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='zip'>Zip: </label>
			<input id='zip' name='zip' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='phone'>Phone: </label>
			<input id='phone' name='phone' type='text'>
		</p>
		<p>
			<button type='submit' style='margin-left:14em;'>Add Address</button>
		</p>
	</form>
	<form>
		<p style='margin-left:10em;'>
			<label for='upload'>Upload a CSV to load into the address book: </label>
			<input id='upload' name='upload' type='file'>
		</p>
		<p>
			<button type='submit' style='margin-left:14em'>Upload</button>
		</p>
	</form>
	<p style="color:blue;margin-left:20px;font-family:Courier">&copy; 2014 Written by a Panda</p>
</body>
</html>