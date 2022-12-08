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