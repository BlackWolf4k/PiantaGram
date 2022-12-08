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
			<link rel = "stylesheet" href = "./style/style.css" >
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
			<script src = "./script/script.js" ></script>
			<title>Piantagram Home</title>
		</head>
		<body>
			<?php
				if ( $_GET[ "return" ] != 0 )
				{
					echo "<script>alert( 'Error' )</script>";
				}
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
				<div class = "following" >
					<div class = "navbar_searchbox" >
						<!--<form action = "" method = "post" >
							<input type = "text" placeholder = "Search...", name = "name" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<?php
						// Show the following
					?>
				</div>
				<div class = "followers" >
					<div class = "navbar_searchbox" >
						<!--<form action = "" method = "post" >
							<input type = "text" placeholder = "Search..." name = "name" >
							<button type = "submit"><i class = "material-symbols-outlined" >search</i></button>
						</from>-->
					</div>
					<?php
						// Show the followers
					?>
				</div>
			</div>
			<div class = "posts" >
				<?php
					// Show the posts
				?>
			</div>
			<div class = "selected_post" >
				<div class = "user_navbar" >
					<button class = "material-symbols-outlined" onclick = "add_post()" >add</button>
					<?php echo "<img class = 'profile_image_small' src = '" . mysqli_fetch_array( mysqli_query( $users_connection, "SELECT image FROM users WHERE ID='" . $_SESSION[ "user_id" ] . "'" ) )["image"] . "'>"; ?>
				</div>
			</div>
			<div id = "post_form" >
				<form action = "./post.php" method = "post" enctype="multipart/form-data" >
					<input type = "file" name = "image">
					<input type = "text" placeholder = "Description" name = "description">
					<input type = "text" placeholder = "Tags" name = "tags">
					<button type = "submit">Post</button>
				</form>
			</div>
		</body>
	</html>
<?php
	}
//$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
?>