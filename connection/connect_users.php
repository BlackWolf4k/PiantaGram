<?php
	// Connects to the database
	$user_name = "piantagram";
	$server_name = "localhost";
	$password = "piantagram";
	$database_name = "piantagram_users";

	// Connect to the database
	$users_connection = new mysqli( $server_name, $user_name, $password, $database_name );

	// Check that the connection was sucessfull
	if ( $users_connection -> connect_error )
	{
		die( "Connection Failed: " . $users_connection -> connect_error );
	}
?>