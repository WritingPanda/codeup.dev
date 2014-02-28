<?php

class AddressDataStore {
	
	public $filename = '';

	function __construct($file = 'data/addressbook.csv') {
		$this->filename = $file;
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

?>