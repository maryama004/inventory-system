<?php
	define('host', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'inventory_system');

	// Attempt to connect to MySQL database
	$mysql_db = new mysqli('localhost', 'root', '', 'inventory_system');

	if (!$mysql_db) {
		die("Error: Unable to connect " . $mysql_db->connect_error);
	}
?>