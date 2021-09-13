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
class Config
{
    private static $universeConfig = [];
    //array('uni' => 'integer', 'users_amount' => 'integer', 'game_speed' => 'integer', 'fleet_speed' => 'integer', 'resource_multiplier' => 'integer', 'storage_multiplier' => 'integer',  'halt_speed' => 'integer', 'Fleet_Cdr' => 'integer', 'Defs_Cdr' => 'integer', 'initial_fields' => 'integer', 'uni_name' => 'string', 'game_disable' => 'integer', 'close_reason' => 'string', 'metal_basic_income' => 'integer', 'crystal_basic_income' => 'integer', 'deuterium_basic_income' => 'integer', 'energy_basic_income' => 'integer', 'LastSettedGalaxyPos' => 'integer', 'LastSettedSystemPos' => 'integer', 'LastSettedPlanetPos' => 'integer', 'noobprotection' => 'integer', 'noobprotectiontime' => 'integer', 'noobprotectionmulti' => 'integer', 'forum_url' => 'string', 'adm_attack' => 'integer', 'debug' => 'integer', 'lang' => 'string', 'stat' => 'integer', 'stat_level' => 'integer', 'stat_last_update' => 'integer', 'stat_settings' => 'integer', 'stat_update_time' => 'integer', 'stat_last_db_update' => 'integer', 'stats_fly_lock' => 'integer', 'cron_lock' => 'integer', 'ts_modon' => 'integer', 'ts_server' => 'string', 'ts_tcpport' => 'integer', 'ts_udpport' => 'integer', 'ts_timeout' => 'integer', 'ts_version' => 'integer', 'ts_cron_last' => 'integer', 'ts_cron_interval' => 'integer', 'ts_login' => 'string', 'ts_password' => 'string', 'reg_closed' => 'integer', 'OverviewNewsFrame' => 'integer', 'OverviewNewsText' => 'string', 'capaktiv' => 'integer', 'cappublic' => 'string', 'capprivate' => 'string', 'min_build_time' => 'integer', 'mail_active' => 'integer', 'mail_use' => 'integer', 'smtp_host' => 'string', 'smtp_port' => 'integer', 'smtp_user' => 'string', 'smtp_pass' => 'string', 'smtp_ssl' => 'string', 'smtp_sendmail' => 'string', 'smail_path' => 'string', 'user_valid' => 'integer', 'fb_on' => 'integer', 'fb_apikey' => 'string', 'fb_skey' => 'string', 'ga_active' => 'string', 'ga_key' => 'string', 'moduls' => 'string', 'trade_allowed_ships' => 'string', 'trade_charge' => 'string', 'chat_closed' => 'integer', 'chat_allowchan' => 'integer', 'chat_allowmes' => 'integer', 'chat_allowdelmes' => 'integer', 'chat_logmessage' => 'integer', 'chat_nickchange' => 'integer', 'chat_botname' => 'string', 'chat_channelname' => 'string', 'chat_socket_active' => 'integer', 'chat_socket_host' => 'string', 'chat_socket_ip' => 'string', 'chat_socket_port' => 'integer', 'chat_socket_chatid' => 'integer', 'max_galaxy' => 'integer', 'max_system' => 'integer', 'max_planets' => 'integer', 'planet_factor' => 'float', 'max_elements_build' => 'integer', 'max_elements_tech' => 'integer', 'max_elements_ships' => 'integer', 'min_player_planets' => 'integer', 'planets_tech' => 'integer', 'planets_officier' => 'integer', 'planets_per_tech' => 'float', 'max_fleet_per_build' => 'integer', 'deuterium_cost_galaxy' => 'integer', 'max_dm_missions' => 'integer', 'max_overflow' => 'float', 'moon_factor' => 'float', 'moon_chance' => 'integer', 'darkmatter_cost_trader' => 'integer', 'factor_university' => 'integer', 'max_fleets_per_acs' => 'integer', 'debris_moon' => 'integer', 'vmode_min_time' => 'integer', 'gate_wait_time' => 'integer', 'metal_start' => 'integer', 'crystal_start' => 'integer', 'deuterium_start' => 'integer', 'darkmatter_start' => 'integer', 'ttf_file' => 'string', 'ref_active' => 'integer', 'ref_bonus' => 'integer', 'ref_minpoints' => 'integer', 'ref_max_referals' => 'integer', 'del_oldstuff' => 'integer', 'del_user_manually' => 'integer', 'del_user_automatic' => 'integer', 'del_user_sendmail' => 'integer', 'sendmail_inactive' => 'integer', 'silo_factor' => 'integer', 'timezone' => 'string', 'dst' => 'string', 'energySpeed' => 'integer', 'disclamerAddress' => 'string', 'disclamerPhone' => 'string', 'disclamerMail' => 'string', 'disclamerNotice' => 'string', 'alliance_create_min_points' => 'integer', 'coinpot_start' => 'integer', 'coinpot_increase' => 'integer', 'referral_earn' => 'float', 'coinpot_wait_minutes' => 'integer', 'coinpot_random_minutes' => 'integer',);
    private static $serverConfigItems = [
        'game_name' => 'string', 'font_path' => 'string', 'timezone' => 'string',
        'delete_age_messages' => 'integer', 'delete_age_users' => 'integer', 'delete_age_inactive' => 'integer',
        'reminder_active' => 'boolean', 'reminder_wait_time' => 'integer',
        'recaptcha_active' => 'boolean', 'recaptcha_public_key' => 'string', 'recaptcha_private_key' => 'string',
        'mail_active' => 'boolean', 'mail_delivery_type' => 'enum', 'mail_sender' => 'string',
        'mail_smtp_host' => 'string', 'mail_smtp_encryption' => 'string', 'mail_smtp_port' => 'integer',
        'mail_smtp_username' => 'string', 'mail_smtp_password' => 'string',
        'google_analytics_active' => 'boolean', 'google_analytics_key' => 'string'
    ]; //
    private $specialTypes = [];
    //array('VERSION' => 'string', 'sql_revision' => 'integer', 'users_amount' => 'integer', 'game_speed' => 'integer', 'fleet_speed' => 'integer', 'resource_multiplier' => 'integer', 'storage_multiplier' => 'integer', 'message_delete_behavior' => 'integer', 'message_delete_days' => 'integer', 'halt_speed' => 'integer', 'Fleet_Cdr' => 'integer', 'Defs_Cdr' => 'integer', 'initial_fields' => 'integer', 'uni_name' => 'string', 'game_name' => 'string', 'game_disable' => 'integer', 'close_reason' => 'string', 'metal_basic_income' => 'integer', 'crystal_basic_income' => 'integer', 'deuterium_basic_income' => 'integer', 'energy_basic_income' => 'integer', 'LastSettedGalaxyPos' => 'integer', 'LastSettedSystemPos' => 'integer', 'LastSettedPlanetPos' => 'integer', 'noobprotection' => 'integer', 'noobprotectiontime' => 'integer', 'noobprotectionmulti' => 'integer', 'forum_url' => 'string', 'adm_attack' => 'integer', 'debug' => 'integer', 'lang' => 'string', 'stat' => 'integer', 'stat_level' => 'integer', 'stat_last_update' => 'integer', 'stat_settings' => 'integer', 'stat_update_time' => 'integer', 'stat_last_db_update' => 'integer', 'stats_fly_lock' => 'integer', 'cron_lock' => 'integer', 'ts_modon' => 'integer', 'ts_server' => 'string', 'ts_tcpport' => 'integer', 'ts_udpport' => 'integer', 'ts_timeout' => 'integer', 'ts_version' => 'integer', 'ts_cron_last' => 'integer', 'ts_cron_interval' => 'integer', 'ts_login' => 'string', 'ts_password' => 'string', 'reg_closed' => 'integer', 'OverviewNewsFrame' => 'integer', 'OverviewNewsText' => 'string', 'capaktiv' => 'integer', 'cappublic' => 'string', 'capprivate' => 'string', 'min_build_time' => 'integer', 'mail_active' => 'integer', 'mail_use' => 'integer', 'smtp_host' => 'string', 'smtp_port' => 'integer', 'smtp_user' => 'string', 'smtp_pass' => 'string', 'smtp_ssl' => 'string', 'smtp_sendmail' => 'string', 'smail_path' => 'string', 'user_valid' => 'integer', 'fb_on' => 'integer', 'fb_apikey' => 'string', 'fb_skey' => 'string', 'ga_active' => 'string', 'ga_key' => 'string', 'moduls' => 'string', 'trade_allowed_ships' => 'string', 'trade_charge' => 'string', 'chat_closed' => 'integer', 'chat_allowchan' => 'integer', 'chat_allowmes' => 'integer', 'chat_allowdelmes' => 'integer', 'chat_logmessage' => 'integer', 'chat_nickchange' => 'integer', 'chat_botname' => 'string', 'chat_channelname' => 'string', 'chat_socket_active' => 'integer', 'chat_socket_host' => 'string', 'chat_socket_ip' => 'string', 'chat_socket_port' => 'integer', 'chat_socket_chatid' => 'integer', 'max_galaxy' => 'integer', 'max_system' => 'integer', 'max_planets' => 'integer', 'planet_factor' => 'float', 'max_elements_build' => 'integer', 'max_elements_tech' => 'integer', 'max_elements_ships' => 'integer', 'min_player_planets' => 'integer', 'planets_tech' => 'integer', 'planets_officier' => 'integer', 'planets_per_tech' => 'float', 'max_fleet_per_build' => 'integer', 'deuterium_cost_galaxy' => 'integer', 'max_dm_missions' => 'integer', 'max_overflow' => 'float', 'moon_factor' => 'float', 'moon_chance' => 'integer', 'darkmatter_cost_trader' => 'integer', 'factor_university' => 'integer', 'max_fleets_per_acs' => 'integer', 'debris_moon' => 'integer', 'vmode_min_time' => 'integer', 'gate_wait_time' => 'integer', 'metal_start' => 'integer', 'crystal_start' => 'integer', 'deuterium_start' => 'integer', 'darkmatter_start' => 'integer', 'ttf_file' => 'string', 'ref_active' => 'integer', 'ref_bonus' => 'integer', 'ref_minpoints' => 'integer', 'ref_max_referals' => 'integer', 'del_oldstuff' => 'integer', 'del_user_manually' => 'integer', 'del_user_automatic' => 'integer', 'del_user_sendmail' => 'integer', 'sendmail_inactive' => 'integer', 'silo_factor' => 'integer', 'timezone' => 'string', 'dst' => 'string', 'energySpeed' => 'integer', 'disclamerAddress' => 'string', 'disclamerPhone' => 'string', 'disclamerMail' => 'string', 'disclamerNotice' => 'string', 'alliance_create_min_points' => 'integer', 'coinpot_start' => 'integer', 'coinpot_increase' => 'integer', 'referral_earn' => 'float', 'coinpot_wait_minutes' => 'integer', 'coinpot_random_minutes' => 'integer',);
    protected $configData = array();
    protected $updateRecords = array();
    protected static $instances = array();

