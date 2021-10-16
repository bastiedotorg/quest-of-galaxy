<?php

class AbstractAdminPage extends AbstractPage {
    protected $tplDir = "adm";

    public function baseAssign() {

        $this->assign(array(
            'game_name' => Config::get()->game_name,
            'supportticks' => 0,
            'Messages' => [],
        ));

    }
}