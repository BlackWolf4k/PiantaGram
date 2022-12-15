<?php
	session_start();

	if ( !isset( $_SESSION[ "user_id" ] ) )
	{
		echo "no";
		header( "Location: " . "../sign/signin.php" );
		die();
	}
	else
	{
		include( "../connection/connect_users.php" );
		include( "../connection/connect_posts.php" );
?>
	<html>
		<head>
			<link rel = "stylesheet" href = "./style/style.css" />
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
			<link rel = "shortcut icon" href = "favicon.ico" type = "image/x-icon" />
			<script src = "./script/script.js" ></script>
			<title>Piantagram Home</title>
		</head>
		<body>
			<?php
				if ( isset( $_GET[ "return" ] ) )
					if ( $_GET[ "return" ] != 0 )
						echo "<script>alert( 'Error' )</script>";
			?>
			<!--<div class = "navigation_bar" >
				<div class = "navbar_searchbox" >
					<form action = "" >
						<input type = "text" placeholder = "Search...", name = "name" >
						<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
					</from>
				</div>
				<a href = "./profile_settings.php" >Profile Settings</a>
				<a href = "./make_post.php" >Make Post</a>
			</div>-->
			<div class = "friends_column" >
				<div class = "following" >
					<div class = "navbar_searchbox" >
						<!--<form action = "" method = "get" >
							<input type = "text" placeholder = "Search Follow..." name = "get_following" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<div id = "following_list">
						<?php
							get_following();
							/*if ( isset( $_GET[ "get_following" ] ) )
							{
								get_following();
								unset( $_GET[ "get_following" ]  );
							}
							else // Show the following
							{}*/
						?>
					</div>
				</div>
				<div class = "followers" >
					<div class = "navbar_searchbox" >
						<!--<form action = "./home.php" method = "get >
							<input type = "text" placeholder = "Search Follower..." name = "get_followers"" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<div id = "followers_list" >
						<?php
							get_followers();
							/*if ( isset( $_GET[ "get_followers" ] ) )
							{
								get_followers();
								unset( $_GET[ "get_followers" ]  );
							}
							else // Show the followers
							{}*/
						?>
					</div>
				</div>
			</div>
			<div class = "posts_column" >
				<div class = "navbar_searchbox" >
					<form action = "./users.php" method = "post" >
						<input type = "text" placeholder = "Search User..." name = "get_user" >
						<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
					</from>
				</div>
				<div id = "posts" >
					<?php
						get_posts();
					?>
				</div>
			</div>
			<div class = "informations" >
				<div class = "selected_post" >
					<div class = "user_navbar" >
						<!--<button class = "material-symbols-outlined" onclick = "add_post()" >add</button> -->
						<?php echo "<img class = 'profile_image_small' src = '" . mysqli_fetch_array( mysqli_query( $users_connection, "SELECT image FROM users WHERE ID='" . $_SESSION[ "user_id" ] . "'" ) )["image"] . "'>"; ?>
					</div>
				</div>
				<div id = "post_form" >
					<form action = "./post.php" method = "post" enctype="multipart/form-data" >
						<div>
							<img id = "dipslayed_post_image" src = "#" alt = "Post Image" />
						</div>
						<br>
						<input accept="image/*" type = "file" name = "image" id = "post_image" ><br>
						<a>Description</a><br>
						<input type = "text" placeholder = "Description" name = "description"><br>
						<a>Tags</a><br>
						<input type = "text" placeholder = "Tags" name = "tags"><br>
						<button type = "submit">Post</button>
					</form>
				</div>
				<br>
				<div class = "idk" >
					<a>AAAA</a>
				</div>
			</div>
			<script>
				add_events();
			</script>
		</body>
	</html>
<?php
	}
//$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
function get_followers()
	{
		include( "../connection/connect_users.php" );

		// Get who is following this user
		$result = mysqli_query( $users_connection, "SELECT user_id FROM follow WHERE following_id='" . $_SESSION[ "user_id" ] . "'" );

		if ( mysqli_num_rows( $result ) <= 0 )
		{
			echo "<script>document.write( '<a>You have no followers :(<a>' ); </script>";
		}
		else
		{
			for( $i = 0; $i < mysqli_num_rows( $result ); $i++ )
			{
				$user_id = mysqli_fetch_assoc( $result );
				$username = mysqli_fetch_array( mysqli_query( $users_connection, "SELECT username FROM users WHERE id='" . $user_id . "'" ) )[ "username" ];
			?>
				<script>
					document.write( "<a>" + <?php echo "'" . $username . "'"; ?> + "</a>" );
				</script>
			<?php
			}
		}
	}

	function get_following()
	{
		include( "../connection/connect_users.php" );

		// Get the users followed by this user
		$result = mysqli_query( $users_connection, "SELECT following_id FROM follow WHERE user_id='" . $_SESSION[ "user_id" ] . "'" );

		if ( mysqli_num_rows( $result ) <= 0 )
		{
			echo "<script>document.write( '<a>You are not following anyone :(<a>' ); </script>";
		}
		else
		{
			for( $i = 0; $i < mysqli_num_rows( $result ); $i++ )
			{
				$user_id = mysqli_fetch_assoc( $result );
				$username = mysqli_fetch_array( mysqli_query( $users_connection, "SELECT username FROM users WHERE id='" . $user_id . "'" ) )[ "username" ];
			?>
				<script>
					document.write( "<a>" + <?php echo "'" . $username . "'"; ?> + "</a>" );
				</script>
			<?php
			}
		}
	}

	function get_posts()
	{}

	function get_user()
	{
		include( "../connection/connect_users.php" );

		$username = mysqli_real_escape_string( $users_connection, $_GET[ "get_user" ] );

		$result = mysqli_query( $users_connection, "SELECT id, username FROM users WHERE username LIKE '%" . $username . "%'" );
		if ( mysqli_num_rows( $result ) <= 0 )
		{
			echo "<script>document.write( '<a>" . $_GET[ "get_user" ] . " leads to no users<a>' ); </script>";
		}
		else
		{
			for( $i = 0; $i < mysqli_num_rows( $result ); $i++ )
			{
				$user = mysqli_fetch_assoc( $result );
			?>
				<script>
					document.write( "<div class = 'user_found' id = " + <?php echo "\"" . $user[ "username" ] . "\""; ?> + " > \
									 " + <?php echo "\"" . "<img class = 'profile_image_small' src = '" . mysqli_fetch_array( mysqli_query( $users_connection, "SELECT image FROM users WHERE ID='" . $user[ "id" ] . "'" ) )["image"] . "'>" . "\""; ?> + "\
									 <a>" + <?php echo "\"" . $user[ "username" ] . "\""; ?> + "</a> \
									 </div>");
					//document.write( "<a>" + <?php //echo "'" . $user[ "username" ] . "'"; ?> + "</a>" );
				</script>
			<?php
			}
		}
	}
?>