    public static function getServerConfigKeys()
    {
        return self::$serverConfigItems;
    }

    public static function getConfigParameters()
    {
        return self::$universeConfig;
    }

    // Global configkeys
    // could be unneeded
    /*protected static $globalConfigKeys = array('VERSION', 'game_name', 'stat', 'stat_level', 'stat_last_update',
        'stat_settings', 'stat_update_time', 'stat_last_db_update', 'stats_fly_lock',
        'cron_lock', 'ts_modon', 'ts_server', 'ts_tcpport', 'ts_udpport', 'ts_timeout',
        'ts_version', 'ts_cron_last', 'ts_cron_interval', 'ts_login', 'ts_password',
        'capaktiv', 'cappublic', 'capprivate', 'mail_active', 'mail_use', 'smtp_host',
        'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_ssl', 'smtp_sendmail',
        'smail_path', 'fb_on', 'fb_apikey', 'fb_skey', 'ga_active', 'ga_key',
        'chat_closed', 'chat_allowchan', 'chat_allowmes', 'chat_allowdelmes',
        'chat_logmessage', 'chat_nickchange', 'chat_botname', 'chat_channelname',
        'chat_socket_active', 'chat_socket_host', 'chat_socket_ip', 'chat_socket_port',
        'chat_socket_chatid', 'ttf_file', 'sendmail_inactive', 'del_user_sendmail',
        'del_user_automatic', 'del_oldstuff', 'del_user_manually', 'ref_max_referals',
        'disclamerAddress', 'disclamerPhone', 'disclamerMail', 'disclamerNotice');*/
    private $universeId;

