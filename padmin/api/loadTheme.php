<?php
if ( ! extension_loaded('zip')) {
    die(_w('noZipExtension'));
}

if (isset($_FILES['theme']))
{
  // If there is an error on loading
  if ($_FILES['theme']['error'] > 0){
    die($_FILES['theme']['error']);
  }

  // Delete all files in theme folder
  function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file") OR die('Error deleting file: ' . $file);
    }
		rmdir($dir);
  }
  rmdir_recursive(DIR . 'theme/');

	// TODO: Check is it theme folder!

  // Unzip theme
  $zip = new ZipArchive;
  $zip->open($_FILES['theme']['tmp_name']) OR die('Error while extracting zip file');
  $zip->extractTo(DIR . 'theme/') OR die('Error while extracting zip file');
  $zip->close();


  header('Location: ' . URL . 'admin/loadTheme?themeUpladed=TRUE');

}
else
{
  // No file sent. Go to main page
  header('Location: ' . URL . 'admin/loadTheme');
}
?>
