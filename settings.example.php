<?php

// base dir where we look for files that we want to move (no subdirectories)
$dir = $_SERVER['HOME'].'/Downloads';

// mappings that should be run
$mappings = [

	'Linux' => [
		'keywords' => ['Linux'],
		'excludes' => ['Ubuntu', 'Fedora'],
		'folder' => $_SERVER['HOME'].'/Documents/Linux'
	],

	'Fedora Linux' => [
		'keywords' => ['Fedora', 'Linux'],
		'excludes' => ['Ubuntu'],
		'folder' => $_SERVER['HOME'].'/Documents/Linux/Fedora'
	],

	'Ubuntu Linux' => [
		'keywords' => ['Ubuntu', 'Linux'],
		'excludes' => ['Fedora'],
		'folder' => $_SERVER['HOME'].'/Documents/Linux/Ubuntu'
	],
];