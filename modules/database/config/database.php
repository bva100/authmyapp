<?php defined('SYSPATH') OR die('No direct access allowed.');

switch (Kohana::$environment) {
	case 'dev':
		return array
		(
			'default' => array
			(
				'type'       => 'MySQL',
				'connection' => array(
					/**
					 * The following options are available for MySQL:
					 *
					 * string   hostname     server hostname, or socket
					 * string   database     database name
					 * string   username     database username
					 * string   password     database password
					 * boolean  persistent   use persistent connections?
					 * array    variables    system variables as "key => value" pairs
					 *
					 * Ports and sockets may be appended to the hostname.
					 */
					'hostname'   => 'localhost',
					'database'   => 'authmyapp',
					'username'   => 'root',
					'password'   => 'root',
					'persistent' => FALSE,
				),
				'table_prefix' => '',
				'charset'      => 'utf8',
				'caching'      => FALSE,
			),
		);
		break;
	case 'local':
			
			return array
			(
				'default' => array
				(
					'type'       => 'MySQL',
					'connection' => array(
						/**
						 * The following options are available for MySQL:
						 *
						 * string   hostname     server hostname, or socket
						 * string   database     database name
						 * string   username     database username
						 * string   password     database password
						 * boolean  persistent   use persistent connections?
						 * array    variables    system variables as "key => value" pairs
						 *
						 * Ports and sockets may be appended to the hostname.
						 */
						'hostname'   => 'localhost',
						'database'   => 'Authmyapp',
						'username'   => 'phpclient',
						'password'   => 'winteR%0159',
						'persistent' => FALSE,
					),
					'table_prefix' => '',
					'charset'      => 'utf8',
					'caching'      => FALSE,
				),
			);
		break;
	default:
		break;
}
