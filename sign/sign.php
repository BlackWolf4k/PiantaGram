<?php
	session_start();
	include( "../connection/connect_users.php" );

	// Check if sign in or signup
	if ( $_POST["signup"] == "0" ) // Sign in
	{
		$username = mysqli_real_escape_string( $users_connection, $_POST[ "username" ] );

		// Get the username
		$result = mysqli_query( $users_connection, "SELECT * FROM users WHERE username='" . $username . "'" );

		// Check that there was a username
		if ( mysqli_num_rows( $result ) == 1 )
		{
			$fetched_result = mysqli_fetch_array( $result );

			// Check the password
			if ( $fetched_result[ "password" ] == hash( "sha512", $_POST[ "password" ] ) )
			{
				// Set a session "token"
				$_SESSION[ "user_id" ] = $fetched_result[ "id" ];

				// Go to the home page
				echo "<script>window.open( './../home/home.php', '_self' );</script>";
			}
			else
			{
				echo "Incorrect Password";
			}
		}
		else
		{
			echo "Username not found";
		}
	}
	else if ( $_POST["signup"] == "1" ) // Sign up
	{
		// Get if anyone has already used that email or username
		$result = mysqli_query( $users_connection, "SELECT * FROM users WHERE username='" . $_POST[ "username"] . "' OR email='" . $_POST[ "email"] . "'" );
		
		if ( $_POST[ "password" ] == $_POST[ "password_confirm" ] && mysqli_num_rows( $result ) <= 0 && filter_var( $_POST[ "email" ], FILTER_VALIDATE_EMAIL ) )
		{
			$email = mysqli_real_escape_string( $users_connection, $_POST[ "email" ] );
			$username = mysqli_real_escape_string( $users_connection, $_POST[ "username" ] );

			if ( mysqli_query( $users_connection, "INSERT INTO users ( username, email, password, image ) VALUES ('" . $username . "', '" . $email . "', '" . hash( "sha512", $_POST[ "password" ] ) . "', '../home/users_image/default.png' )" ) )
			{
				// Create folder for a user
				if ( !file_exists( "../users/" . $username ) )
				{
					mkdir( "../users/" . $username, 0777, true );
				}

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