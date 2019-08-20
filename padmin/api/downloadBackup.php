<?php
try {
	if ( ! extension_loaded('zip'))
	  throw new \Exception(_w('noZipExtension'));

	$zip = new ZipArchive();

	// Delete old recovery
	if (file_exists(DIR . 'backend/backup.zip')) {
		if ( ! unlink(DIR . 'backend/backup.zip'))
			throw new \Exception(_w('oldFileCannotDelete'));
	}

	// Create ZIP
	if ($zip->open(DIR . 'backend/backup.zip', ZIPARCHIVE::CREATE) !== true)
		throw new \Exception(_w('newFileCannotCreate'));

	// ZIP theme
	$objects = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator(DIR . 'theme/'), RecursiveIteratorIterator::SELF_FIRST
	);
	foreach($objects as $name) {
		if (substr($name, -1) == '.') continue;
		if (is_file($name)) $zip->addFile($name, substr($name, strlen(DIR) + 6));
	}

	$zip->close();

	// Zip dosyası kontrol edilir
	if (file_exists(DIR . 'backend/backup.zip'))
	{
		// Success
		header('Content-Type: application/x-zip');
		// TODO: Do file name like that: preg_replace("#(http(s|)://[^/|:]*(/|:))#", ' $2', URL);
		header('Content-Disposition: attachment;filename="' . date('d-m-Y') . URL . '.zip"');
		echo file_get_contents(DIR . 'backend/backup.zip');
	}
	else
	{
		// Zip created succesfully but there are no zip :P
		throw new \Exception(_w('procError'));
	}

} catch (\Exception $e) {
	echo $e->getMessage();
}

?>
