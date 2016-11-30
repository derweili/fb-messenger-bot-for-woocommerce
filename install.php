<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
* Delete all plugin data on deinstallation
*/
class DERWEILI_Mbot_Uninstall
{

	
	function __construct()
	{
		$this->regenerate_permalinks();
	}

	function regenerate_permalinks() {

		mbot_webhook_endpoint(); // register webhook endpoints

		flush_rewrite_rules(); // flush rewrite rules

	}


}

function mbot_install_mbot() {
	new DERWEILI_Mbot_Uninstall();
}