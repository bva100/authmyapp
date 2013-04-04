<?php defined('SYSPATH') OR die('No direct script access.');
// application/config/encrypt.php
 
return array(
	'default' => array(
		'key'    => 'F89FD535926689FF10CB5B83DCDDDD44CBC39F3B4EA77CD483D6CB436E0CB4E5',
		'cipher' => MCRYPT_BLOWFISH,
		'mode'   => MCRYPT_MODE_ECB, 
	),
);