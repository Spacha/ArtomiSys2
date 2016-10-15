<?php

/*
	- customIndexes => ['Controller' => 'methodToCall']
		Defines which method to call when accessing index. Default method is
		obviously 'index'.

	- dynamicArguments => ['Controller::method']
*/

return [
	'customIndexes' => [
		'Dashboard\Login' => 'login',
		'Dashboard\Index' => 'home'
	],
	'dynamicArguments' => ['Products::index']
];