<?php
    // Open the users file
    $json_file = file_get_contents( "./users.json" );
    $user_json = json_decode( $json_file, true );

    if ( $_POST["signup"] == "0" )
    {
        if ( $user_json[ $_POST["username"] ] == md5( $_POST["password"] ) )
        header( "Location: " . "signin.php" );
        die();
    }
    else
    {
        file_put_contents( "./users.json", json_encode( "'" . $_POST[ "username" ] . "':" . "{ 'email':" . $_POST[ "email" ] . ", 'password':" . $_POST[ "password" ] . "}" ) );
    }
?>