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

class ShowBuildingsPage extends AbstractGamePage
{
    public static $requireModule = MODULE_BUILDING;

    function __construct()
    {
        parent::__construct();
    }

    private function CancelBuildingFromQueue()
    {
        global $PLANET, $USER, $resource;
        $CurrentQueue = unserialize($PLANET['b_building_id']);
        if (empty($CurrentQueue)) {
            $PLANET['b_building_id'] = '';
            $PLANET['b_building'] = 0;
            return false;
        }

        $Element = $CurrentQueue[0][0];
        $BuildLevel = $CurrentQueue[0][1];
        $BuildMode = $CurrentQueue[0][4];

        $costResources = BuildFunctions::getElementPrice($USER, $PLANET, $Element, $BuildMode == 'destroy', $BuildLevel);

        if (isset($costResources[RESS_METAL])) {
            $PLANET[$resource[RESS_METAL]] += $costResources[RESS_METAL];
        }
        if (isset($costResources[RESS_CRYSTAL])) {
            $PLANET[$resource[RESS_CRYSTAL]] += $costResources[RESS_CRYSTAL];
        }
        if (isset($costResources[RESS_DEUTERIUM])) {
            $PLANET[$resource[RESS_DEUTERIUM]] += $costResources[RESS_DEUTERIUM];
        }
        if (isset($costResources[RESS_DARKMATTER])) {
            $USER[$resource[RESS_DARKMATTER]] += $costResources[RESS_DARKMATTER];
        }
        array_shift($CurrentQueue);
        if (count($CurrentQueue) == 0) {
            $PLANET['b_building'] = 0;
            $PLANET['b_building_id'] = '';
        } else {
            $BuildEndTime = TIMESTAMP;
            $NewQueueArray = array();
            foreach ($CurrentQueue as $ListIDArray) {
                if ($Element == $ListIDArray[0])
                    continue;

                $BuildEndTime += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], $costResources, $ListIDArray[4] == 'destroy');
                $ListIDArray[3] = $BuildEndTime;
                $NewQueueArray[] = $ListIDArray;
            }

