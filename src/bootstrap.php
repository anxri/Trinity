<?php

namespace Trinity;

use Trinity\util\Autoloader;

/*------------------------------------------------------------------*
 * AUTOLOAD
 *------------------------------------------------------------------*/

require_once 'src/util/Autoloader.php';

$autoloader = new Autoloader();             // trinity only autoloader

$autoloader->add_directory( 'src' );
$autoloader->add_directory( 'app' );

$autoloader->autoload();

/*------------------------------------------------------------------*/

require_once 'vendor/autoload.php';

/*------------------------------------------------------------------*
 * APP
 *------------------------------------------------------------------*/

app_init();

app_run();
