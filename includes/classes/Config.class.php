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
    private static $universeConfigItems = [
        'game_speed' => ["default" => 2500, "type" => 'integer'],
        'fleet_speed' => ["default" => 2500, "type" => 'float'],
        'resource_multiplier' => ["default" => 1, "type" => 'float'],
        'storage_multiplier' => ["default" => 1, "type" => 'float'],
        'energy_multiplier' => ["default" => 1.0, "type" => 'float'],
        'halt_speed' => ["default" => 1, "type" => 'integer'],
        'debris_fleet' => ["default" => 30, "type" => 'integer'],
        'debris_defensive' => ["default" => 0, "type" => 'integer'],
        'initial_fields' => ["default" => 165, "type" => 'integer'],
        'universe_name' => ["default" => "Universe", "type" => 'string'],
        'universe_active' => ["default" => true, "type" => 'boolean'],
        'registration_closed' => ["default" => false, "type" => 'boolean'],
        'close_reason' => ["default" => "", "type" => 'string'],
        'forum_url' => ["default" => "", "type" => 'string'],

        'referral_active' => ["default" => true, "type" => 'boolean'],
        'referral_earn' => ["default" => 0.05, "type" => 'float'],
        'referral_bonus' => ["default" => 100, "type" => 'integer'],
        'referral_min_points' => ["default" => 1000, "type" => 'integer'],
        'referral_max_referrals' => ["default" => 999, "type" => 'integer'],

        'metal_basic_income' => ["default" => 20, "type" => 'integer'],
        'crystal_basic_income' => ["default" => 10, "type" => 'integer'],
        'deuterium_basic_income' => ["default" => 0, "type" => 'integer'],
        'energy_basic_income' => ["default" => 0, "type" => 'integer'],

        'metal_start' => ["default" => 500, "type" => 'integer'],
        'crystal_start' => ["default" => 500, "type" => 'integer'],
        'deuterium_start' => ["default" => 0, "type" => 'integer'],
        'darkmatter_start' => ["default" => 0, "type" => 'integer'],

        'noob_protection_active' => ["default" => true, "type" => 'boolean'],
        'noob_protection_points' => ["default" => 5000, "type" => 'integer'],
        'noob_protection_multiplier' => ["default" => 5.0, "type" => 'float'],

        'bash_protection_active' => ["default" => true, "type" => 'boolean'],
        'bash_protection_number' => ["default" => 6, "type" => 'integer'],
        'bash_protection_time' => ["default" => 86400, "type" => 'integer'],

        'admin_attack' => ["default" => false, "type" => 'boolean'],
        'debug' => ["default" => false, "type" => 'boolean'],
        'language' => ["default" => "de", "type" => 'string'],

        'news_active' => ["default" => true, "type" => 'boolean'],
        'news_text' => ["default" => "", "type" => 'string'],

        'minimum_build_time' => ["default" => 1, "type" => 'integer'],
        'modules' => ["default" => "", "type" => 'string'],

        'trade_allowed_ships' => ["default" => "", "type" => 'string'],
        'trade_charge' => ["default" => 350, "type" => 'integer'],

        'maximum_galaxies' => ["default" => 10, "type" => 'integer'],
        'maximum_systems' => ["default" => 100, "type" => 'integer'],
        'maximum_planets' => ["default" => 15, "type" => 'integer'],

        'planet_initial_fields' => ["default" => 165, "type" => 'integer'],
        'planet_size_factor' => ["default" => 1.0, "type" => 'float'],

        'max_queue_build' => ["default" => 5, "type" => 'integer'],
        'max_queue_tech' => ["default" => 2, "type" => 'integer'],
        'max_queue_ships' => ["default" => 99, "type" => 'integer'],

        'min_player_planets' => ["default" => 1, "type" => 'integer'],

        'max_planets_tech' => ["default" => 15, "type" => 'integer'],
        'planets_per_tech' => ["default" => 0.5, "type" => 'float'],

        'max_planets_officer' => ["default" => 0, "type" => 'integer'],

        'max_fleet_per_build' => ["default" => 0, "type" => 'integer'],

        'deuterium_cost_galaxy' => ["default" => 10, "type" => 'integer'],

        'max_darkmatter_missions' => ["default" => 1, "type" => 'integer'],

        'max_resources_overflow' => ["default" => 3.0, "type" => 'float'],

        'moon_size_factor' => ["default" => 2.0, "type" => 'float'],
        'moon_chance' => ["default" => 20, "type" => 'integer'],

        'trader_darkmatter_cost' => ["default" => 350, "type" => 'integer'],

        'research_factor' => ["default" => 8, "type" => 'float'],

        'max_fleet_per_acs' => ["default" => 10, "type" => 'integer'],
        'delete_debris_with_moon' => ["default" => true, "type" => 'boolean'],

        'vacation_mode_minimum' => ["default" => 60 * 60 * 24 * 3, "type" => 'integer'],
        'gate_wait_time' => ["default" => 3600, "type" => 'integer'],

        'silo_factor' => ["default" => 1, "type" => 'integer'],

        'timezone' => ["default" => "Europe/Berlin", "type" => 'string'],
        'daylight_savings_time' => ["default" => true, "type" => 'boolean'],

        'coinpot_start' => ["default" => 1000, "type" => 'integer'],
        'coinpot_increase' => ["default" => 60, "type" => 'integer'],
        'coinpot_wait_minutes' => ["default" => 180, "type" => 'integer'],
        'coinpot_random_minutes' => ["default" => 60, "type" => 'integer']

    ];
    //array('uni' => 'integer', 'users_amount' => 'integer', 'game_speed' => 'integer', 'fleet_speed' => 'integer', 'resource_multiplier' => 'integer', 'storage_multiplier' => 'integer',  'halt_speed' => 'integer', 'Fleet_Cdr' => 'integer', 'Defs_Cdr' => 'integer', 'initial_fields' => 'integer', 'uni_name' => 'string', 'game_disable' => 'integer', 'close_reason' => 'string', 'metal_basic_income' => 'integer', 'crystal_basic_income' => 'integer', 'deuterium_basic_income' => 'integer', 'energy_basic_income' => 'integer', 'LastSettedGalaxyPos' => 'integer', 'LastSettedSystemPos' => 'integer', 'LastSettedPlanetPos' => 'integer', 'noobprotection' => 'integer', 'noobprotectiontime' => 'integer', 'noobprotectionmulti' => 'integer', 'forum_url' => 'string', 'adm_attack' => 'integer', 'debug' => 'integer', 'lang' => 'string', 'stat' => 'integer', 'stat_level' => 'integer', 'stat_last_update' => 'integer', 'stat_settings' => 'integer', 'stat_update_time' => 'integer', 'stat_last_db_update' => 'integer', 'stats_fly_lock' => 'integer', 'cron_lock' => 'integer', 'ts_modon' => 'integer', 'ts_server' => 'string', 'ts_tcpport' => 'integer', 'ts_udpport' => 'integer', 'ts_timeout' => 'integer', 'ts_version' => 'integer', 'ts_cron_last' => 'integer', 'ts_cron_interval' => 'integer', 'ts_login' => 'string', 'ts_password' => 'string', 'reg_closed' => 'integer', 'OverviewNewsFrame' => 'integer', 'OverviewNewsText' => 'string', 'capaktiv' => 'integer', 'cappublic' => 'string', 'capprivate' => 'string', 'min_build_time' => 'integer', 'mail_active' => 'integer', 'mail_use' => 'integer', 'smtp_host' => 'string', 'smtp_port' => 'integer', 'smtp_user' => 'string', 'smtp_pass' => 'string', 'smtp_ssl' => 'string', 'smtp_sendmail' => 'string', 'smail_path' => 'string', 'user_valid' => 'integer', 'fb_on' => 'integer', 'fb_apikey' => 'string', 'fb_skey' => 'string', 'ga_active' => 'string', 'ga_key' => 'string', 'moduls' => 'string', 'trade_allowed_ships' => 'string', 'trade_charge' => 'string', 'chat_closed' => 'integer', 'chat_allowchan' => 'integer', 'chat_allowmes' => 'integer', 'chat_allowdelmes' => 'integer', 'chat_logmessage' => 'integer', 'chat_nickchange' => 'integer', 'chat_botname' => 'string', 'chat_channelname' => 'string', 'chat_socket_active' => 'integer', 'chat_socket_host' => 'string', 'chat_socket_ip' => 'string', 'chat_socket_port' => 'integer', 'chat_socket_chatid' => 'integer', 'max_galaxy' => 'integer', 'max_system' => 'integer', 'max_planets' => 'integer', 'planet_factor' => 'float', 'max_elements_build' => 'integer', 'max_elements_tech' => 'integer', 'max_elements_ships' => 'integer', 'min_player_planets' => 'integer', 'planets_tech' => 'integer', 'planets_officier' => 'integer', 'planets_per_tech' => 'float', 'max_fleet_per_build' => 'integer', 'deuterium_cost_galaxy' => 'integer', 'max_dm_missions' => 'integer', 'max_overflow' => 'float', 'moon_factor' => 'float', 'moon_chance' => 'integer', 'darkmatter_cost_trader' => 'integer', 'factor_university' => 'integer', 'max_fleets_per_acs' => 'integer', 'debris_moon' => 'integer', 'vmode_min_time' => 'integer', 'gate_wait_time' => 'integer', 'metal_start' => 'integer', 'crystal_start' => 'integer', 'deuterium_start' => 'integer', 'darkmatter_start' => 'integer', 'ttf_file' => 'string', 'ref_active' => 'integer', 'ref_bonus' => 'integer', 'ref_minpoints' => 'integer', 'ref_max_referals' => 'integer', 'del_oldstuff' => 'integer', 'del_user_manually' => 'integer', 'del_user_automatic' => 'integer', 'del_user_sendmail' => 'integer', 'sendmail_inactive' => 'integer', 'silo_factor' => 'integer', 'timezone' => 'string', 'dst' => 'string', 'energySpeed' => 'integer', 'disclamerAddress' => 'string', 'disclamerPhone' => 'string', 'disclamerMail' => 'string', 'disclamerNotice' => 'string', 'alliance_create_min_points' => 'integer', 'coinpot_start' => 'integer', 'coinpot_increase' => 'integer', 'referral_earn' => 'float', 'coinpot_wait_minutes' => 'integer', 'coinpot_random_minutes' => 'integer',);
    private static $serverConfigItems = [
        'game_name' => ["default" => 'Quest of Galaxy', 'type' => 'string'],
        'game_disable' => ["default" => false, 'type' => 'boolean'],

        'font_path' => ["default" => 'styles/resource/fonts/DroidSansMono.ttf', 'type' => 'string'],
        'delete_age_messages' => ["default" => 30, 'type' => 'integer'],
        'delete_age_users' => ["default" => 7, 'type' => 'integer'],
        'delete_age_inactive' => ["default" => 60, 'type' => 'integer'],
        'reminder_active' => ["default" => true, 'type' => 'boolean'],
        'reminder_wait_time' => ["default" => 3, 'type' => 'integer'],
        'recaptcha_active' => ["default" => false, 'type' => 'boolean'],
        'recaptcha_public_key' => ["default" => '', 'type' => 'string'],
        'recaptcha_private_key' => ["default" => '', 'type' => 'string'],
        'mail_active' => ["default" => true, 'type' => 'boolean'],
        'mail_delivery_type' => ["default" => 'smtp', 'type' => 'string'],
        'mail_sender' => ["default" => '', 'type' => 'string'],
        'mail_smtp_host' => ["default" => 'localhost', 'type' => 'string'],
        'mail_smtp_encryption' => ["default" => 'ssl', 'type' => 'string'],
        'mail_smtp_port' => ["default" => 465, 'type' => 'integer'],
        'mail_smtp_username' => ["default" => '', 'type' => 'string'],
        'mail_smtp_password' => ["default" => '', 'type' => 'string'],
        'google_analytics_active' => ["default" => false, 'type' => 'boolean'],
        'google_analytics_key' => ["default" => '', 'type' => 'string'],
        'facebook_active' => ["default" => false, 'type' => 'boolean'],
        'facebook_api_key' => ["default" => '', 'type' => 'string'],
        'validate_mail_address' => ["default" => true, 'type' => 'boolean'],
        'VERSION'=>["default" => "2.0.1", "type" => "string"],

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
        return self::$universeConfigItems;
    }
    public static function getUniverseConfigItems() {
        return self::$universeConfigItems;
    }

    public static function getUniverseConfigKeys() {
        return array_keys(self::$universeConfigItems);
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
            self::$instances[$universe] = new self($universe);
            self::$instances[$universe]->loadDefaultConfig();
            //throw new Exception("Unknown universe id: " . $universe);
        }

        return self::$instances[$universe];
    }

    public function loadDefaultConfig() {
        foreach (self::$universeConfigItems as $key => $item) {
            self::$instances[0]->addItem(["config_key" => $key, "config_type" => $item['type'], "config_value" => $item['default']]);
        }

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
                self::$universeConfigItems[$column] = $tbl[$column];
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
        foreach (self::$serverConfigItems as $key => $item) {
            self::$instances[0]->addItem(["config_key" => $key, "config_type" => $item['type'], "config_value" => $item['default']]);
        }

        $configResult = $db->Select("SELECT * FROM %%CONFIGURATION%%;");
        if (empty($configResult)) {
            // import from old mechanism
            //self::importOldConfig();
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

    protected function getType($configType, $configValue)
    {
        switch ($configType) {
            case 'float':
                $value = floatval($configValue);
                break;
            case 'integer':
                $value = intval($configValue);
                break;
            case 'boolean':
                $value = boolval($configValue);
                break;
            default:
                $value = $configValue;
                break;

        }
        return $value;

    }

    protected function addItem($configRow)
    {
        $this->configData[$configRow['config_key']] = $this->getType($configRow['config_type'], $configRow['config_value']);
    }

    public function __construct($universeId)
    {
        $this->universeId = $universeId;
        $this->specialTypes = self::$serverConfigItems + self::$universeConfigItems;
    }

    public function __get($key)
    {
        if (isset($this->configData[$key])) {
            return $this->configData[$key];
        } else if (isset(self::$instances[0]->configData[$key])) { //return game configuration
            return self::$instances[0]->configData[$key];
        } else if (in_array($key, array_keys(self::$serverConfigItems))) {
            return $this->getType(self::$serverConfigItems[$key]['type'], self::$serverConfigItems[$key]['default']);
        } else if (in_array($key, array_keys(self::$universeConfigItems))) {
            return $this->getType(self::$universeConfigItems[$key]['type'], self::$universeConfigItems[$key]['default']);
        } else {
            throw new UnexpectedValueException(sprintf("Unknown configuration key %s!", $key));
        }

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
            $this->updateRecords = array_keys(self::$universeConfigItems);
        }

        $db = Database::get();
        foreach ($this->updateRecords as $columnName) {
            $sql = "INSERT INTO %%CONFIGURATION%% (universe_id, config_key, config_type, config_value) VALUES(:universeId, :configKey, :configType, :configValue) ON DUPLICATE KEY UPDATE config_value = :configValue";
            $db->insert($sql, [":universeId" => $this->universeId, ":configKey" => $columnName, ":configType" => $this->getTypeName($columnName), ":configValue" => $this->$columnName]);
        }

        $this->updateRecords = array();
        return true;
    }

    protected function getTypeName($columnName)
    {
        if (in_array($columnName, array_keys($this->specialTypes))) {
            return $this->specialTypes[$columnName]['type'];
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
