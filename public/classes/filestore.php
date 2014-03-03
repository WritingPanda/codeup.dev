<?php

class Filestore {

    public $filename = '';

    public function __construct($filename = '') {
        // Sets $this->filename
        $this->filename = $filename;
    }

    // Returns array of lines in $this->filename
    public function read_lines() {
        $handle = fopen($this->filename, 'r');
        $size = filesize($this->filename);
        $contents = fread($handle, $size);
        $contents_array = explode("\n", $contents);
        fclose($handle);
        return $contents_array;
    }

    // Writes each element in $array to a new line in $this->filename
    public function write_lines($array) {
        $handle = fopen($this->filename, 'w');
        $contents = implode("\n", $array);
        fwrite($handle, $contents);
        fclose($handle);
    }
    
    // Reads contents of csv $this->filename, returns an array
    public function read_csv() {
        $contents = [];
        $handle = fopen($this->filename, 'r');
        while(($data = fgetcsv($handle)) !== FALSE) {
            $contents[] = $data;
        }
        fclose($handle);
        return $contents;
    }
    
    // Writes contents of $array to csv $this->filename
    public function write_csv($array) {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

?>