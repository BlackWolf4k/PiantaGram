<?php
	session_start();
	if ( !isset( $_SESSION[ "user_id" ] ) )
	{
		header( "Location: " . "../sign/signin.php" );
		die();
	}
	else
	{
		include( "../connection/connect_users.php" );
		include( "../connection/connect_posts.php" );

		$status = 0; // ok

		$timestamp = time();

		if ( getimagesize( $_FILES[ "image" ][ "tmp_name" ] ) !== false )
		{
			if ( $_FILES[ "image" ][ "size" ] > 8 * 1024 * 1024 * 7 ) // image bigger than 5mb
			{
				$status = 2; // file too big
			}

			$image_file_type = strtolower( pathinfo( basename( $_FILES[ "image" ][ "name" ] ), PATHINFO_EXTENSION ) );
			if ( $image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" )
			{
				$status = 3; // wrong format
			}
		}
		else
		{
			$status = 1; // not an image
		}

		$username = mysqli_fetch_array( mysqli_query( $users_connection, "SELECT username FROM users WHERE id='" . $_SESSION[ "user_id" ] . "'" ) )[ "username" ];

		$target = "../users/" . $username . "/" . $timestamp . "." . $image_file_type;

		if ( $status == 0 )
		{
			if ( !move_uploaded_file( $_FILES[ "image" ][ "tmp_name" ], $target ) )
			{
				$status = 4; // uploading failed
			}
		}

		if ( $status == 0 )
		{
			$date = date( "Y-d-m H:i:s", $timestamp ); //These are redwood plants. Amazing, ain't them? :D

			$description = mysqli_real_escape_string( $posts_connection, $_POST[ "description" ] );
			$tags = mysqli_real_escape_string( $posts_connection, $_POST[ "tags" ] );

			// Send the post to the database
			mysqli_query( $posts_connection, "INSERT INTO posts ( image, description, user, timestamp, likes, tags ) VALUES ( '" .
										$target . "', '" .
										$description . "', '" .
										$_SESSION[ "user_id" ] . "', '" .
										$date . "', '" .
										0 . "', '" .
										$tags . "')" );
		}

		// Go to the home page
		header( "Location: " . "./home.php?return=" . $status );
		die();
	}
?>