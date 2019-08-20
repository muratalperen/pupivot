<?php
/**
 * Index
 *
 * Main script. Every page opens with that page. This page does all of routes
 *
 *
 * @package	pupivot
 * @author	Murat Serhat Alperen
 * @copyright	Copyright (c) 2019 - 2020, Murat Serhat Alperen
 * @license	http://opensource.org/licenses/MIT
 * @link	https://github.com/muratalperen/pupivot
 */


require 'backend/config.php';


// Definitions
define('DIR', $config->directory);
define('URL', $config->url);

// Set admin info
session_start();
$admin = isset($_SESSION['user']) ? $_SESSION['user'] : null ;
$settings = json_decode(file_get_contents(DIR . 'backend/settings.json'));


// Get path
if (isset($_SERVER['PATH_INFO']))
{
	$path = substr($_SERVER['PATH_INFO'], 1);
}
else // If in main directory, redirect to default language
{
	header('Location: ' . URL . $settings->language . '/');
	exit();
}

// Redirect /index to /
const SLASHINDEXSTRLEN = 6;
if (substr($path, -SLASHINDEXSTRLEN) === '/index') {
	header('Location: ' . URL . substr($path, 0, -SLASHINDEXSTRLEN + 1));
}

// If last character is slash, should open index page
$path .= ( (substr($path, -1) == '/') ? 'index' : '' );

/**
 * Includes "uri" and "path".
 *	uri: 	holds page address
 *	path: holds segments of the adress
 *
 * @var object
 */
$uriPath = (object) array(
  'uri'   => $path,
  'path'  => explode('/', $path)
);
unset($path);


// PAGES

if ($uriPath->path[0] == 'sitemap.xml') // Sitemap
{
  require DIR . 'backend/sitemap.php';
}
elseif ($uriPath->path[0] == 'robots.txt')	// Robots.txt
{
  require DIR . 'backend/robots.php';
}
elseif ($uriPath->path[0] == 'admin')	// Admin Page
{
  require DIR . 'backend/admin.php';
}
else // Not special page
{
	// If language package exits, get data
	if (file_exists(DIR . 'theme/backend/data/' . $uriPath->path[0]))
	{

		/**
		 * Page content and variables
		 *
		 * @var object
		 */
		$data = (object) array(
			'content'		=> (array) json_decode(file_get_contents(DIR . 'theme/backend/data/' . $uriPath->path[0] . '/content.json')),
			'variables'	=> (array) json_decode(file_get_contents(DIR . 'theme/backend/data/' . $uriPath->path[0] . '/variables.json'))
		);

		// Definitions
		$data->variables['URL'] = URL;
		$data->variables['URLL'] = URL . $settings->language . '/';
		$data->variables['SITENAME'] = $config->siteName;

		// Set this page name
		if ($uriPath->path[1] === 'index') { // If on main page
			$data->variables['THISPAGENAME'] = $data->variables['SITENAME'];
		} else {
			if ($uriPath->path[count($uriPath->path)-1] == 'index') {
				if (isset($data->variables[$uriPath->path[count($uriPath->path)-2]])) {
					$data->variables['THISPAGENAME'] = $data->variables[$uriPath->path[count($uriPath->path)-2]];
				} else {
					$data->variables['THISPAGENAME'] = '404';
				}
			} else {
				if (isset($data->variables[$uriPath->path[count($uriPath->path)-1]])) {
					$data->variables['THISPAGENAME'] = $data->variables[$uriPath->path[count($uriPath->path)-1]];
				} else {
					$data->variables['THISPAGENAME'] = '404';
				}
			}
		}


	}
	elseif ($uriPath->path[0] == $settings->language)	// Main language doesn't exits in theme
	{
		header('HTTP/1.1 404 Not Found');
		die('404 error. This website has no translations for this language.');
	}
	else // Redirect pages to default language
	{
		header('Location: ' . URL . $settings->language . '/' . $uriPath->uri);
		exit();
	}


  /**
  * Render Page
  *
  * Returns a html from html template. It puts data to keywords
  *
  * @param string	Page direction
  *
  * @return	string
  */
  function render_page($page)
  {
    global $data;

		// Get page content
    $content = file_get_contents(DIR . 'theme/' . $page);

    // Changing values
    $content = preg_replace_callback(
      '/\|[^|]*\|/',
      function ($matches) {
        global $data;
        $key = substr($matches[0], 1, -1);
        return isset($data->content[$key]) ? $data->content[$key] : $key ;
      },
      $content
    );

    // Changing variables
    $content = preg_replace_callback(
      '/~[^~]*~/',
      function ($matches) {
        global $data;
        $key = substr($matches[0], 1, -1);
        return isset($data->variables[$key]) ? $data->variables[$key] : $key ;
      },
      $content
    );
    return $content;
  }



	/**
  * Show 404
  *
  * Shows 404 page
  */
	function show_404()
	{
		// There are no file named that. So show 404 error
		header('HTTP/1.1 404 Not Found');

    echo render_page('backend/header.html');
    if (file_exists(DIR . 'theme/backend/404.html'))
		{
    	echo render_page('backend/404.html');
    }
		else
		{
    	echo '<h1>404</h1>';
    }

    echo render_page('backend/footer.html');
	}


	if (file_exists(DIR . 'theme/backend/data/' . $uriPath->path[0])) // Static Page
	{
		if ( ! isset($uriPath->path[1])) // If address isn't have slash.
		{
			header('Location: ' . URL . $uriPath->path[0] . '/');
			exit();
		}

	  // --------- A PAGE WILL DISPLAY --------

		// If trying to go to backend page, it's unallowed
		if ($uriPath->path[1] == 'backend')
		{
			header('HTTP/1.1 403 Not Allowed');
			die('403 Not Allowed');
		}

		// Page adress is path without language segment
		$pageAdress = substr($uriPath->uri, strlen($uriPath->path[0]) + 1);
		// DEBUG: If page has slash, it thinks it is a folder and returns 404

	  if (file_exists(DIR . 'theme/pages/' . $pageAdress . '.html')) // If page exist
	  {
			// Render header
	    echo render_page('backend/header.html');
			// Render page
	    echo render_page('pages/' . $pageAdress . '.html');

			// Render footer
	    echo render_page('backend/footer.html');

	  }
	  else // If page doesn't exits
	  {
			// Maybe tried /lang/admin.
			if ($uriPath->path[1] == 'admin') {
				header('Location: ' . URL . 'admin');
				exit();
			}

			show_404();

	  }

	}
	else
	{
		show_404();
	}

}
?>
