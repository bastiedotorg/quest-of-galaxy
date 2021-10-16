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

class ShowOverviewPage extends AbstractGamePage
{
    public static $requireModule = 0;

    function __construct()
    {
        parent::__construct();
    }

    function claim_coins()
    {
        global $PLANET, $LNG;

        $coins = $PLANET['coins'];
        Cuneros::claimCuneros($coins, null, true);
        $PLANET['coins'] = 0;

        $this->sendJSON(array('message' => $LNG['coins_claim_success'], 'error' => false));
    }

    private function GetFleets()
    {
        global $USER, $PLANET;
        $fleetTableObj = new FlyingFleetsTable();
        $fleetTableObj->setUser($USER['id']);
        $fleetTableObj->setPlanet($PLANET['id']);
        return $fleetTableObj->renderTable();
    }

    function show()
    {
        global $LNG, $PLANET, $USER, $reslist, $resource;

        $AdminsOnline = array();
        $chatOnline = array();
        $AllPlanets = array();
        $Moon = array();
        $RefLinks = array();
        $config = Config::get();

        $db = Database::get();

        foreach ($USER['PLANETS'] as $ID => $CPLANET) {
            if ($ID == $PLANET['id'] || $CPLANET['planet_type'] == 3)
                continue;

            if (!empty($CPLANET['b_building']) && $CPLANET['b_building'] > TIMESTAMP) {
                $Queue = unserialize($CPLANET['b_building_id']);
                $BuildPlanet = $LNG['tech'][$Queue[0][0]] . " (" . $Queue[0][1] . ")<br><span>(" . pretty_time($Queue[0][3] - TIMESTAMP) . ")</span>";
            } else {
                $BuildPlanet = $LNG['ov_free'];
            }

            $AllPlanets[] = array(
                'id' => $CPLANET['id'],
                'name' => $CPLANET['name'],
                'image' => $CPLANET['image'],
                'build' => $BuildPlanet,
            );
        }

        if ($PLANET['id_luna'] != 0) {
            $sql = "SELECT id, name FROM %%PLANETS%% WHERE id = :lunaID;";
            $Moon = $db->selectSingle($sql, array(
                ':lunaID' => $PLANET['id_luna']
            ));
        }

        if ($PLANET['b_building'] - TIMESTAMP > 0) {
            $Queue = unserialize($PLANET['b_building_id']);
            $buildInfo['buildings'] = array(
                'id' => $Queue[0][0],
                'level' => $Queue[0][1],
                'timeleft' => $PLANET['b_building'] - TIMESTAMP,
                'time' => $PLANET['b_building'],
                'starttime' => pretty_time($PLANET['b_building'] - TIMESTAMP),
            );
        } else {
            $buildInfo['buildings'] = false;
        }

        if (!empty($PLANET['b_hangar_id'])) {
            $Queue = unserialize($PLANET['b_hangar_id']);
            $time = BuildFunctions::getBuildingTime($USER, $PLANET, $Queue[0][0]) * $Queue[0][1];
            $buildInfo['fleet'] = array(
                'id' => $Queue[0][0],
                'level' => $Queue[0][1],
                'timeleft' => $time - $PLANET['b_hangar'],
                'time' => $time,
                'starttime' => pretty_time($time - $PLANET['b_hangar']),
            );
        } else {
            $buildInfo['fleet'] = false;
        }

        if ($USER['b_tech'] - TIMESTAMP > 0) {
            $Queue = unserialize($USER['b_tech_queue']);
            $buildInfo['tech'] = array(
                'id' => $Queue[0][0],
                'level' => $Queue[0][1],
                'timeleft' => $USER['b_tech'] - TIMESTAMP,
                'time' => $USER['b_tech'],
                'starttime' => pretty_time($USER['b_tech'] - TIMESTAMP),
            );
        } else {
            $buildInfo['tech'] = false;
        }

        $sql = 'SELECT total_points, total_rank
		FROM %%STATPOINTS%%
		WHERE id_owner = :userId AND stat_type = :statType';

        $statData = Database::get()->selectSingle($sql, array(
            ':userId' => $USER['id'],
            ':statType' => 1
        ));

        if ($statData['total_rank'] == 0) {
            $rankInfo = "-";
        } else {
            $rankInfo = sprintf($LNG['ov_userrank_info'], pretty_number($statData['total_points']), $LNG['ov_place'],
                $statData['total_rank'], $statData['total_rank'], $LNG['ov_of'], $config->users_amount);
        }

        $usersOnline = Database::get()->selectSingle(
            'SELECT COUNT(*)
			FROM %%USERS%% WHERE onlinetime >= UNIX_TIMESTAMP(NOW() - INTERVAL 15 MINUTE)'
        )['COUNT(*)'];

        $fleetsOnline = Database::get()->selectSingle(
            'SELECT COUNT(*)
			FROM %%FLEETS%%'
        )['COUNT(*)'];

        $defElementIDs = array_merge($reslist['defense'], $reslist['missile']);
        $fleetElementIDs = $reslist['fleet'];

        $defMissiles = array();
        $offMissiles = array();

        foreach ($defElementIDs as $elementID) {
            $defMissiles[$elementID] = $PLANET[$resource[$elementID]];
        }
        foreach ($fleetElementIDs as $elementID) {
            $offMissiles[$elementID] = $PLANET[$resource[$elementID]];
        }

        $this->assign(array(
            'rankInfo' => $rankInfo,
            'is_news' => $config->news_active,
            'news' => makebr($config->news_text),
            'usersOnline' => $usersOnline,
            'fleetsOnline' => $fleetsOnline,
            'defMissiles' => $defMissiles,
            'offMissiles' => $offMissiles,
            'buildInfo' => $buildInfo,
            'Moon' => $Moon,
            'fleets' => $this->GetFleets(),
            'AllPlanets' => $AllPlanets,
            'planet_field_max' => CalculateMaxPlanetFields($PLANET),
            'servertime' => _date("M D d H:i:s", TIMESTAMP, $USER['timezone']),
            'path' => HTTP_PATH,
            'noob' => [
                'active' => $config->noob_protection_active,
                'points' => $USER['total_points'],
                'limit' => $config->noob_protection_points,
                'lower_limit' => max($config->noob_protection_points, $USER['total_points'] / $config->noob_protection_multiplier),
                'upper_limit' => $USER['total_points'] * $config->noob_protection_multiplier,
            ],
            'planets_max' => PlayerUtil::maxPlanetCount($USER),

        ));
        Config::get()->save(true);
        $this->display('page.overview.default.tpl');
    }

