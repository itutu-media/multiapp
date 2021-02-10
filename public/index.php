<?php

// Valid PHP Version?
$minPHPVersion = '7.3';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
	die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . PHP_VERSION);
}
unset($minPHPVersion);

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);



$location = (substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ? 'local' : 'hosting';
defined('LOKASI') || define('LOKASI', $location);

switch ($location) {
	case 'local':
		switch ($_SERVER['SERVER_PORT']) {
			case '8081':
				$apl = 'bar';
				break;

			default:
				$apl = 'foo';
				break;
		}
		break;

	default:
		$domain = $_SERVER['HTTP_HOST'];
		$subdomain = explode('.', $domain)[0];
		switch ($subdomain) {
			case 'www':
				$apl = 'foo';
				break;

			case 'sub':
				$apl = 'bar';
				break;

			default:
				$apl = 'foo';
				break;
		}
		break;
}



/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require realpath(FCPATH . '../_' . $apl . '/app/Config/Paths.php') ?: FCPATH . '../_' . $apl . '/app/Config/Paths.php';
// ^^^ Change this if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file.
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app       = require realpath($bootstrap) ?: $bootstrap;

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();
