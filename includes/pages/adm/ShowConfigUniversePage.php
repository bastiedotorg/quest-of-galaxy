<?php

class ShowConfigUniversePage extends AbstractAdminPage
{
    public function post() {
        global $LNG;
        $config = Config::get($_POST['universe_id']);
        foreach(Config::getUniverseConfigItems() as $key => $value) {
            if(!in_array($key, $_POST) && $value['type'] === 'boolean') {
                $config->$key = false;
            }
            else {
                $config->$key = $_POST[$key];
            }
        }
        $config->save();
        $this->sendJSON(["message" => $LNG['config_saved']]);

    }


    public function get()
    {
        $this->assign([
            'config_vars' => Config::getConfigParameters(),
            'config' => Config::get(),
        ]);
        $this->display('configuration_universe.tpl');
    }
}