<?php
    define( "LOCALE_SETUP", true );
    require_once(dirname(__FILE__)."/../../lib/private/connector.class.php");
    require_once(dirname(__FILE__)."/../../lib/config/config.php");

    header("Content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
    echo "<grouplist>";
    
    $Connector = new Connector(SQL_HOST, $_REQUEST["database"], $_REQUEST["user"], $_REQUEST["password"]); 
    $Groups = $Connector->prepare( "SELECT gid, title FROM `".$_REQUEST["prefix"]."usergroups` ORDER BY title" );
    
    if ( $Groups->execute() )
    {
        while ( $Group = $Groups->fetch( PDO::FETCH_ASSOC ) )
        {
            echo "<group>";
            echo "<id>".$Group["gid"]."</id>";
            echo "<name>".$Group["title"]."</name>";
            echo "</group>";
        }
    }
    else
    {
        postErrorMessage( $Groups );
    }
        
    echo "</grouplist>";
?>