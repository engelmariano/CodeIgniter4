<?php
/**
 * CodeIgniter PHP-Development Server Rewrite Rules
 *
 * This script works with the CLI serve command to help run a seamless
 * development server based around PHP's built-in development
 * server. This file simply tries to mimic Apache's mod_rewrite
 * functionality so the site will operate as normal.
 */

// Avoid this file run when listing commands
if (php_sapi_name() === 'cli')
{
	return;
}

// If we're serving the site locally, then we need
// to let the application know that we're in development mode
$_SERVER['CI_ENVIRONMENT'] = 'development';

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Front Controller path - expected to be in the default folder
$fcpath = realpath(__DIR__ . '/../../../public') . DIRECTORY_SEPARATOR;

// Full path
$path = $fcpath . ltrim($uri, '/');

// If $path is an existing file or folder within the public folder
// then let the request handle it like normal.
if ($uri !== '/' && (is_file($path) || is_dir($path)))
{
	return false;
}

// Otherwise, we'll load the index file and let
// the framework handle the request from here.
require_once $fcpath . 'index.php';