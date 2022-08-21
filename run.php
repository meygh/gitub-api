#!php -q
<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:35 PM
 */

require_once "./vendor/autoload.php";

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__ . DS);
define('VENDOR_DIR', ROOT_DIR . 'vendor' . DS);
define('CORE_DIR', ROOT_DIR . 'core' . DS);
define('APP_DIR', ROOT_DIR . 'app' . DS);

require_once CORE_DIR . 'Helpers.php';

\Meygh\GithubApi\Console::getInstance()->run();
