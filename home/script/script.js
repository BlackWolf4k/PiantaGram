function add_post()
{
	var post_form = document.getElementById( "post_form" );

	// Check if already showing
	if ( post_form.style.display === "none" )
	{
		post_form.style.display = "block";
	}
	else
	{
		post_form.style.display = "none";
	}
}

function add_events()
{
	document.getElementById( "post_image" ).addEventListener( "change", ( event ) => {
		const [file] = document.getElementById( "post_image" ).files;
		if  ( file )
		{
			document.getElementById( "dipslayed_post_image" ).src = URL.createObjectURL( file );
		}
	} );
}