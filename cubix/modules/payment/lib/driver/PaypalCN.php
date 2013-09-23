<?php 
require_once 'Paypal.php';

class PaypalCN extends Paypal
{
	protected $m_ProviderId = 1;
	protected $type = 'paypalcn';
	protected $currencyCode = 'CNY';
}
?>