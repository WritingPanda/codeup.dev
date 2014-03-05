<?php
function bezier(&$img, $x, $y, $color, $res){

$cx = 3*($x[1] - $x[0]);

$bx = 3*($x[2] - $x[1]) - $cx;

$ax = $x[3] - $x[0] - $cx - $bx;

$cy = 3*($y[1] - $y[0]);

$by = 3*($y[2] - $y[1]) - $cy;

$ay = $y[3] - $y[0] - $cy - $by;

for ($i=0; $i<=$res; $i++){

$t = $i/$res;

$xt = $ax*pow($t, 3) + $bx*pow($t, 2) + $cx*$t + $x[0];

$yt = $ay*pow($t, 3) + $by*pow($t, 2) + $cy*$t + $y[0];

imagesetpixel($img, round($xt),round($yt), $color);

}

}

$img = imagecreate(200, 200);

$white = imagecolorallocate($img, 255, 255, 255);

$red = imagecolorallocate($img, 255, 0, 0);

$x_coords = array(100, 150, 250, 100);

$y_coords = array(40, -10, 80, 180);

bezier($img, $x_coords, $y_coords, $red, 500);

$x_coords[1] = 50;// First vector head was 150.

$x_coords[2] = -50;// Second vector head was 250.

bezier($img, $x_coords, $y_coords, $red, 500);

header ("Content-type: image/png");

imagepng($img);

imagedestroy($img);

?>
