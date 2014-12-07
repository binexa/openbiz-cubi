<?php

use Openbiz\Openbiz;
use Openbiz\Easy\EasyForm;

class FinishedForm extends EasyForm
{

    public function fetchData()
    {
        $result = Openbiz::getService("payment.lib.PaymentService")->getReturnData($_GET['type']);
        $txn_id = $result['txn_id'];
        $verify = Openbiz::getService("payment.lib.PaymentService")->validateNotification($_GET['type'], $txn_id);
        return $result;
    }

}
