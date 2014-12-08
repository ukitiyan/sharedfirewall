<?php

use \OCA\SharedFirewall\Lib\Firewall;

OCP\JSON::checkAppEnabled('sharedfirewall');
OCP\JSON::callCheck();

if (!isset($_POST['shareid']) || !isset($_POST['accept'])) {
	OCP\JSON::error(array('data' => array()));
}
if (!ip2long($_POST['accept'])) {
	OCP\JSON::error(array('data' => array()));
}

$id = isset($_POST['id']) ? $_POST['id'] : null ;
$shareid = $_POST['shareid'];
$accept = $_POST['accept'];


$result = Firewall::saveRecord($id, $shareid, $accept);
if ($result) {
	OCP\JSON::success(array('data' => array('id' => $result)));
} else {
	OCP\JSON::error(array('data' => array()));
}
