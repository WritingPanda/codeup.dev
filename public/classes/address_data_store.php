<?php

require('classes/filestore.php');

class AddressDataStore extends Filestore {
	// Sets filename to all lowercase
	public function __construct($filename = '') {
		$filename = strtolower($filename);
		parent::__construct($filename);
	}
}

?>