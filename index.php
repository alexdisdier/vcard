<?php

// Save the project root directory as a global constant.
define('ROOT_PATH', __DIR__);

/*
 * Create a global constant used to get the filesystem path to the
 * application configuration directory.
 */
define('CFG_PATH', realpath(ROOT_PATH.'/application/config'));

/*
 * Create a global constant used to get the filesystem path to the
 * application public web root directory.
 *
 * Can be used to handle file uploads for example.
 */
define('WWW_PATH', realpath(ROOT_PATH.'/application/www'));

/*
 * Create a global constant used to get the filesystem path to the
 * application controllers
 *
 */
define('CONTROLLERS_PATH', realpath($_SERVER['HTTP_HOST'].'/application/controllers'));

// Verify if we are in a development environment 
// Source: https://www.designcise.com/web/tutorial/how-to-check-if-user-is-on-localhost-in-php
define ('IS_PROD_ENV', 'localhost');

require_once 'library/Configuration.class.php';
require_once 'library/Database.class.php';
require_once 'library/FlashBag.class.php';
require_once 'library/Form.class.php';
require_once 'library/FrontController.class.php';
require_once 'library/MicroKernel.class.php';
require_once 'library/Http.class.php';
require_once 'library/InterceptingFilter.interface.php';
require_once 'library/Functions.php';
require_once 'library/svg.php';


$microKernel = new MicroKernel();
$microKernel->bootstrap()->run(new FrontController());
