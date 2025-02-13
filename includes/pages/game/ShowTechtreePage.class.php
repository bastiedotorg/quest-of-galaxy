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


class ShowTechtreePage extends AbstractGamePage
{
    public static $requireModule = MODULE_TECHTREE;

    function __construct()
    {
        parent::__construct();
    }

    function show()
    {
        global $resource, $requirements, $reslist, $USER, $PLANET, $LNG, $CombatCaps, $pricelist;

        $elementIDs		= array_merge(
            array(0),
            $reslist['build'],
            array(100),
            $reslist['tech'],
            array(200),
            $reslist['fleet'],
            array(400),
            $reslist['defense'],
            array(500),
            $reslist['missile'],
            array(600),
            $reslist['officier']
        );

        $techTreeList = array();
        $techTreeMap = array();
        $lastCategory = 0;
        foreach($elementIDs as $elementId)
        {
            if(!isset($resource[$elementId]))
            {
                $techTreeMap[$elementId] = [];
                $lastCategory = $elementId;
                $techTreeList[$elementId]	= $elementId;
            }
            else
            {
                $requirementsList	= array();
                if(isset($requirements[$elementId]))
                {
                    foreach($requirements[$elementId] as $requireID => $RedCount)
                    {
                        $requirementsList[$requireID]	= array(
                            'count' => $RedCount,
                            'own'   => isset($PLANET[$resource[$requireID]]) ? $PLANET[$resource[$requireID]] : $USER[$resource[$requireID]]
                        );
                    }
                }
                $techTreeMap[$lastCategory][$elementId] = $requirementsList;
                $techTreeList[$elementId]	= $requirementsList;
            }
        }
        $this->assign(array(
            'TechTreeList'		=> $techTreeList,
            'TechTreeMap'		=> $techTreeMap,
            'ships'             => $reslist['fleet'],
            'CombatCaps'        => $CombatCaps,
            'priceList'         => $pricelist,

        ));

        $this->display('page.techTree.default.tpl');
    }
}
