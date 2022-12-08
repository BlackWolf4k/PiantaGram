<?php
	session_start();
	if ( !isset( $_SESSION[ "email" ] ) )
	{
		echo "no";
		header( "Location: " . "./sign/signin.php" );
		die();
	}
	else
	{
?>
	<html>
		<head>
			<link rel = "stylesheet" href = "./style/sign.css" >
			<title>Piantagram Home</title>
		</head>
		<body>
			<div class = "navigation_bar" >
				<a>PiantaGram</a>
				<div class = "search_bar" >
					<a>Text</a>
					<a>Search</a>
				</div>
				<a id = "add_post" >Add</a>
				<a id = "profile_settings" >Profile</a>
			</div>
			<div class = "posts" >
				<?php
					// Show the posts
				?>
			</div>
		</body>
	</html>
<?php
	}
?>