            if (!empty($NewQueueArray)) {
                $PLANET['b_building'] = TIMESTAMP;
                $PLANET['b_building_id'] = serialize($NewQueueArray);
                $this->ecoObj->setData($USER, $PLANET);
                $this->ecoObj->SetNextQueueElementOnTop();
                list($USER, $PLANET) = $this->ecoObj->getData();
            } else {
                $PLANET['b_building'] = 0;
                $PLANET['b_building_id'] = '';
            }
        }
        return true;
    }

    private function RemoveBuildingFromQueue($QueueID)
    {
        global $USER, $PLANET;

        if ($QueueID <= 1 || empty($PLANET['b_building_id'])) {
            return false;
        }

        $CurrentQueue = unserialize($PLANET['b_building_id']);
        $ActualCount = count($CurrentQueue);
        if ($ActualCount <= 1) {
            return $this->CancelBuildingFromQueue();
        }

        if ($QueueID - $ActualCount >= 1) {
            // Avoid race conditions
            return;
        }

        $Element = $CurrentQueue[$QueueID - 1][0];
        $BuildEndTime = $CurrentQueue[$QueueID - 2][3];
        unset($CurrentQueue[$QueueID - 1]);
        $NewQueueArray = array();
        foreach ($CurrentQueue as $ID => $ListIDArray) {
            if ($ID < $QueueID - 1) {
                $NewQueueArray[] = $ListIDArray;
            } else {
                if ($Element == $ListIDArray[0] || empty($ListIDArray[0]))
                    continue;

                $BuildEndTime += BuildFunctions::getBuildingTime($USER, $PLANET, $ListIDArray[0], NULL, $ListIDArray[4] == 'destroy', $ListIDArray[1]);
                $ListIDArray[3] = $BuildEndTime;
                $NewQueueArray[] = $ListIDArray;
            }
        }

        if (!empty($NewQueueArray))
            $PLANET['b_building_id'] = serialize($NewQueueArray);
        else
            $PLANET['b_building_id'] = "";

        return true;
    }

    private function AddBuildingToQueue($Element, $AddMode = true)
    {
        global $PLANET, $USER, $resource, $reslist, $pricelist;

        if (!in_array($Element, $reslist['allow'][$PLANET['planet_type']])
            || !BuildFunctions::isTechnologyAccessible($USER, $PLANET, $Element)
            || ($Element == 31 && $USER["b_tech_planet"] != 0)
            || (($Element == BUILDING_NANITE || $Element == BUILDING_SHIPYARD) && !empty($PLANET['b_hangar_id']))
            || (!$AddMode && $PLANET[$resource[$Element]] == 0)
            || (!$AddMode && $Element == BUILDING_TERRA)
            || (!$AddMode && $Element == 44 && $PLANET[$resource[503]] + $PLANET[$resource[502]] > 0)
        )
            return;

        $CurrentQueue = unserialize($PLANET['b_building_id']);
        $DemolishedQueue = 0;

        if (!empty($CurrentQueue)) {
            $ActualCount = count($CurrentQueue);
            $DemolishedQueue = count($CurrentQueue);
            foreach ($this->getQueueData()['queue'] as $QueueInfo) {
                if ($QueueInfo['destroy'])

                    $DemolishedQueue = $DemolishedQueue - 2;
                $DemolishedQueue = max(0, $DemolishedQueue);
            }
        } else {
            $CurrentQueue = array();
            $ActualCount = 0;
        }

        $CurrentMaxFields = CalculateMaxPlanetFields($PLANET);

        $config = Config::get();

        if (($config->max_queue_build != 0 && $ActualCount == $config->max_queue_build)
            || ($AddMode && $PLANET["field_current"] >= ($CurrentMaxFields - $DemolishedQueue))) {
            return;
        }

        $BuildMode = $AddMode ? 'build' : 'destroy';
        $BuildLevel = $PLANET[$resource[$Element]] + (int)$AddMode;

        if ($ActualCount == 0) {
            if ($pricelist[$Element]['max'] < $BuildLevel)
                return;

            $costResources = BuildFunctions::getElementPrice($USER, $PLANET, $Element, !$AddMode, $BuildLevel);

            if (!BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources))
                return;

            if (isset($costResources[RESS_METAL])) {
                $PLANET[$resource[RESS_METAL]] -= $costResources[RESS_METAL];
            }
            if (isset($costResources[RESS_CRYSTAL])) {
                $PLANET[$resource[RESS_CRYSTAL]] -= $costResources[RESS_CRYSTAL];
            }
            if (isset($costResources[RESS_DEUTERIUM])) {
                $PLANET[$resource[RESS_DEUTERIUM]] -= $costResources[RESS_DEUTERIUM];
            }
            if (isset($costResources[RESS_DARKMATTER])) {
                $USER[$resource[RESS_DARKMATTER]] -= $costResources[RESS_DARKMATTER];
            }

            $elementTime = BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
            $BuildEndTime = TIMESTAMP + $elementTime;

            $PLANET['b_building_id'] = serialize(array(array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode)));
            $PLANET['b_building'] = $BuildEndTime;

        } else {
            $addLevel = 0;
            foreach ($CurrentQueue as $QueueSubArray) {
                if ($QueueSubArray[0] != $Element)
                    continue;

                if ($QueueSubArray[4] == 'build')
                    $addLevel++;
                else
                    $addLevel--;
            }

            $BuildLevel += $addLevel;

            if (!$AddMode && $BuildLevel == 0)
                return;

            if ($pricelist[$Element]['max'] < $BuildLevel)
                return;

            $elementTime = BuildFunctions::getBuildingTime($USER, $PLANET, $Element, NULL, !$AddMode, $BuildLevel);
            $BuildEndTime = $CurrentQueue[$ActualCount - 1][3] + $elementTime;
            $CurrentQueue[] = array($Element, $BuildLevel, $elementTime, $BuildEndTime, $BuildMode);
            $PLANET['b_building_id'] = serialize($CurrentQueue);
        }

    }

    private function getQueueData()
    {
        global $LNG, $PLANET, $USER;

        $scriptData = array();
        $quickinfo = array();

        if ($PLANET['b_building'] == 0 || $PLANET['b_building_id'] == "")
            return array('queue' => $scriptData, 'quickinfo' => $quickinfo);

        $buildQueue = unserialize($PLANET['b_building_id']);

        foreach ($buildQueue as $BuildArray) {
            if ($BuildArray[3] < TIMESTAMP)
                continue;

            $quickinfo[$BuildArray[0]] = $BuildArray[1];

            $scriptData[] = array(
                'element' => $BuildArray[0],
                'level' => $BuildArray[1],
                'time' => $BuildArray[2],
                'resttime' => ($BuildArray[3] - TIMESTAMP),
                'darkmattercost' => $this->getFinishCost($BuildArray),
                'destroy' => ($BuildArray[4] == 'destroy'),
                'endtime' => _date('U', $BuildArray[3], $USER['timezone']),
                'display' => _date($LNG['php_tdformat'], $BuildArray[3], $USER['timezone']),
            );
        }

        return array('queue' => $scriptData, 'quickinfo' => $quickinfo);
    }

    protected function getFinishCost($item)
    {
        return ceil(max(($item[3] - TIMESTAMP) / 60, 1))*10;
    }

    protected function FinishBuilding()
    {

        global $PLANET, $USER, $resource, $LNG;
        $CurrentQueue = unserialize($PLANET['b_building_id']);
        if (empty($CurrentQueue)) {
            $PLANET['b_building_id'] = '';
            $PLANET['b_building'] = 0;
            return false;
        }
        $cost = $this->getFinishCost($CurrentQueue[0]);
        if ($USER[$resource[RESS_DARKMATTER]] >= $cost) {
            $USER[$resource[RESS_DARKMATTER]] -= $cost;
            Notifier::get()->addNotification($LNG['instant_build'], $LNG['not_enough_darkmatter']);
        } else {
            return false;
        }

        $CurrentQueue[0][3] = TIMESTAMP;

        $PLANET['b_building'] = TIMESTAMP;
        $PLANET['b_building_id'] = serialize($CurrentQueue);
        $this->ecoObj->setData($USER, $PLANET);
        list($USER, $PLANET) = $this->ecoObj->getData();
        return true;
    }

    public function show()
    {
        global $ProdGrid, $LNG, $resource, $reslist, $PLANET, $USER, $pricelist;

        $TheCommand = HTTP::_GP('cmd', '');

        // wellformed buildURLs
        if (!empty($TheCommand) && $_SERVER['REQUEST_METHOD'] === 'POST' && $USER['urlaubs_modus'] == 0) {
            $Element = HTTP::_GP('building', 0);
            $ListID = HTTP::_GP('listid', 0);

            switch ($TheCommand) {
                case 'cancel':
                    $this->CancelBuildingFromQueue();
                    break;
                case 'remove':
                    $this->RemoveBuildingFromQueue($ListID);
                    break;
                case 'insert':
                    $this->AddBuildingToQueue($Element, true);
                    break;
                case 'destroy':
                    $this->AddBuildingToQueue($Element, false);
                    break;
                case 'pay':
                    $this->FinishBuilding();
                    break;
            }

            //$this->redirectTo('game.php?page=buildings');
        }

        $config = Config::get();

        $queueData = $this->getQueueData();
        $Queue = $queueData['queue'];
        $QueueCount = count($Queue);

        $QueueDestroy = $QueueCount;
        foreach ($Queue as $QueueInfo) {
            if ($QueueInfo['destroy'])

                $QueueDestroy = $QueueDestroy - 2;
            $QueueDestroy = max(0, $QueueDestroy);
        }

        $CanBuildElement = isVacationMode($USER) || $config->max_queue_build == 0 || $QueueCount < $config->max_queue_build;
        $CurrentMaxFields = CalculateMaxPlanetFields($PLANET);

        $RoomIsOk = $PLANET['field_current'] < ($CurrentMaxFields - $QueueDestroy);

        $BuildEnergy = $USER[$resource[ENERGY_TECH]];
        $BuildLevelFactor = 10;
        $BuildTemp = $PLANET['temp_max'];

        $BuildInfoList = array();
        $Elements = $reslist['allow'][$PLANET['planet_type']];
        $this->computeResourceTable(); // needed for cost overflowtime

        foreach ($Elements as $Element) {
            if (!BuildFunctions::isTechnologyAccessible($USER, $PLANET, $Element))
                continue;

            $infoEnergy = "";

            if (isset($queueData['quickinfo'][$Element])) {
                $levelToBuild = $queueData['quickinfo'][$Element];
            } else {
                $levelToBuild = $PLANET[$resource[$Element]];
            }

            if (in_array($Element, $reslist['prod'])) {
                $BuildLevel = $PLANET[$resource[$Element]];
                $Need = eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][RESS_ENGERGY], $Element));

                $BuildLevel = $levelToBuild + 1;
                $Prod = eval(ResourceUpdate::getProd($ProdGrid[$Element]['production'][RESS_ENGERGY], $Element));

                $requireEnergy = $Prod - $Need;
                $requireEnergy = round($requireEnergy * $config->energy_multiplier);

                if ($requireEnergy < 0) {
                    $infoEnergy = sprintf($LNG['bd_need_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][RESS_ENGERGY]);
                } else {
                    $infoEnergy = sprintf($LNG['bd_more_engine'], pretty_number(abs($requireEnergy)), $LNG['tech'][RESS_ENGERGY]);
                }
            }

            $costResources = BuildFunctions::getElementPrice($USER, $PLANET, $Element, false, $levelToBuild + 1);
            $costOverflow = BuildFunctions::getRestPrice($USER, $PLANET, $Element, $costResources);


            $elementTime = BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $costResources);
            $destroyResources = BuildFunctions::getElementPrice($USER, $PLANET, $Element, true);
            $destroyTime = BuildFunctions::getBuildingTime($USER, $PLANET, $Element, $destroyResources);
            $destroyOverflow = BuildFunctions::getRestPrice($USER, $PLANET, $Element, $destroyResources);
            $buyable = $QueueCount != 0 || BuildFunctions::isElementBuyable($USER, $PLANET, $Element, $costResources);
            $costOverflowTime = BuildFunctions::getOverflowTime($costOverflow, $this->resourceTable);

            $BuildInfoList[$Element] = array(
                'level' => $PLANET[$resource[$Element]],
                'maxLevel' => $pricelist[$Element]['max'],
                'infoEnergy' => $infoEnergy,
                'costResources' => $costResources,
                'costOverflow' => $costOverflow,
                'elementTime' => $elementTime,
                'costOverflowTime' => $costOverflowTime,
                'destroyResources' => $destroyResources,
                'destroyTime' => $destroyTime,
                'destroyOverflow' => $destroyOverflow,
                'buyable' => $buyable,
                'levelToBuild' => $levelToBuild,

            );
        }


        if ($QueueCount != 0) {
            $this->tplObj->loadscript('buildlist.js');
        }

        $this->assign(array(
            'BuildInfoList' => $BuildInfoList,
            'CanBuildElement' => $CanBuildElement,
            'RoomIsOk' => $RoomIsOk,
            'fields_percentage' => round($PLANET['field_current']*100/$CurrentMaxFields),
            'fields_current' => $PLANET['field_current'],
            'fields_max' => $CurrentMaxFields,
            'Queue' => $Queue,
            'isBusy' => array('shipyard' => !empty($PLANET['b_hangar_id']), 'research' => $USER['b_tech_planet'] != 0),
            'HaveMissiles' => (bool)$PLANET[$resource[503]] + $PLANET[$resource[502]],
        ));

        $this->display('page.buildings.default.tpl');
    }
}
