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

function getFactors($USER, $Type = 'basic', $TIME = NULL)
{
    global $resource, $pricelist, $reslist;
    if (empty($TIME))
        $TIME = TIMESTAMP;

    $bonusList = BuildFunctions::getBonusList();
    $factor = ArrayUtil::combineArrayWithSingleElement($bonusList, 0);

    foreach ($reslist['bonus'] as $elementID) {
        $bonus = $pricelist[$elementID]['bonus'];

        if (isset($PLANET[$resource[$elementID]])) {
            $elementLevel = $PLANET[$resource[$elementID]];
        } elseif (isset($USER[$resource[$elementID]])) {
            $elementLevel = $USER[$resource[$elementID]];
        } else {
            continue;
        }

        if (in_array($elementID, $reslist['dmfunc'])) {
            if (DMExtra($elementLevel, $TIME, false, true)) {
                continue;
            }

            foreach ($bonusList as $bonusKey) {
                $factor[$bonusKey] += $bonus[$bonusKey][0];
            }
        } else {
            foreach ($bonusList as $bonusKey) {
                $factor[$bonusKey] += $elementLevel * $bonus[$bonusKey][0];
            }
        }
    }

    return $factor;
}

function userStatus($data, $noobprotection = false)
{
    $Array = array();

    if (isset($data['banaday']) && $data['banaday'] > TIMESTAMP) {
        $Array[] = 'banned';
    }

    if (isset($data['urlaubs_modus']) && $data['urlaubs_modus'] == 1) {
        $Array[] = 'vacation';
    }

    if (isset($data['onlinetime']) && $data['onlinetime'] < TIMESTAMP - INACTIVE_LONG) {
        $Array[] = 'longinactive';
    }

    if (isset($data['onlinetime']) && $data['onlinetime'] < TIMESTAMP - INACTIVE) {
        $Array[] = 'inactive';
    }

    if ($noobprotection && $noobprotection['NoobPlayer']) {
        $Array[] = 'noob';
    }

    if ($noobprotection && $noobprotection['StrongPlayer']) {
        $Array[] = 'strong';
    }

    return $Array;
}

function getLanguage($language = NULL, $userID = NULL)
{
    if (is_null($language) && !is_null($userID)) {
        $language = Database::get()->selectSingle('SELECT lang FROM %%USERS%% WHERE id = :id;', array(
            ':id' => $userID
        ))['lang'];
    }

    $LNG = new Language($language);
    $LNG->includeData(array('L18N', 'FLEET', 'TECH', 'CUSTOM', 'INGAME'));
    return $LNG;
}

function getPlanets($USER)
{
    if (isset($USER['PLANETS']))
        return $USER['PLANETS'];

    $order = $USER['planet_sort_order'] == 1 ? "DESC" : "ASC";

    $sql = "SELECT id, name, galaxy, system, planet, planet_type, image, b_building, b_building_id
			FROM %%PLANETS%% WHERE id_owner = :userId AND destruyed = :destruyed ORDER BY ";

    switch ($USER['planet_sort']) {
        case 0:
            $sql .= 'id ' . $order;
            break;
        case 1:
            $sql .= 'galaxy ' . $order . ', system ' . $order . ', planet ' . $order . ', planet_type ' . $order;
            break;
        case 2:
            $sql .= 'name ' . $order;
            break;
    }

    $planetsResult = Database::get()->select($sql, array(
        ':userId' => $USER['id'],
        ':destruyed' => 0
    ));

    $planetsList = array();

    foreach ($planetsResult as $planetRow) {
        $planetsList[$planetRow['id']] = $planetRow;
    }

    return $planetsList;
}

