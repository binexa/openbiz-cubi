<?php

use Openbiz\Openbiz;

class AccountService
{

    protected $accountDO = 'account.do.AccountSystemDO';

    public function getDefaultAccountId($userId = null)
    {
        if (!$userId) {
            $userId = Openbiz::$app->getUserProfile("Id");
        }

        $assocRec = Openbiz::getObject("account.do.AccountUserDO")->fetchOne("[user_id]='$userId' AND [default]='1'");
        $accountId = $assocRec['account_id'];
        return $accountId;
    }

    public function getAccountUserIds($accountId, $access_level = null)
    {
        $searchRule = "[account_id]='$accountId'";
        if ($access_level) {
            $searchRule.= " AND [access_level] >= '$access_level' ";
        }
        $users = array();
        foreach (Openbiz::getObject("account.do.AccountUserDO")->directFetch($searchRule) as $rec) {
            $users[] = $rec['user_id'];
        }
        return $users;
    }

    public function getDisplayName($accountId)
    {
        if (!$accountId) {
            return "-- Not available --";
        }
        $name = Openbiz::getObject($this->accountDO)->fetchById($accountId)->objectName;
        if ($name) {
            return $name;
        } else {
            return "-- Deleted Account ( $accountId ) --";
        }
    }

    public function genAccountCode()
    {
        $code = "ACCT-" . date('ym') . '-' . rand(111111, 999999);
        $rec = Openbiz::getObject($this->accountDO)->fetchOne("[code]='$code'");
        if ($rec) {
            return $this->genAccountCode();
        } else {
            return $code;
        }
    }

    public function assocAccountUser($accountId, $userId, $accessLevel = '3')//accessLevel = 3 is full control
    {
        $assocRec = array(
            "account_id" => $accountId,
            "user_id" => $userId,
            "access_level" => $accessLevel,
            "default" => '1',
            "status" => '1'
        );
        return Openbiz::getObject("account.do.AccountUserDO")->insertRecord($assocRec);
    }

    public function createAccount($rec)
    {
        $rec['code'] = $this->GenAccountCode();
        return Openbiz::getObject($this->accountDO)->insertRecord($rec);
    }

    public function validateAccountToken($accountCode, $tokenCode)
    {
        return false;
    }

}