    /*public static function getGlobalConfigKeys()
    {
        return self::$globalConfigKeys;
    }*/

    static public function getServer()
    {
        if (empty(self::$instances))
            self::generateInstances();
        return self::$instances[0];
    }

    /**
     * Return an config object for the requested universe
     *
     * @param int $universe Universe ID
     *
     * @return Config
     */

    static public function get($universe = 0)
    {
        if (empty(self::$instances)) {
            self::generateInstances();
        }

        if ($universe === 0) {
            $universe = Universe::current();
        }

        if (!isset(self::$instances[$universe])) {
            throw new Exception("Unknown universe id: " . $universe);
        }

        return self::$instances[$universe];
    }

    static public function reload()
    {
        self::generateInstances();
    }

    static protected function importOldConfig()
    {
        $db = Database::get();

        $tbl = [];
        $sql = "select column_name,data_type from information_schema.columns where table_name = '%%CONFIG%%'";
        foreach ($db->select($sql) as $item) {
            switch ($item['data_type']) {
                case "int":
                case "bigint":
                case "smallint":
                case "tinyint":
                    $tbl[$item['column_name']] = "integer";
                    break;
                case "float":
                    $tbl[$item['column_name']] = "float";
                    break;
                default:
                    $tbl[$item['column_name']] = "string";
                    break;
            }

        }

        $sql = "SELECT * from %%CONFIG%%;";
        foreach ($db->select($sql) as $item) {
            self::$instances[$item['uni']] = new self($item['uni']);

            foreach ($item as $column => $value) {
                self::$universeConfig[$column] = $tbl[$column];
                self::$instances[$item['uni']]->addItem(["config_type" => $tbl[$column], "config_key" => $column, "config_value" => $value]);
            }
            self::$instances[$item['uni']]->save(true);
        }
    }

