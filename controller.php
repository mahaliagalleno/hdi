<?php

$conf = parse_ini_file("config.ini",true);

ob_start();

try 
{
   $conf["database"]["password"] = str_replace('@','!',$conf["database"]["password"]);
	$conn = new PDO("{$conf["database"]["type"]}:host={$conf["database"]["host"]};dbname={$conf["database"]["database"]}", 	 		$conf["database"]["username"], $conf["database"]["password"],array(PDO::ATTR_PERSISTENT => true));
	
}catch (PDOException $e) 
{
	trigger_error($e->getMessage(), E_USER_ERROR);
	die();
}

foreach ($conf['objects'] as $key=>$value)
{
	require_once($value);	
}

$functions = new functions;
$functions->$_POST['function_name']();

$result = ob_get_contents();

ob_end_clean();
echo $result;
$conn = null; //Close DB Connection


?>