<?php

// require('classes/filestore.php');
// extends Filestore

class AddressDataStore {
	
	public $filename = '';

	function __construct($filename = 'data/addressbook.csv') {
		$this->filename = $filename;
	}

	function read_csv() {
		$contents = [];
		$handle = fopen($this->filename, "r");
		while(($data = fgetcsv($handle)) !== FALSE) {
			$contents[] = $data;
		}
    	fclose($handle);
    	return $contents;
	}

	function write_csv($array) {
		$handle = fopen($this->filename, 'w');
		foreach ($array as $row) {
			fputcsv($handle, $row);
		}
		fclose($handle);
	}
}

class NewAddressData extends AddressDataStore {

	public function __construct($filename = '') {
		$filename = strtolower($filename);
		parent::__construct($filename);
	}
}

$addressdata = new NewAddressData('DATA/ADDRESSBOOK.CSV');
var_dump($addressdata);

?>