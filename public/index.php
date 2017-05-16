<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Index file, handles the population of data from template
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT License found in the 'LICENSE'
 * file in the main directory of this repository.
 *
 * @author Dave Russell Jr <dave@createazure.com>
 * @copyright 2017 Dave Russell Jr
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 1.0.0
 * @link https://github.com/drussell393/resumeify
 * @since File available since Release 1.0.0
 */

/* Get configuration and constants */
global $config;
require_once('../config.php');

/* Get database model */
require_once('models/database.php');
global $database;
$database = new DatabaseModel;

/* Get the template index file */
require_once('templates/' . $config['template'] . '/index.php');
