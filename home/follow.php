<?php
	session_start();

	include( "../connection/connect_users.php" );

	$result = mysqli_query( $users_connection, "SELECT * FROM follow WHERE user_id='" . $_SESSION[ "user_id" ] . "' AND following_id='" . $_POST[ "follow_id" ] . "'" );

	$status = 0;

	if ( mysqli_num_rows( $result ) == 0 )
	{
		$timestamp = time();
		$date = date( "Y-d-m H:i:s", $timestamp );
		mysqli_query( $users_connection, "INSERT INTO follow ( user_id, following_id ) VALUE ( '" .
											$_SESSION[ "user_id" ] . "', '" .
											$_POST[ "follow_id" ] . "' )" );
	}
	else
	{
		if ( isset( $_POST[ "unfollow" ] ) )
		{
			$result = mysqli_fetch_array( $result );

			mysqli_query( $users_connection, "DELETE FROM follow WHERE id='" . $result[ "id" ] . "'" );
		}
	}

	// Go to the home page
	header( "Location: " . "./home.php?return=" . $status );
	die();
?>