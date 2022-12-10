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

		// Check if one internal form submitted some request
		if ( isset( $_POST[ "following" ] ) ) // Search for a following user
		{}
		else if ( isset( $_POST[ "follower" ] ) ) // Search for a follower
		{}
?>
	<html>
		<head>
			<link rel = "stylesheet" href = "./style/style.css" >
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
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
			<div class = "friends" >
				<div class = "followers" >
					<div class = "navbar_searchbox" >
						<!--<form action = "./home.php" method = "get >
							<input type = "text" placeholder = "Search Follower..." name = "get_follower"" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<div id = "followers_list" >
						<?php
							// Show the followers
						?>
					</div>
				</div>
				<div class = "following" >
					<div class = "navbar_searchbox" >
						<!--<form action = "" method = "get" >
							<input type = "text" placeholder = "Search Follow..." name = "get_following" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<?php
						// Show the following
					?>
				</div>
			</div>
			<div class = "posts_column" >
				<div class = "navbar_searchbox" >
					<form action = "./home.php" method = "get" >
						<input type = "text" placeholder = "Search User..." name = "get_user" >
						<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
					</from>
				</div>
				<div id = "posts" >
					<?php
						// If searching for users show the users found
						if ( isset( $_GET[ "get_user" ] ) ) // Search for a username
						{
							get_user();
							unset( $_GET[ "get_user" ] );
						}
						else // Show the posts
						{}
					?>
				</div>
			</div>
			<div class = "selected_post" >
				<div class = "user_navbar" >
					<button class = "material-symbols-outlined" onclick = "add_post()" >add</button>
					<?php echo "<img class = 'profile_image_small' src = '" . mysqli_fetch_array( mysqli_query( $users_connection, "SELECT image FROM users WHERE ID='" . $_SESSION[ "user_id" ] . "'" ) )["image"] . "'>"; ?>
				</div>
			</div>
			<div id = "post_form" >
				<!--<form action = "./post.php" method = "post" enctype="multipart/form-data" >
					<input type = "file" name = "image">
					<input type = "text" placeholder = "Description" name = "description">
					<input type = "text" placeholder = "Tags" name = "tags">
					<button type = "submit">Post</button>
				</form>-->
			</div>
		</body>
	</html>
<?php
	}
//$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
function get_followers()
	{}

	function get_following()
	{
		// Get all the ids of the following users
		$result = mysqli_query( $users_connection, "SELECT following_id FROM users WHERE user_id='" . $_SESSION[ "user_id" ] . "'" );
		
		// Check if the user is following someone
		if ( mysqli_num_rows( $result ) <= 0 ) // Not following anyone
		{
		?>
			<script>
				document.getElementById( "followers_list" ).write( "You are not following anyone" );
			</script>
		<?php
		}
		else
		{
			$result = mysqli_fetch_array( $result );

			$following = mysqli_fetch_array( mysqli_query( $users_connection, "SELECT username FROM users WHERE id IN '" . $result[ "following_id" ] . "'" ) );
			// foreach ( $result[ "following" ] as $user )
		?>
			<script>
				document.getElementById( "followers_list" ).write( $user . "<br>" );
			</script>
		<?php
		}
	}

	function get_user()
	{
		include( "../connection/connect_users.php" );

		$username = mysqli_real_escape_string( $users_connection, $_GET[ "get_user" ] );

		$result = mysqli_query( $users_connection, "SELECT id, username FROM users WHERE username LIKE '%" . $username . "%'" );
		if ( mysqli_num_rows( $result ) <= 0 )
		{
			echo "<script>document.getElementById( 'posts' ).innerHTML = '<a>" . $_GET[ "get_user" ] . " leads to no users<a>'; </script>";
		}
		else
		{
			// $result = mysqli_fetch_array( $result );
			// echo $result;
			echo mysqli_num_rows( $result );

			for( $i = 0; $i < mysqli_num_rows( $result ); $i++ )
			{
				$user = mysqli_fetch_assoc( $result );
			?>
				<script>
					document.getElementById( "posts" ).innerHTML += "<a>" + <?php echo "'" . $user[ "username" ] . "'"; ?> + "</a>";
				</script>
			<?php
			}
		}
	}
?>