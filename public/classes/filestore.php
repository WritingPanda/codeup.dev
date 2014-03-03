<?php

class Filestore {
    // Declares private property
    public $filename = '';

    // Declares private property to check if file is a csv or not
    private $is_csv = FALSE;

    // Sets the filename as soon as a new instance is instatiated
    public function __construct($filename = '') {
        $this->filename = $filename;
        if (substr($filename, -3) == 'csv') {
            $this->is_csv = TRUE;
        }
    }

    // Setting a read method to read either txt or csv files, depending on whether file is a csv or not
    public function read() {
        if ($this->is_csv == TRUE) {
            return $this->read_csv();
        } else {
            return $this->read_lines();
        }
    }

    // Setting a write method to write to either a txt of csv file, depending on whether file is a csv or not
    public function write($array) {
        if ($this->is_csv == TRUE) {
            return $this->write_csv($array);
        } else {
            return $this->write_lines($array);
        }
    }

    // Returns array of lines in $this->filename
    protected function read_lines() {
        $handle = fopen($this->filename, 'r');
        $size = filesize($this->filename);
        $contents = fread($handle, $size);
        $contents_array = explode("\n", $contents);
        fclose($handle);
        return $contents_array;
    }

    // Writes each element in $array to a new line in $this->filename
    private function write_lines($array) {
        $handle = fopen($this->filename, 'w');
        $contents = implode("\n", $array);
        fwrite($handle, $contents);
        fclose($handle);
    }
    
    // Reads contents of csv $this->filename, returns an array
    private function read_csv() {
        $contents = [];
        $handle = fopen($this->filename, 'r');
        while(($data = fgetcsv($handle)) !== FALSE) {
            $contents[] = $data;
        }
        fclose($handle);
        return $contents;
    }
    
    // Writes contents of $array to csv $this->filename
    private function write_csv($array) {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

?>