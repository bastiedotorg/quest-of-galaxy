<?php

class AbstractAlliancePage extends AbstractGamePage
{
    protected $allianceData;
    protected $ranks;
    protected $rights;
    public $availableRanks = array(
        'MEMBERLIST',
        'ONLINESTATE',
        'TRANSFER',
        'SEEAPPLY',
        'MANAGEAPPLY',
        'ROUNDMAIL',
        'ADMIN',
        'KICK',
        'DIPLOMATIC',
        'RANKS',
        'MANAGEUSERS',
        'EVENTS'
    );
    protected $hasAlliance = false;
    protected $hasApply = false;

    protected function isApply()
    {
        global $USER;
        $db = Database::get();
        $sql = "SELECT COUNT(*) as count FROM %%ALLIANCE_REQUEST%% WHERE userId = :userId;";
        return $db->selectSingle($sql, array(
            ':userId' => $USER['id']
        ), 'count');
    }

    public function __construct()
    {
        global $USER;
        parent::__construct();
        $this->hasAlliance = $USER['ally_id'] != 0;
        $this->hasApply = $this->isApply();
        if ($this->hasAlliance && !$this->hasApply) {
            $this->setAllianceData($USER['ally_id']);
        }
    }

    protected function setAllianceData($allianceId)
    {
        global $USER;
        $db = Database::get();

        $sql = 'SELECT * FROM %%ALLIANCE%% WHERE id = :allianceId;';
        $this->allianceData = $db->selectSingle($sql, array(
            ':allianceId' => $allianceId
        ));

        if ($USER['ally_id'] == $allianceId) {
            if ($this->allianceData['ally_owner'] == $USER['id']) {
                $this->rights = array_combine($this->availableRanks, array_fill(0, count($this->availableRanks), true));
            } elseif ($USER['ally_rank_id'] != 0) {
                $sql = 'SELECT ' . implode(', ', $this->availableRanks) . ' FROM %%ALLIANCE_RANK%% WHERE allianceId = :allianceId AND rankID = :ally_rank_id;';
                $this->rights = $db->selectSingle($sql, array(
                    ':allianceId' => $allianceId,
                    ':ally_rank_id' => $USER['ally_rank_id'],
                ));
            }

            if (!isset($this->rights)) {
                $this->rights = array_combine($this->availableRanks, array_fill(0, count($this->availableRanks), false));
            }

            if (isset($this->tplObj)) {
                $this->assign(array(
                    'rights' => $this->rights,
                    'AllianceOwner' => $this->allianceData['ally_owner'] == $USER['id'],
                ));
            }
        }
    }
}