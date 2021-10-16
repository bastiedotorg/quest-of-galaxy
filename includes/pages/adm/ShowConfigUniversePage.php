<?php

class ShowConfigUniversePage extends AbstractAdminPage
{
    public function show()
    {
        $this->assign([
            'config_vars' => Config::getConfigParameters(),
            'config' => Config::get(),
        ]);
        $this->display('configuration_universe.tpl');
    }
}