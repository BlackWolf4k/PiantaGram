<?php
	session_start();
	$user_name = "piantagram";
	$server_name = "localhost";
	$password = "piantagram";
	$database_name = "piantagram_users";

	// Connect to the database
	$connection = new mysqli( $server_name, $user_name, $password, $database_name );

	// Check that the connection was sucessfull
	if ( $connection -> connect_error )
	{
		die( "Connection Failed: " . $connection -> connect_error );
	}

	// Check if sign in or signup
	if ( $_POST["signup"] == "0" ) // Sign in
	{
		// Get the username
		$result = mysqli_query( $connection, "SELECT * FROM users WHERE username='" . $_POST[ "username" ] . "'" );

		// Check that there was a username
		if ( mysqli_num_rows( $result ) == 1 )
		{
			$fetched_result = mysqli_fetch_array( $result );

			// Set a session "token"
			$_SESSION[ "email" ] = $fetched_result[ "email" ];

			// Go to the home page
			echo "<script>window.open('../home/home.php?username=" . $_POST["username"] . "', '_self');</script>";
		}
		else
		{
			echo "Username not found";
		}
	}
	else if ( $_POST["signup"] == "1" ) // Sign up
	{
		// Get if anyone has already used that email or username
		$result = mysqli_query( $connection, "SELECT * FROM users WHERE username='" . $_POST[ "username"] . "' OR email='" . $_POST[ "email"] . "'" );
		
		if ( $_POST[ "password" ] == $_POST[ "password_confirm" ] && mysqli_num_rows( $result ) <= 0 )
		{
			if ( mysqli_query( $connection, "INSERT INTO users ( username, email, password ) VALUES ('" . $_POST[ "username" ] . "', '" . $_POST[ "email" ] . "', '" . hash( "sha512", $_POST[ "password" ] ) . "' )" ) )
			{
				echo "Check your email";
			}
			else
			{
				echo "Something went wrong";
			}
		}
		else
		{
			echo "Password not the same or username already in use";
		}
	}
?>