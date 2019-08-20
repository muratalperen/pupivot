<?php
/**
 * Admin
 *
 * Controller for admin pages. It includes functions,
 * authorization controls and variables for admin pages
 *
 *
 *
 * @package	pupivot
 * @author	Murat Serhat Alperen
 * @copyright	Copyright (c) 2019 - 2020, Murat Serhat Alperen
 * @license	http://opensource.org/licenses/MIT
 * @link	https://github.com/muratalperen/pupivot
 */


 /**
  * Redirect
  *
  * Redirects to given admin page
  *
  * @param string Page that wants to go
  */
function redirectTo($to)
{
  header('Location: ' . URL . 'admin/' . $to);
  exit();
}



// Check is it have permission for display admin page
if ( (isset($_SESSION['user']) ? ($_SESSION['user'] != 'admin') : TRUE) ) // If isn't admin
{
  if ($uriPath->path[1] != 'login' && (isset($uriPath->path[2]) ? ($uriPath->path[2] != 'login') : TRUE)) // If isn't in login page
  {
    // It isn't an admin. Go to login page
    redirectTo('login?redirect=' . $uriPath->path[1]);
  }
}


/*
 * ------------------------------------------------------
 *  Load the language package
 * ------------------------------------------------------
 */
require (DIR . 'backend/languages/' . $settings->language . '.php');


/**
 * Write
 *
 * Returns given keyword as translated to local language
 *
 * @param string Keyword of the translated text
 *
 * @return string
 */
function _w($value)
{
  global $lang;
  return isset($lang[$value]) ? $lang[$value] : htmlspecialchars($value) ;
}


// Opening admin page
$pageWillOpen = substr($uriPath->uri, 6); // Removing 'admin' from url
if ($pageWillOpen == '') // Redirect admin to admin/
	redirectTo('');
if (file_exists(DIR . 'padmin/' . $pageWillOpen . '.php')) // If page exist
{
  if ($uriPath->path[1] == 'login' OR $uriPath->path[1] == 'api') // In login and api pages doesn't need header and footer
  {
    require DIR . 'padmin/' . $pageWillOpen . '.php';
  }
  else
  {
    include DIR . 'backend/adminHeader.php';
    require DIR . 'padmin/' . $pageWillOpen . '.php';
    include DIR . 'backend/adminFooter.php';
  }

}
else // If page doesn't exits
{
  header('HTTP/1.1 404 Not Found');
  echo '<h1>' . _w('404notfound') . '</h1><br><a href="javascript:window.history.back();">' . _w('goBack') . '</a>';
}

?>
