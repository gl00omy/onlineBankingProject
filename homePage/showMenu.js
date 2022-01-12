function showMenu()
{
	var menu = document.getElementById( "menu-bar" );

	if( menu.style.display === "none" )
	{
		menu.style.display = "block";
	}
	else
	{
		menu.style.display = "none";
	}
}