<?php
/**
 *  Quest of Galaxy
 *   by Bastian Lüttig 2021
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package QuestOfGalaxy
 * @author Bastian Luettig <bastian.luettig@bastie.space>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 2.0.0
 * @link https://github.com/bastiedotorg/quest-of-galaxy
 */

class AbstractPage
{

    /**
     * reference of the template object
     * @var template
     */
    protected $tplObj;

    protected $window;
    protected $tplDir = 'login';

    public function __construct()
    {
        if (!AJAX_REQUEST) {
            $this->setWindow('full');
            $this->initTemplate();
        } else {
            $this->setWindow('ajax');
        }

    }
    protected function sendJSON($data)
    {
        $this->save();
        echo json_encode($data);
        exit;
    }

    protected function baseAssign() {

    }

    protected function initTemplate()
    {
        if (isset($this->tplObj))
            return true;

        $this->tplObj = new template;
        list($tplDir) = $this->tplObj->getTemplateDir();
        $this->tplObj->setTemplateDir($tplDir . $this->tplDir);
        return true;
    }

    protected function setWindow($window)
    {
        $this->window = $window;
    }

    protected function getWindow()
    {
        return $this->window;
    }

    protected function getQueryString()
    {
        $queryString = array();
        $page = HTTP::_GP('page', '');

        if (!empty($page)) {
            $queryString['page'] = $page;
        }

        $mode = HTTP::_GP('mode', '');
        if (!empty($mode)) {
            $queryString['mode'] = $mode;
        }

        return http_build_query($queryString);
    }


    protected function getPageData()
    {
        global $LNG, $THEME;

        $config = Config::get();
        $dateTimeServer = new DateTime("now");
        if (isset($this->user['timezone'])) {
            try {
                $dateTimeUser = new DateTime("now", new DateTimeZone($this->user['timezone']));
            } catch (Exception $e) {
                $dateTimeUser = $dateTimeServer;
            }
        } else {
            $dateTimeUser = $dateTimeServer;
        }

        $this->tplObj->assign_vars(array(
            'config' => $config,
            'lang' => $LNG->getLanguage(),
            'uni_name' => $config->universe_name,
            'game_name' => $config->game_name,
            'Offset' => $dateTimeUser->getOffset() - $dateTimeServer->getOffset(),
            'queryString' => $this->getQueryString(),
            'themeSettings' => $THEME->getStyleSettings(),
            'UNI' => Universe::current(),
            'REV' => substr($config->VERSION, -4),
            'languages' => Language::getAllowedLangs(false),
            'date' => explode("|", date('Y\|n\|j\|G\|i\|s\|Z', TIMESTAMP)),
            'isPlayerCardActive' => isModuleAvailable(MODULE_PLAYERCARD),

        ));
    }

    protected function printMessage($message, $redirectButtons = null, $redirect = null, $fullSide = true)
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

    protected function assign($array, $nocache = true)
    {
        $this->tplObj->assign_vars($array, $nocache);
    }

    protected function save()
    {
    }

    protected function display($file)
    {
        global $THEME, $LNG;

        $this->save();

        if ($this->getWindow() !== 'ajax') {
            $this->getPageData();
        }
        $this->baseAssign();

        $this->assign(array(
            'lang' => $LNG->getLanguage(),
            'dpath' => $THEME->getTheme(),
            'bodyclass'			=> $this->getWindow(),
            'isMultiUniverse'	=> count(Universe::availableUniverses()) > 1,
            'unisWildcast'		=> UNIS_WILDCAST,
            'scripts' => $this->tplObj->jsscript,
            'execscript' => implode("\n", $this->tplObj->script),
            'basepath' => PROTOCOL . HTTP_HOST . HTTP_BASE,
            'universeId' => Universe::current(),
        ));

        $this->assign(array(
            'LNG' => $LNG,
        ), false);

        $this->tplObj->display('extends:layout.' . $this->getWindow() . '.tpl|' . $file);
        exit;
    }

    public function dispatch() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->post();
        } else if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->get();
        }
    }

}