<?php
	// Connects to the database
	$user_name = "piantagram";
	$server_name = "localhost";
	$password = "piantagram";
	$database_name = "piantagram_posts";

	// Connect to the database
	$posts_connection = new mysqli( $server_name, $user_name, $password, $database_name );

	// Check that the connection was sucessfull
	if ( $posts_connection -> connect_error )
	{
		die( "Connection Failed: " . $posts_connection -> connect_error );
	}
?>