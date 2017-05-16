<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Configuration file for Resumeify
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT license found in the 'LICENSE'
 * file of the main directory of this repository.
 *
 * @author Dave Russell Jr <dave@createazure.com>
 * @copyright 2017 Dave Russell Jr
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 1.0.0
 * @link https://github.com/drussell393/resumeify
 * @since File available since Release 1.0.0
 */

$configuration_options = array(
    'mysql_user' => '',
    'mysql_database' => '',
    'mysql_password' => '',
    'mysql_host' => 'localhost',
    'template' => ''
);

define('ROOT', dirname(__FILE__));
define('BASE_URI', str_replace('//', '/', dirname($_SERVER['PHP_SELF']) . '/'));
define('TEMPLATE_URI', ROOT . '/templates/');

?>
