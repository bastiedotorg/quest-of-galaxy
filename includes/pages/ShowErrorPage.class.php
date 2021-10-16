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


class ShowErrorPage extends AbstractPage
{
    public static $requireModule = 0;
    protected $tplDir = 'login';

    protected $disableEcoSystem = true;

    function __construct()
    {
        parent::__construct();
        $this->initTemplate();
    }

    protected function printMessage($message, $redirectButtons = NULL, $redirect = NULL, $fullSide = true)
    {
        $this->assign(array(
            'message' => $message,
            'redirectButtons' => $redirectButtons,
        ));

        if (isset($redirect)) {
            $this->tplObj->gotoside($redirect[0], $redirect[1]);
        }

        if (!$fullSide) {
            $this->setWindow('popup');
        }

        $this->display('error.default.tpl');
    }

    static function printError($Message, $fullSide = true, $redirect = NULL)
    {
        $pageObj = new self;
        $pageObj->printMessage($Message, NULL, $redirect, $fullSide);
    }

    function show()
    {

    }
}
