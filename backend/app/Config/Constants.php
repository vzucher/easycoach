<?php

/**
 * Constants
 * 
 * This file defines the main constants for the CodeIgniter application
 */

defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);

/**
 * Exit Status Codes
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);

/**
 * Default PHP error logging level
 * Typical values:
 * 0 = Disables logging, Error logging disabled.
 * 1 = Error Messages (including Fatal Errors)
 * 2 = Warning Messages
 * 4 = Parse Errors
 * 8 = Notices
 * 16 = Core Errors
 */
defined('STDERR') || define('STDERR', fopen('php://stderr', 'wb'));

/**
 * Environment - Development/Production flag
 */
if (! defined('CI_DEBUG')) {
    define('CI_DEBUG', 1);
} 