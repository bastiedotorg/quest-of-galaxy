<?php

class Runtime
{
    protected static $instances = [];
    protected $universeId = 0;
    protected $values = [
        'statistics',
        'statistics_level',
        'statistics_last_update',
        'statistics_settings',
        'statistics_update_time',
        'statistics_last_db_update',
        'statistics_fly_lock',
        'users_amount',

        'latest_galaxy_position',
        'latest_system_position',
        'latest_planet_position',
        'cron_lock',

        'coins_in',
        'coins_out'
    ];
    protected $items = [];

    public static function get($universeId)
    {
        if (!isset(self::$instances[$universeId])) {
            self::$instances[$universeId] = new self($universeId);
        }
        return self::$instances[$universeId];
    }

    protected function initialize()
    {
        foreach ($this->values as $value) {
            if (!isset($this->items[$value])) {
                $sql = "INSERT INTO %%STATISTICS%% (stat_key, stat_value, universe_id) VALUES(:statKey, :statValue, :universeId)";
                Database::get()->insert($sql, [":statKey" => $value, ":statValue" => 0, ":universeId" => $this->universeId]);
            }
        }
    }

    protected function __construct($universeId)
    {
        $this->universeId = $universeId;
        $sql = "SELECT * FROM %%STATISTICS%% WHERE `universeId` = :universeId";
        $data = Database::get()->select($sql, [":universeId" => $this->universeId]);
        foreach ($data as $item) {
            $this->items[$item['stat_key']] = $item['stat_value'];
        }
        if(sizeof($this->items) < $this->values) {
            $this->initialize();
        }
    }

    public function add($statKey, $add_amount)
    {
        $sql = "UPDATE %%STATISTICS%% SET `stat_value` = `stat_value` + :addAmount WHERE `stat_key`=:statKey AND universeId = :universeId";
        return Database::get()->update($sql, [":addAmount" => $add_amount, ":statKey" => $statKey, ":universeId" => $this->universeId]);
    }

    public function set($statKey, $set_amount)
    {
        $sql = "UPDATE %%STATISTICS%% SET `stat_value` = :setAmount WHERE `stat_key`=:statKey AND universeId = :universeId";
        return Database::get()->update($sql, [":addAmount" => $set_amount, ":statKey" => $statKey, ":universeId" => $this->universeId]);
    }

    public function item($statKey)
    {
        return $this->items[$statKey];
    }
}