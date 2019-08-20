<?php
$ty = $_GET['type'];
$lang = $_GET['lang'];

// Is language available
if ( ! file_exists(DIR . 'backend/languages/' . $lang . '.php')) {
	header('Location: ' . URL . ($ty == 'k') ? 'editKeywords' : 'editVariables' );
	exit();
}

// If no keyword, no proccess
if (count($_POST) == 0)
{
  redirectTo('edit' . ( ($ty == 'k') ? 'Keywords' : 'Variables' ) );
}

$varArray = array();
foreach ($_POST as $key => $value)
{
  $varArray[$key] = trim($value);
}

try {
	$jsonName = (($ty == 'k') ? 'content' : 'variables') . '.json';

	if ( ! file_exists(DIR . 'theme/backend/data/' . $lang))
		if ( ! mkdir(DIR . 'theme/backend/data/' . $lang))
			throw new \Exception('Error creating directory: "' . DIR . 'theme/backend/data/' . $lang . '"');

	if ( ! file_exists(DIR . 'theme/backend/data/' . $lang . '/' . $jsonName))
		if ( ! touch(DIR . 'theme/backend/data/' . $lang . '/' . $jsonName))
			throw new \Exception('Error creating file: "' . DIR . 'theme/backend/data/' . $lang . '/' . $jsonName . '"');


	if (file_put_contents(DIR . 'theme/backend/data/' . $lang . '/' . $jsonName, json_encode($varArray))) {
		redirectTo('edit' . ( ($ty == 'k') ? 'Keywords' : 'Variables' ) . '?result=true');
	} else {
		throw new \Exception('Error while writing data: "' . DIR . 'theme/backend/data/' . $lang . '/' . $jsonName . '"');

	}

} catch (\Exception $e) {
	redirectTo('edit' . ( ($ty == 'k') ? 'Keywords' : 'Variables' ) . '?result=false');
}
?>
