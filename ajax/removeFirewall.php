<?php

use \OCA\SharedFirewall\Lib\Firewall;

OCP\JSON::checkAppEnabled('sharedfirewall');
OCP\JSON::callCheck();

if (!isset($_POST['id'])) {
	return;
}

$id = $_POST['id'];

Firewall::removeRecord($id);
