<?php
	define( "LOCALE_SETUP", true );
	require_once(dirname(__FILE__)."/../lib/private/locale.php");
	@include_once(dirname(__FILE__)."/../lib/config/config.php");
	require_once(dirname(__FILE__)."/../lib/private/connector.class.php");
	
	$CurrentVersion = 94;
	$CurrentPatch = $CurrentVersion % 10;
    $CurrentMinor = ($CurrentVersion / 10) % 10;
    $CurrentMajor = ($CurrentVersion / 100) % 10;
                            
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>Raidplaner config</title>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        
        <script type="text/javascript" src="../lib/script/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="script/main.js"></script>
        <script type="text/javascript" src="script/upgrade_check.js.php"></script>
        
        <style type="text/css" media="screen">
            #error {
                width: 90%;
                height: 90%;
                position: absolute;
                top: 5%;
                left: 5%;
                background-color: white;
                border: 1px solid black;
                padding: 6px;
                overflow-y: scroll;
                
                -moz-border-radius: 4px; 
                -webkit-border-radius: 4px; 
                -khtml-border-radius: 4px; 
                border-radius: 4px;
            }
            
            .item {
                border-top: 1px dotted black;
                margin-bottom: 10px;
            }
            
            .version {
                font-size: 0.9em;
                color: #999;
            }
            
            .step {
                font-size: 0.9em;
                color: #999;
            }
        </style>
    </head>
	
	<body style="font-family: helvetica, arial, sans-serif; font-size: 11px; line-height: 1.5em; background-color: #cccccc; color: black">
		<div style="width: 800px; height: 600px; position: fixed; left: 50%; top: 50%; margin-left: -400px; margin-top: -300px; background-color: white">
			<div style="background-color: black; color: white; padding: 10px">
				Packedpixel<br/>
				<span style="font-size: 24px">Raidplaner update (1/1)</span>
			</div>
			<div style="padding: 20px">
				<div>
					<h2><?php echo L("Version detection and update"); ?></h2>
					<?php echo L("Setup will try to detect your current version."); ?><br/>
					<?php echo L("If the detected version does not match your installed version you may always choose manually, too."); ?><br/>
					<?php echo L("The update will only affect changes in the database."); ?><br/>
					<?php echo L("If the database did not change you will not need to do this step."); ?><br/>
					<br/><br/>
					
					<?php echo L("Database connection"); ?> : <?php
					    try
            			{
                            $Connector  = Connector::GetInstance(true);
                            $databaseOk = true;
            			}
            			catch (PDOException $Exception)
            			{
                            $databaseOk = false;
            			}
            		
						if ( $databaseOk )
						{
							echo "<span style=\"color: green\">".L("Ok")."</span><br/>";
				            echo L("Detected version").": ";
				            
				            $GetVersion = $Connector->prepare("SELECT IntValue FROM `".RP_TABLE_PREFIX."Setting` WHERE Name='Version' LIMIT 1");
        
                            if ( !$GetVersion->execute() )
                            {
                            	$Version = 93;
                            }
                            else
                            {
                    	        if ( $Data = $GetVersion->fetch(PDO::FETCH_ASSOC) )
                    	           $Version = intval($Data["IntValue"]);
                    	        else
                    	           $Version = 93;
                            }
                            
                            $GetVersion->closeCursor();
                            
                            $Patch = $Version % 10;
                            $Minor = ($Version / 10) % 10;
                            $Major = ($Version / 100) % 10;
                            
                            echo "<span style=\"color: green\">".$Major.".".$Minor.".".$Patch."</span><br/>";
                            if ( $Version == $CurrentVersion )
                            {
                                echo "<br/><span style=\"font-size: 20px; color: green\">".L("No update necessary.")."</span>";
                            }
                        ?>
                        
                        <br/><br/>
                        <span><?php echo L("Update from version") ?>: </span>
                        <select id="version">
                            <option value="92"<?php if ($Version==92) echo " selected"; ?>>0.9.2</option>
                            <option value="93"<?php if ($Version==93) echo " selected"; ?>>0.9.3</option>
                            <option value="94"<?php if ($Version==94) echo " selected"; ?>>0.9.4</option>
                        </select>
                        <span> <?php echo L("to version")." ".$CurrentMajor.".".$CurrentMinor.".".$CurrentPatch; ?></span>
                        
                        <div style="position: fixed; right: 50%; top: 50%; margin-right: -380px; margin-top: 260px">
    					   <button onclick="updateDatabase()"><?php echo L("Continue"); ?></button>
    				    </div>
                        
                    <?php
						}
						else
						{
							++$testsFailed;
							echo "<span style=\"color: red\">".L("Database settings are not correct")."</span>";
						}
					?>
				</div>
			</div>
		</div>
        <div id="error">
		</div>
	</body>
</html>