function get_timezone_selector()
{
    // New Timezone Selector, better support for changes in tzdata (new russian timezones, e.g.)
    // http://www.php.net/manual/en/datetimezone.listidentifiers.php

    $timezones = array();
    $timezone_identifiers = DateTimeZone::listIdentifiers();

    foreach ($timezone_identifiers as $value) {
        if (preg_match('/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value)) {
            $ex = explode('/', $value); //obtain continent,city
            $city = isset($ex[2]) ? $ex[1] . ' - ' . $ex[2] : $ex[1]; //in case a timezone has more than one
            $timezones[$ex[0]][$value] = str_replace('_', ' ', $city);
        }
    }
    return $timezones;
}

function locale_date_format($format, $time, $LNG = NULL)
{
    // Workaround for locale Names.

    if (!isset($LNG)) {
        global $LNG;
    }

    $weekDay = date('w', $time);
    $months = date('n', $time) - 1;

    $format = str_replace(array('D', 'M'), array('$D$', '$M$'), $format);
    $format = str_replace('$D$', addcslashes($LNG['week_day'][$weekDay], 'A..z'), $format);
    $format = str_replace('$M$', addcslashes($LNG['months'][$months], 'A..z'), $format);

    return $format;
}

function _date($format, $time = null, $toTimeZone = null, $LNG = NULL)
{
    if (!isset($time)) {
        $time = TIMESTAMP;
    }

    if (isset($toTimeZone)) {
        $date = new DateTime();
        if (method_exists($date, 'setTimestamp')) {    // PHP > 5.3
            $date->setTimestamp($time);
        } else {
            // PHP < 5.3
            $tempDate = getdate((int)$time);
            $date->setDate($tempDate['year'], $tempDate['mon'], $tempDate['mday']);
            $date->setTime($tempDate['hours'], $tempDate['minutes'], $tempDate['seconds']);
        }

        $time -= $date->getOffset();
        try {
            $date->setTimezone(new DateTimeZone($toTimeZone));
        } catch (Exception $e) {
        }
        $time += $date->getOffset();
    }

    $format = locale_date_format($format, $time, $LNG);
    return date($format, $time);
}

function ValidateAddress($address)
{

    if (function_exists('filter_var')) {
        return filter_var($address, FILTER_VALIDATE_EMAIL) !== FALSE;
    } else {
        /*
            Regex expression from swift mailer (http://swiftmailer.org)
            RFC 2822
        */
        return preg_match('/^(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))@(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?(?:[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+(\.[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_\{\}\|~]+)*)+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?\[((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x5A\x5E-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*?(?:(?:[ \t]*(?:\r\n))?[ \t])?\](?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)))$/D', $address);
    }
}

function message($mes, $dest = "", $time = "3", $topnav = false)
{
    require_once('includes/classes/template.class.php');
    $template = new template();
    $template->message($mes, $dest, $time, !$topnav);
    exit;
}

function CalculateMaxPlanetFields($planet)
{
    global $resource;
    return $planet['field_max'] + ($planet[$resource[33]] * FIELDS_BY_TERRAFORMER) + ($planet[$resource[41]] * FIELDS_BY_MOONBASIS_LEVEL);
}

function pretty_time($seconds)
{
    global $LNG;

    $day = floor($seconds / 86400);
    $hour = floor($seconds / 3600 % 24);
    $minute = floor($seconds / 60 % 60);
    $second = floor($seconds % 60);

    $time = '';

    if ($day > 0) {
        $time .= sprintf('%d%s ', $day, $LNG['short_day']);
    }

    return $time . sprintf(
            '%02d%s %02d%s %02d%s',
            $hour,
            $LNG['short_hour'],
            $minute,
            $LNG['short_minute'],
            $second,
            $LNG['short_second']
        );
}

function pretty_fly_time($seconds)
{
    $hour = floor($seconds / 3600);
    $minute = floor($seconds / 60 % 60);
    $second = floor($seconds % 60);

    return sprintf('%02d:%02d:%02d', $hour, $minute, $second);
}

function GetStartAddressLink($FleetRow, $FleetType = '')
{
    return '<a href="game.php?page=galaxy&amp;galaxy=' . $FleetRow['fleet_start_galaxy'] . '&amp;system=' . $FleetRow['fleet_start_system'] . '" class="' . $FleetType . '">[' . $FleetRow['fleet_start_galaxy'] . ':' . $FleetRow['fleet_start_system'] . ':' . $FleetRow['fleet_start_planet'] . ']</a>';
}

function GetTargetAddressLink($FleetRow, $FleetType = '')
{
    return '<a href="game.php?page=galaxy&amp;galaxy=' . $FleetRow['fleet_end_galaxy'] . '&amp;system=' . $FleetRow['fleet_end_system'] . '" class="' . $FleetType . '">[' . $FleetRow['fleet_end_galaxy'] . ':' . $FleetRow['fleet_end_system'] . ':' . $FleetRow['fleet_end_planet'] . ']</a>';
}

function BuildPlanetAddressLink($CurrentPlanet)
{
    return '<a href="game.php?page=galaxy&amp;galaxy=' . $CurrentPlanet['galaxy'] . '&amp;system=' . $CurrentPlanet['system'] . '">[' . $CurrentPlanet['galaxy'] . ':' . $CurrentPlanet['system'] . ':' . $CurrentPlanet['planet'] . ']</a>';
}

/** from stackoverflow  https://stackoverflow.com/questions/13049851/php-number-abbreviator */
function abbreviateTotalCount($value)
{
    $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');
    foreach ($abbreviations as $exponent => $abbreviation) {
        if ($value >= pow(10, $exponent)) {
            return round(floatval($value / pow(10, $exponent)), 1) . $abbreviation;
        }
    }
}

function pretty_number($n, $dec = 0)
{
    if(!is_numeric($n))
        return 'NaN';
    if ($n < 0) {
        return '-' . abbreviateTotalCount(-$n);
    } else if ($n == 0) {
        return 0;
    } else {
        return abbreviateTotalCount($n); //number_format(floatToString($n, $dec), $dec, ',', '.');
    }
}

function GetUserByID($userId, $GetInfo = "*")
{
    if (is_array($GetInfo)) {
        $GetOnSelect = implode(', ', $GetInfo);
    } else {
        $GetOnSelect = $GetInfo;
    }

    $sql = 'SELECT ' . $GetOnSelect . ' FROM %%USERS%% WHERE id = :userId';

    $User = Database::get()->selectSingle($sql, array(
        ':userId' => $userId
    ));

    return $User;
}

function makebr($text)
{
    // XHTML FIX for PHP 5.3.0
    // Danke an Meikel

    $BR = "<br>\n";
    return (version_compare(PHP_VERSION, "5.3.0", ">=")) ? nl2br($text, false) : strtr($text, array("\r\n" => $BR, "\r" => $BR, "\n" => $BR));
}

function CheckNoobProtec($OwnerPlayer, $TargetPlayer, $Player)
{
    $config = Config::get();
    if (
        $config->noobprotection == 0
        || $config->noobprotectiontime == 0
        || $config->noobprotectionmulti == 0
        || $Player['banaday'] > TIMESTAMP
        || $Player['onlinetime'] < TIMESTAMP - INACTIVE
    ) {
        return array('NoobPlayer' => false, 'StrongPlayer' => false);
    }

    return array(
        'NoobPlayer' => (
            /* WAHR:
                Wenn Spieler mehr als 25000 Punkte hat UND
                Wenn ZielSpieler weniger als 80% der Punkte des Spieler hat.
                ODER weniger als 5.000 hat.
            */
            // Addional Comment: Letzteres ist eigentlich sinnfrei, bitte testen.a
            ($TargetPlayer['total_points'] <= $config->noobprotectiontime) && // Default: 25.000
            ($OwnerPlayer['total_points'] > $TargetPlayer['total_points'] * $config->noobprotectionmulti)),
        'StrongPlayer' => (
            /* WAHR:
                Wenn Spieler weniger als 5000 Punkte hat UND
                Mehr als das funfache der eigende Punkte hat
            */
            ($OwnerPlayer['total_points'] < $config->noobprotectiontime) && // Default: 5.000
            ($OwnerPlayer['total_points'] * $config->noobprotectionmulti < $TargetPlayer['total_points'])),
    );
}

function shortly_number($number, $decial = NULL)
{
    $negate = $number < 0 ? -1 : 1;
    $number = abs($number);
    $unit = array("", "K", "M", "B", "T", "Q", "Q+", "S", "S+", "O", "N");
    $key = 0;

    if ($number >= 1000000) {
        ++$key;
        while ($number >= 1000000) {
            ++$key;
            $number = $number / 1000000;
        }
    } elseif ($number >= 1000) {
        ++$key;
        $number = $number / 1000;
    }

    $decial = !is_numeric($decial) ? ((int)(((int)$number != $number) && $key != 0 && $number != 0 && $number < 100)) : $decial;
    return pretty_number($negate * $number, $decial) . '&nbsp;' . $unit[$key];
}

function floatToString($number, $Pro = 0, $output = false)
{
    return $output ? str_replace(",", ".", sprintf("%." . $Pro . "f", $number)) : sprintf("%." . $Pro . "f", $number);
}

function isModuleAvailable($ID)
{
    global $USER;
    $modules = explode(';', Config::get()->moduls);

    if (!isset($modules[$ID])) {
        $modules[$ID] = 1;
    }

    return $modules[$ID] == 1; // || (isset($USER['authlevel']) && $USER['authlevel'] > AUTH_USR);
}

function ClearCache()
{
    $DIRS = array('cache/', 'cache/templates/');
    foreach ($DIRS as $DIR) {
        $FILES = array_diff(scandir($DIR), array('..', '.', '.htaccess'));
        foreach ($FILES as $FILE) {
            if (is_dir(ROOT_PATH . $DIR . $FILE))
                continue;

            unlink(ROOT_PATH . $DIR . $FILE);
        }
    }


    $template = new template();
    $template->clearAllCache();


    require_once 'includes/classes/Cronjob.class.php';
    Cronjob::reCalculateCronjobs();

    $sql = 'UPDATE %%PLANETS%% SET eco_hash = :ecoHash;';
    Database::get()->update($sql, array(
        ':ecoHash' => ''
    ));
    clearstatcache();

    /* does no work on git.

    // Find currently Revision

    $REV = 0;

    $iterator = new RecursiveDirectoryIterator(ROOT_PATH);
    foreach(new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
        if (false == $file->isDir()) {
            $CONTENT	= file_get_contents($file->getPathname());

            preg_match('!\$'.'Id: [^ ]+ ([0-9]+)!', $CONTENT, $match);

            if(isset($match[1]) && is_numeric($match[1]))
            {
                $REV	= max($REV, $match[1]);
            }
        }
    }

    $config->VERSION	= $version[0].'.'.$version[1].'.'.$REV;
    */

    $config = Config::get();
    $version = explode('.', $config->VERSION);
    $config->VERSION = $version[0] . '.' . $version[1];
    $config->save();
}

function allowedTo($side)
{
    global $USER;
    return ($USER['authlevel'] == AUTH_ADM || (isset($USER['rights']) && $USER['rights'][$side] == 1));
}

function isactiveDMExtra($Extra, $Time)
{
    return $Time - $Extra <= 0;
}

function DMExtra($Extra, $Time, $true, $false)
{
    return isactiveDMExtra($Extra, $Time) ? $true : $false;
}

function getRandomString()
{
    return md5(uniqid());
}

function isVacationMode($USER)
{
    return ($USER['urlaubs_modus'] == 1) ? true : false;
}

function clearGIF()
{
    header('Cache-Control: no-cache');
    header('Content-type: image/gif');
    header('Content-length: 43');
    header('Expires: 0');
    echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
    exit;
}

/*
 * Handler for exceptions
 *
 * @param object
 * @return Exception
 */
function exceptionHandler($exception)
{
    /** @var $exception ErrorException|Exception */

    if (!headers_sent()) {
        if (!class_exists('HTTP', false)) {
            require_once('includes/classes/HTTP.class.php');
        }

        HTTP::sendHeader('HTTP/1.1 503 Service Unavailable');
    }

    if (method_exists($exception, 'getSeverity')) {
        $errno = $exception->getSeverity();
    } else {
        $errno = E_USER_ERROR;
    }

    $errorType = array(
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSING ERROR',
        E_NOTICE => 'NOTICE',
        E_CORE_ERROR => 'CORE ERROR',
        E_CORE_WARNING => 'CORE WARNING',
        E_COMPILE_ERROR => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_ERROR => 'USER ERROR',
        E_USER_WARNING => 'USER WARNING',
        E_USER_NOTICE => 'USER NOTICE',
        E_STRICT => 'STRICT NOTICE',
        E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR'
    );

    if (file_exists(ROOT_PATH . 'install/VERSION')) {
        $VERSION = file_get_contents(ROOT_PATH . 'install/VERSION') . ' (FILE)';
    } else {
        $VERSION = 'UNKNOWN';
    }
    $gameName = '-';

    if (MODE !== 'INSTALL') {
        try {
            $config = Config::get();
            $gameName = $config->game_name;
            $VERSION = $config->VERSION;
        } catch (ErrorException $e) {
        }
    }


    $DIR = MODE == 'INSTALL' ? '..' : '.';
    ob_start();
    echo '<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="de" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="de" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="de" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="de" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="de" class="no-js"> <!--<![endif]-->
<head>
	<title>' . $gameName . ' - Error</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link href="' . $DIR . '/styles/resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="' . $DIR . '/styles/resource/css/base/boilerplate.css?v=' . $VERSION . '">
	<link rel="stylesheet" type="text/css" href="' . $DIR . '/styles/resource/css/ingame/main.css?v=' . $VERSION . '">
</head>
<body id="overview" class="full">
<div class="alert alert-danger">
<strong>Unknown error</strong><br />
<p>
			<b>Message: </b>' . $exception->getMessage() . '<br>
			<b>File: </b>' . $exception->getFile() . '<br>
			<b>Line: </b>' . $exception->getLine() . '<br>
			<b>URL: </b>' . PROTOCOL . HTTP_HOST . $_SERVER['REQUEST_URI'] . '<br>
			<b>PHP-Version: </b>' . PHP_VERSION . '<br>
			<b>PHP-API: </b>' . php_sapi_name() . '<br>
			<b>2Moons Version: </b>' . $VERSION . '<br>
			<b>Debug Backtrace:</b><br>' . makebr(htmlspecialchars($exception->getTraceAsString())) . '

</p>
</div>
</body>
</html>';

    echo str_replace(array('\\', ROOT_PATH, substr(ROOT_PATH, 0, 15)), array('/', '/', 'FILEPATH '), ob_get_clean());

    $errorText = date("[d-M-Y H:i:s]", TIMESTAMP) . ' ' . $errorType[$errno] . ': "' . strip_tags($exception->getMessage()) . "\"\r\n";
    $errorText .= 'File: ' . $exception->getFile() . ' | Line: ' . $exception->getLine() . "\r\n";
    $errorText .= 'URL: ' . PROTOCOL . HTTP_HOST . $_SERVER['REQUEST_URI'] . ' | Version: ' . $VERSION . "\r\n";
    $errorText .= "Stack trace:\r\n";
    $errorText .= str_replace(ROOT_PATH, '/', htmlspecialchars(str_replace('\\', '/', $exception->getTraceAsString()))) . "\r\n";

    if (is_writable('includes/error.log')) {
        file_put_contents('includes/error.log', $errorText, FILE_APPEND);
    }

    /* Debug via Support Ticket */
    global $USER;
    if (isset($USER)) {
        $ErrSource = $USER['id'];
        $ErrName = $USER['username'];
    } else {
        $ErrSource = 1;
        $ErrName = 'System';
    }
    require 'includes/classes/SupportTickets.class.php';
    $ticketObj = new SupportTickets;
    $ticketID = $ticketObj->createTicket($ErrSource, '1', $errorType[$errno]);
    $ticketObj->createAnswer($ticketID, $ErrSource, $ErrName, $errorType[$errno], $errorText, 0);
}

/*
 *
 * @throws ErrorException
 *
 * @return bool If its an hidden error.
 *
 */
function errorHandler($errno, $errstr, $errfile, $errline)
{
    if (!($errno & error_reporting())) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

// "workaround" for PHP version pre 5.3.0
if (!function_exists('array_replace_recursive')) {
    function array_replace_recursive()
    {
        if (!function_exists('recurse')) {
            function recurse($array, $array1)
            {
                foreach ($array1 as $key => $value) {
                    // create new key in $array, if it is empty or not an array
                    if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
                        $array[$key] = array();
                    }

                    // overwrite the value in the base array
                    if (is_array($value)) {
                        $value = recurse($array[$key], $value);
                    }
                    $array[$key] = $value;
                }
                return $array;
            }
        }

        // handle the arguments, merge one by one
        $args = func_get_args();
        $array = $args[0];
        if (!is_array($array)) {
            return $array;
        }
        $count = count($args);
        for ($i = 1; $i < $count; ++$i) {
            if (is_array($args[$i])) {
                $array = recurse($array, $args[$i]);
            }
        }
        return $array;
    }
}

function loadPage($module, $defaultPage)
{
    global $LNG;
    require_once ('includes/pages/game/ShowErrorPage.class.php');

    $page = HTTP::_GP('page', $defaultPage);
    $page = str_replace(array('_', '\\', '/', '.', "\0"), '', $page);
    $pageClass = 'Show' . ucwords($page) . 'Page';

    $path = "includes/pages/$module/$pageClass.class.php";

    if (!file_exists($path)) {
        ShowErrorPage::printError($LNG['page_doesnt_exist']);
    }

    require_once($path);
    $pageObj =  new $pageClass();

    if (isset($pageObj::$requireModule) && $pageObj::$requireModule !== 0 && !isModuleAvailable($pageObj::$requireModule)) {
        ShowErrorPage::printError($LNG['sys_module_inactive']);
    }

    return $pageObj;
}