    function actions()
    {
        global $LNG, $PLANET;

        $this->initTemplate();
        $this->setWindow('popup');

        $this->assign(array(
            'ov_security_confirm' => sprintf($LNG['ov_security_confirm'], $PLANET['name'] . ' [' . $PLANET['galaxy'] . ':' . $PLANET['system'] . ':' . $PLANET['planet'] . ']'),
        ));
        $this->display('page.overview.actions.tpl');
    }

    function rename()
    {
        global $LNG, $PLANET;

        $newname = HTTP::_GP('name', '', UTF8_SUPPORT);
        if (!empty($newname)) {
            if (!PlayerUtil::isNameValid($newname)) {
                $this->sendJSON(array('message' => $LNG['ov_newname_specialchar'], 'error' => true));
            } else {
                $db = Database::get();
                $sql = "UPDATE %%PLANETS%% SET name = :newName WHERE id = :planetID;";
                $db->update($sql, array(
                    ':newName' => $newname,
                    ':planetID' => $PLANET['id']
                ));

                $this->sendJSON(array('message' => $LNG['ov_newname_done'], 'error' => false));
            }
        }
    }

    function delete()
    {
        global $LNG, $PLANET, $USER;
        $password = HTTP::_GP('password', '', true);

        if (!empty($password)) {
            $db = Database::get();
            $sql = "SELECT COUNT(*) as state FROM %%FLEETS%% WHERE
                      (fleet_owner = :userID AND (fleet_start_id = :planetID OR fleet_start_id = :lunaID)) OR
                      (fleet_target_owner = :userID AND (fleet_end_id = :planetID OR fleet_end_id = :lunaID));";
            $IfFleets = $db->selectSingle($sql, array(
                ':userID' => $USER['id'],
                ':planetID' => $PLANET['id'],
                ':lunaID' => $PLANET['id_luna']
            ), 'state');

            if ($USER['b_tech_planet'] == $PLANET['id'] && !empty($USER['b_tech_queue'])) {
                $TechQueue = unserialize($USER['b_tech_queue']);
                $NewCurrentQueue = array();
                foreach ($TechQueue as $ID => $ListIDArray) {
                    if ($ListIDArray[4] == $PLANET['id']) {
                        $ListIDArray[4] = $USER['id_planet'];
                        $NewCurrentQueue[] = $ListIDArray;
                    }
                }

                $USER['b_tech_planet'] = $USER['id_planet'];
                $USER['b_tech_queue'] = serialize($NewCurrentQueue);
            }

            if ($IfFleets > 0) {
                $this->sendJSON(array('message' => $LNG['ov_abandon_planet_not_possible']));
            } elseif ($USER['id_planet'] == $PLANET['id']) {
                $this->sendJSON(array('message' => $LNG['ov_principal_planet_cant_abanone']));
                // } elseif (PlayerUtil::cryptPassword($password) != $USER['password']) {
            } elseif ($password != $PLANET['name']) {
                $this->sendJSON(array('message' => $LNG['ov_wrong_name']));
            } else {
                if ($PLANET['planet_type'] == 1) {
                    $sql = "UPDATE %%PLANETS%% SET destruyed = :time WHERE id = :planetID;";
                    $db->update($sql, array(
                        ':time' => TIMESTAMP + 86400,
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :lunaID;";
                    $db->delete($sql, array(
                        ':lunaID' => $PLANET['id_luna']
                    ));
                } else {
                    $sql = "UPDATE %%PLANETS%% SET id_luna = 0 WHERE id_luna = :planetID;";
                    $db->update($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                    $sql = "DELETE FROM %%PLANETS%% WHERE id = :planetID;";
                    $db->delete($sql, array(
                        ':planetID' => $PLANET['id'],
                    ));
                }

                Session::load()->planetId = $USER['id_planet'];
                $this->sendJSON(array('ok' => true, 'message' => $LNG['ov_planet_abandoned']));
            }
        }
    }
}
