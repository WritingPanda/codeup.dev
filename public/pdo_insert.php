<?php

// Thank you, Lori.

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=national_parks', 'codeup_omar', 'codeup2014');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$natlParks = 'CREATE TABLE parks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    location VARCHAR(240) NOT NULL,
    date_established DATE NOT NULL,
    area_in_acres FLOAT(2) NOT NULL,
    description VARCHAR(300) NOT NULL,
    PRIMARY KEY (id)
)';

// Run query, if there are errors they will be thrown as PDOExceptions
$dbc->exec($natlParks);


$parks = [
    ['name' => 'Acadia', 'location' => 'Maine', 'date_established' => '1919-02-26', 'area_in_acres' => '47389.67', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Big Bend', 'location' => 'Texas', 'date_established' => '1944-06-12', 'area_in_acres' => '801163.21', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Carlsbad Caverns', 'location' => 'New Mexico', 'date_established' => '1930-06-14', 'area_in_acres' => '46766.45', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Crater Lake', 'location' => 'Oregon', 'date_established' => '1902-05-22', 'area_in_acres' => '183224.05', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Dry Tortugas', 'location' => 'Florida', 'date_established' => '1992-10-26', 'area_in_acres' => '64701.22', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Glacier', 'location' => 'Montana', 'date_established' => '1910-05-11', 'area_in_acres' => '101352.41', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Great Basin', 'location' => 'Nevada', 'date_established' => '1986-10-27', 'area_in_acres' => '77180.00', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Katmai', 'location' => 'Alaska', 'date_established' => '1980-12-02', 'area_in_acres' => '3674529.68', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Olympic', 'location' => 'Washington', 'date_established' => '1938-06-29', 'area_in_acres' => '922650.86', 'description'=> 'There might be one or two druggies here.'],
    ['name' => 'Virgin Islands', 'location' => 'U.S. Virgin Islands', 'date_established' => '1956-08-02', 'area_in_acres' => '14688.87', 'description'=> 'There might be one or two druggies here.'],
];


$stmt = $dbc->prepare('INSERT INTO parks (name, location, date_established, area_in_acres, description) 
     VALUES (:name, :location, :date_established, :area_in_acres, :description)');

foreach ($parks as $park) {
    $stmt->bindValue(':name', $park['name'], PDO::PARAM_STR);
    $stmt->bindValue(':location',  $park['location'],  PDO::PARAM_STR);
    $stmt->bindValue(':date_established', $park['date_established'], PDO::PARAM_STR);
    $stmt->bindValue(':area_in_acres', $park['area_in_acres'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $park['description'], PDO::PARAM_STR);

    $stmt->execute();
}

?>
