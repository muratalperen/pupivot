<?php
// If lang not send, redirect to admin panel
if ( ! isset($_POST['lang']))
  redirectTo('');

// If given language doesn't exitst, redirect to admin panel
if ( ! file_exists(DIR . 'backend/languages/' . $_POST['lang'] . '.php'))
	echo _w('langFileNotFound');

$settings->language = $_POST['lang'];

echo file_put_contents(DIR . 'backend/settings.json', json_encode($settings));
?>
