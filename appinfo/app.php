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

namespace OCA\SharedFirewall\AppInfo;

use OCA\SharedFirewall\Lib\Firewall;
use OCP\AppFramework\Http\RedirectResponse;

\OCP\App::registerPersonal('sharedfirewall', 'personal');

/** CheckRequest **/
// Download Request URL Prefix
$ajaxDownloadPath = \OCP\Util::linkTo('files', 'ajax/download.php');
$downloadPath = \OCP\Util::linkTo('files', 'download.php');
// Webdav Request URL Prefix
$webDavPath = \OC_Helper::linkToRemoteBase('webdav');

$accept = true;
if (strpos($_SERVER['REQUEST_URI'], $ajaxDownloadPath)  !== FALSE) {
	$accept = Firewall::isAccept($_GET['dir']);
} else if (strpos($_SERVER['REQUEST_URI'], $downloadPath)  !== FALSE) {
	$accept = Firewall::isAccept($_GET['dir']);
} else if (strpos($_SERVER['REQUEST_URI'], $webDavPath)  !== FALSE && (isset($_SERVER['PHP_AUTH_USER']) || \OCP\User::isLoggedIn())) {
	$path = urldecode(preg_replace("{^$webDavPath}", "", $_SERVER['REQUEST_URI']));
	$accept = Firewall::isAccept($path);
}

if (!$accept) {
	return new RedirectResponse('/');
}