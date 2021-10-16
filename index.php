<?php

/**
 *  2Moons
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */

define('MODE', 'LOGIN');
define('ROOT_PATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
set_include_path(ROOT_PATH);

require 'includes/common.php';
require 'includes/pages/login/AbstractLoginPage.class.php';
/** @var $LNG Language */

$mode = HTTP::_GP('mode', 'show');

$pageObj = loadPage('login', 'index');

if (!is_callable(array($pageObj, $mode))) {
    if (!isset($pageObj::$defaultController) || !is_callable(array($pageObj, $pageObj::$defaultController))) {
        ShowErrorPage::printError($LNG['page_doesnt_exist']);
    }
    $mode = pageObj::$defaultController;
}

$pageObj->{$mode}();
