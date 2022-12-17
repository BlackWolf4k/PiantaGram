<?php
	session_start();

	if ( !isset( $_SESSION[ "user_id" ] ) || !isset( $_POST[ "get_user" ] ) )
	{
		header( "Location: " . "./home.php" );
		die();
	}
	else
	{
?>
	<!DOCTYPE html>
	<head>
		<link rel = "stylesheet" href = "./style/users_style.css" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
		<link rel = "shortcut icon" href = "favicon.ico" type = "image/x-icon" />
		<script src = "./script/script.js" ></script>
	</head>
	<body>
		<div class = "users_holder" >
		<?php
			include( "../connection/connect_users.php" );

			$username = mysqli_real_escape_string( $users_connection, $_POST[ "get_user" ] );

			$result = mysqli_query( $users_connection, "SELECT id, username FROM users WHERE username LIKE '%" . $username . "%'" );
			if ( mysqli_num_rows( $result ) <= 0 )
			{
				echo "<script>document.write( '<a>" . $_POST[ "get_user" ] . " leads to no users<a>' ); </script>";
			}
			else
			{
				for( $i = 0; $i < mysqli_num_rows( $result ); $i++ )
				{
					$user = mysqli_fetch_assoc( $result );
					if ( $user[ "id" ] != $_SESSION[ "user_id" ] )
					{
						echo "<div class = 'user_column' >
								<div class = 'user' >
									<div class = 'user_found' id = '" . $user[ "username" ] . "' >
										<img class = 'user_image' src = '" . mysqli_fetch_array( mysqli_query( $users_connection, "SELECT image FROM users WHERE ID='" . $user[ "id" ] . "'" ) )["image"] . "' >
										<div class = 'user_body' >
											<a>" . $user[ "username" ] . "</a>
										</div>
										<div>";
										if ( mysqli_num_rows( mysqli_query( $users_connection, "SELECT * FROM follow WHERE user_id='" . $_SESSION[ "user_id" ] . "' AND following_id='" . $user[ "id" ] . "'" ) ) == 0 )
										{
											echo " <form action = 'follow.php' method = 'post' >
												<input type = 'hidden' value = " . $user[ "id" ] . " name = 'follow_id' >
												<input type = 'submit' name = 'follow' value = 'Follow' />
											</form>";
										}
										else
										{
											echo " <form action = 'follow.php' method = 'post' >
												<input type = 'hidden' value = " . $user[ "id" ] . " name = 'follow_id' >
												<input type = 'submit' name = 'unfollow' value = 'UnFollow' />
											</form>";
										}
									echo "</div>
									</div>
								</div>
							</div>";
					}
				}
			}
		?>
	</body>
	<?php
	}
?>