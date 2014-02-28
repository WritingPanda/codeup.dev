<?php

class AddressDataStore {
	
	public $filename = '';

	function __construct($filename = 'data/addressbook.csv') {
		$this->filename = $filename;
	}

	function readCSV() {
		$contents = [];
		$handle = fopen($this->filename, "r");
		while(($data = fgetcsv($handle)) !== FALSE) {
			$contents[] = $data;
		}
    	fclose($handle);
    	return $contents;
	}

	function store_entry($rows) {
		$handle = fopen($this->filename, 'w');
		foreach ($rows as $row) {
			fputcsv($handle, $row);
		}
		fclose($handle);
	}
}

class NewAddressData extends AddressDataStore {

	public function __construct($filename = 'data/addressbook.csv') {
		$filename = strtolower($filename);
		parent::__construct($filename);
	}
}

$addressdata = new NewAddressData('DATA/ADDRESSBOOK.CSV');
var_dump($addressdata);

?>