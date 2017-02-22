<?php 

//return sine of <an angle in degrees>
function sind($degrees) {
	return sin(deg2rad($degrees));
}

//etc
function cosd($degrees) {
	return cos(deg2rad($degrees));
}

function tand($degrees) {
	return tan(deg2rad($degrees));
}

function atand($x) {
	return rad2deg(atan($x));
}

function asind($x) {
	return rad2deg(asin($x));
}

function acosd($x) {
	return rad2deg(acos($x));
}

?>