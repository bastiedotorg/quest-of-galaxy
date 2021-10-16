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

if (isset($_POST['GLOBALS']) || isset($_GET['GLOBALS'])) {
    exit('You cannot set the GLOBALS-array from outside the script.');
}

$composerAutoloader = __DIR__ . '/../vendor/autoload.php';

if (file_exists($composerAutoloader)) {
    require $composerAutoloader;
}

if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding("UTF-8");
}

ignore_user_abort(true);
error_reporting(E_ALL & ~E_STRICT);

// If date.timezone is invalid
date_default_timezone_set(@date_default_timezone_get());

ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');
define('TIMESTAMP', time());

require 'includes/constants.php';
require 'pages/AbstractPage.class.php';
require 'pages/ShowErrorPage.class.php';

ini_set('log_errors', 'On');
ini_set('error_log', 'includes/error.log');

require 'includes/GeneralFunctions.php';
set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');

require_once("includes/autoload.inc.php");
// Say Browsers to Allow ThirdParty Cookies (Thanks to morktadela)
HTTP::sendHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
define('AJAX_REQUEST', HTTP::_GP('ajax', 0));

$THEME = new Theme();

if (MODE === 'INSTALL') {
    return;
}

if (!file_exists('includes/config.php') || filesize('includes/config.php') === 0) {
    HTTP::redirectTo('install/index.php');
}

try {
    $sql = "SELECT dbVersion FROM %%SYSTEM%%;";

    $dbVersion = Database::get()->selectSingle($sql, array(), 'dbVersion');

    $dbNeedsUpgrade = $dbVersion < DB_VERSION_REQUIRED;
} catch (Exception $e) {
    $dbNeedsUpgrade = true;
}

if ($dbNeedsUpgrade) {
    HTTP::redirectTo('install/index.php?mode=upgrade');
}

if (defined('DATABASE_VERSION') && DATABASE_VERSION === 'OLD') {
    /* For our old Admin panel */
    require 'includes/classes/Database_BC.class.php';
    $DATABASE = new Database_BC();

    $dbTableNames = Database::get()->getDbTableNames();
    $dbTableNames = array_combine($dbTableNames['keys'], $dbTableNames['names']);

    foreach ($dbTableNames as $dbAlias => $dbName) {
        define(substr($dbAlias, 2, -2), $dbName);
    }
}

$config = Config::get();
date_default_timezone_set($config->timezone);


if (MODE === 'INGAME' || MODE === 'ADMIN' || MODE === 'CRON') {
    $session = Session::load();

    if (!(!$session->isValidSession() && isset($_GET['page']) && $_GET['page'] == "raport" && isset($_GET['raport']) && count($_GET) == 2 && MODE === 'INGAME'))
        if (!$session->isValidSession()) {
            $session->delete();
            HTTP::redirectTo('index.php?code=3');
        }

    require 'includes/vars.php';

    if (!AJAX_REQUEST && MODE === 'INGAME' && isModuleAvailable(MODULE_FLEET_EVENTS)) {
        require('includes/FleetHandler.php');
    }

    $db = Database::get();


    $sql = "SELECT 
	user.*,
       COUNT(planets.id) as current_planet_count,
    statpoints.total_points,
	COUNT(message.message_id) as messages
	FROM %%USERS%% as user
	LEFT JOIN %%MESSAGES%% as message ON message.message_owner = user.id AND message.message_unread = :unread
    LEFT JOIN %%STATPOINTS%% as statpoints ON statpoints.id_owner = user.id
    LEFT JOIN %%PLANETS%% as planets ON planets.id_owner = user.id
	WHERE user.id = :userId AND statpoints.stat_type = :statType AND planet_type = :planetType AND destruyed = :destroyed
	GROUP BY message.message_owner;";

    $USER = $db->selectSingle($sql, array(
        ':unread' => 1,
        ':userId' => $session->userId,
        ':statType' => 1,
        ':planetType' => TYPE_PLANET,
        ':destroyed' => 0
    ));

    if (!$session->isValidSession() && isset($_GET['page']) && $_GET['page'] == "raport" && isset($_GET['raport']) && count($_GET) == 2 && MODE === 'INGAME') {
        $USER['lang'] = 'en';
        $USER['bana'] = 0;
        $USER['timezone'] = "Europe/Berlin";
        $USER['urlaubs_modus'] = 0;
        $USER['authlevel'] = 0;
        $USER['id'] = 0;
    }


    if (!(!$session->isValidSession() && isset($_GET['page']) && $_GET['page'] == "raport" && isset($_GET['raport']) && count($_GET) == 2 && MODE === 'INGAME'))
        if (empty($USER)) {
            HTTP::redirectTo('index.php?code=3');
        }

    $LNG = new Language($USER['lang']);
    $LNG->includeData(array('L18N', 'INGAME', 'TECH', 'CUSTOM'));
    if (!empty($USER['dpath'])) {
        $THEME->setUserTheme($USER['dpath']);
    }

    if ($config->game_disable && $USER['authlevel'] == AUTH_USR) {
        ShowErrorPage::printError($LNG['sys_closed_game'] . '<br><br>' . $config->close_reason, false);
    }

    if ($USER['bana'] == 1) {
        ShowErrorPage::printError("<font size=\"6px\">" . $LNG['css_account_banned_message'] . "</font><br><br>" . sprintf($LNG['css_account_banned_expire'], _date($LNG['php_tdformat'], $USER['banaday'], $USER['timezone'])) . "<br><br>" . $LNG['css_goto_homeside'], false);
    }

    if (!(!$session->isValidSession() && isset($_GET['page']) && $_GET['page'] == "raport" && isset($_GET['raport']) && count($_GET) == 2 && MODE === 'INGAME'))
        if (MODE === 'INGAME') {
            $universeAmount = count(Universe::availableUniverses());
            if (Universe::current() != $USER['universe'] && $universeAmount > 1) {
                HTTP::redirectToUniverse($USER['universe']);
            }

            $session->selectActivePlanet();

            $sql = "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
            $PLANET = $db->selectSingle($sql, array(
                ':planetId' => $session->planetId,
            ));

            if (empty($PLANET)) {
                $sql = "SELECT * FROM %%PLANETS%% WHERE id = :planetId;";
                $PLANET = $db->selectSingle($sql, array(
                    ':planetId' => $USER['id_planet'],
                ));

                if (empty($PLANET)) {
                    throw new Exception("Main Planet does not exist!");
                } else {
                    $session->planetId = $USER['id_planet'];
                }
            }

            $USER['factor'] = getFactors($USER);
            $USER['PLANETS'] = getPlanets($USER);
        } elseif (MODE === 'ADMIN') {
            error_reporting(E_ERROR | E_WARNING | E_PARSE);

            $USER['rights'] = unserialize($USER['rights']);
            $LNG->includeData(array('ADMIN', 'CUSTOM'));
        }
} elseif (MODE === 'LOGIN') {
    $LNG = new Language();
    $LNG->getUserAgentLanguage();
    $LNG->includeData(array('L18N', 'INGAME', 'PUBLIC', 'CUSTOM'));
} elseif (MODE === 'CHAT') {
    $session = Session::load();

    if (!$session->isValidSession()) {
        HTTP::redirectTo('index.php?code=3');
    }
}
