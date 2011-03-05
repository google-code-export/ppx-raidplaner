<?php
	require_once(dirname(__FILE__)."/../private/users.php");
    
    if ( ValidUser() )
	{
		header("Content-type: text/javascript");
    
		function echoCharacterIds()
		{
			$first = true;
			foreach ( $_SESSION["User"]["CharacterId"] as $CharacterId )
			{
				if ($first)
				{
					echo "\"".intval( $CharacterId )."\"";
					$first = false;
				}
				else
				{
					echo ", ".intval( $CharacterId );
				}
			}
		}
		
		function echoCharacterNames()
		{
			$first = true;
			foreach ( $_SESSION["User"]["CharacterName"] as $CharacterName )
			{
				if ($first)
				{
					echo "\"".$CharacterName."\"";
					$first = false;
				}
				else
				{
					echo ", \"".$CharacterName."\"";
				}
			}
		}
		
		function echoRole1()
		{
			$first = true;
			foreach ( $_SESSION["User"]["Role1"] as $Role1 )
			{
				if ($first)
				{
					echo "\"".$Role1."\"";
					$first = false;
				}
				else
				{
					echo ", \"".$Role1."\"";
				}
			}
		}
		
		function echoRole2()
		{
			$first = true;
			foreach ( $_SESSION["User"]["Role2"] as $Role2 )
			{
				if ($first)
				{
					echo "\"".$Role2."\"";
					$first = false;
				}
				else
				{
					echo ", \"".$Role2."\"";
				}
			}
		}
?>

var g_User = {
	characterIds	: new Array( <?php echoCharacterIds(); ?> ),
	characterNames	: new Array( <?php echoCharacterNames(); ?> ),
	role1			: new Array( <?php echoRole1(); ?> ),
	role2			: new Array( <?php echoRole2(); ?> ),
	isRaidlead		: <?php echo ValidRaidlead() ? "true" : "false"; ?>,
	id				: <?php echo $_SESSION["User"]["UserId"]; ?>
};

<?php
	} 
	else 
	{
		header("Content-type: text/javascript");
?>
    
var g_User = null;

<?php } ?>