    static protected function getServerConfig()
    {
        return self::$instances[0];
    }

    static private function generateInstances()
    {
        $db = Database::get();

        // create server config
        self::$instances[0] = new self(0);

        $configResult = $db->Select("SELECT * FROM %%CONFIGURATION%%;");
        if (empty($configResult)) {
            // import from old mechanism
            self::importOldConfig();

        }
        foreach ($configResult as $configRow) {
            if (!isset(self::$instances[$configRow['universe_id']]))
                self::$instances[$configRow['universe_id']] = new self($configRow['universe_id']);
            self::$instances[$configRow['universe_id']]->addItem($configRow);
        }
        foreach (array_keys(self::$instances) as $universe) {
            if ($universe > 0)
                Universe::add($universe);
        }

    }

    protected function addItem($configRow)
    {
        switch ($configRow['config_type']) {
            case 'float':
                $value = floatval($configRow['config_value']);
                break;
            case 'integer':
                $value = intval($configRow['config_value']);
                break;
            case 'boolean':
                $value = boolval($configRow['config_value']);
            default:
                $value = $configRow['config_value'];
                break;
        }
        $this->configData[$configRow['config_key']] = $value;

    }

    public function __construct($universeId)
    {
        $this->universeId = $universeId;
        $this->specialTypes = self::$serverConfigItems + self::$universeConfig;
    }

    public function __get($key)
    {
        if (!isset($this->configData[$key])) {
            throw new UnexpectedValueException(sprintf("Unknown configuration key %s!", $key));
        }

        return $this->configData[$key];
    }

    public function __set($key, $value)
    {
        $this->updateRecords[] = $key;
        $this->configData[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->configData[$key]);
    }

    public function save($storeAll = false)
    {
        if ($storeAll) {
            $this->updateRecords = array_keys(self::$specialTypes);
        }

        $db = Database::get();
        foreach ($this->updateRecords as $columnName) {
            $sql = "INSERT INTO %%CONFIGURATION%% (universe_id, config_key, config_type, config_value) VALUES(:universeId, :configKey, :configType, :configValue) ON DUPLICATE KEY UPDATE config_value = :configValue";
            $db->insert($sql, [":universeId" => $this->universeId, ":configKey" => $columnName, ":configType" => $this->getType($columnName), ":configValue" => $this->configData[$columnName]]);
        }

        $this->updateRecords = array();
        return true;
    }

    protected function getType($columnName)
    {
        if (in_array($columnName, array_keys($this->specialTypes))) {
            return $this->specialTypes[$columnName];
        } else {
            return "string";
        }
    }

    public function getConfigAsArray(): array
    {
        return $this->configData;
    }

    static function getAll()
    {
        throw new Exception("Config::getAll is deprecated!");
    }
}
