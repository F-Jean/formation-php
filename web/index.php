<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/07/17
 * Time: 17:09
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__."/../vendor/autoload.php";

\Framework\Kernel::run();