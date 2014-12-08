<?php

/**
 * ownCloud - sharedfirewall
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Begood Technology Corp. <y-takahashi@begood-tech.com>
 * @copyright Begood Technology Corp. 2014
 */

use OCA\SharedFirewall\Lib\Util;
use OCA\SharedFirewall\Lib\Firewall;

OCP\Util::addScript('sharedfirewall', 'settings');
OCP\Util::addStyle('sharedfirewall', 'settings');

$tmpl = new OCP\Template('sharedfirewall', 'personal');


$tmpl->assign('shares', Util::getSharedMyFolder());
$tmpl->assign('firewalls', Firewall::getRecords());
return $tmpl->fetchPage();
