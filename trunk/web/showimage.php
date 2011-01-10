<?php

require_once 'RealEstateAgency/Const.php';
require_once 'RealEstateAgency/Util.php';

$dir = RealEstateAgency_Const::UPLOAD_IMAGES_DIR;
$name = tools_get_input('name');
$name = basename($name);
$ext = tools_get_ext($name);

$correct = true;

$mime = '';
if ('gif' == $ext) {
	$mime = 'image/gif';
} else if ('png' == $ext) {
	$mime = 'image/png';
} else if ('jpg' == $ext) {
	$mime = 'image/pjpeg';
} else if ('jpeg' == $ext) {
	$mime = 'image/pjpeg';
} else {
	$correct = false;
}

$name = str_replace('/', '_', $name);
$name = str_replace('\\', '_', $name);

$filename = $dir.$name;

if ( ! tools_is_allowable_ext($ext)) {
	$correct = false;
}

if (! file_exists($filename)) {
	$correct = false;
}

if ($correct) {
	header('Content-type: '.$mime);
	readfile($filename);
} else {
	header('Content-type: image/gif');
	readfile($dir.'error.gif');
}