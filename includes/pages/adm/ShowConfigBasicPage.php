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

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) throw new Exception("Permission error!");

function ShowConfigBasicPage()
{
    global $LNG;
    $config = Config::getServer();

    if (!empty($_POST)) {
        foreach (Config::getServerConfigKeys() as $key => $type) {
            if ($type === "boolean") {
                $config->$key = HTTP::_GP($key, '') == "on";
            } else {
                $config->$key = HTTP::_GP($key, '', true);
            }
        }
        $config->save();


        $LOG = new Log(3);
        $LOG->target = 0;
        $LOG->new = [];//$config->configData;
        $LOG->old = [];
        $LOG->save();
    }

    $TimeZones = get_timezone_selector();

    $template = new template();

    $template->assign_vars(array(
        'server_config' => Config::getServerConfigKeys(),
        'current_config' => $config->getConfigAsArray(),
        'Selector' => array(
            'timezone' => $TimeZones,
            'mail' => $LNG['se_mail_sel'],
            'encry' => array('' => $LNG['se_smtp_ssl_1'], 'ssl' => $LNG['se_smtp_ssl_2'], 'tls' => $LNG['se_smtp_ssl_3']),
            'message_delete_behavior' => array(0 => $LNG['se_message_delete_behavior_0'], 1 => $LNG['se_message_delete_behavior_1']),
        ),
    ));

    $template->show('ConfigBasicBody.tpl');
}
