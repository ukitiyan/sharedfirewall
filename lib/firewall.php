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

namespace OCA\SharedFirewall\Lib;

use OCA\SharedFirewall\Db\ShareFirewall;

class Firewall {

	/**
	 * @brief Return My Shared By Folder
	 * @return int | null
	 */
	public static function saveRecord($id, $shareid, $accept) {
		$shareFirewall = new ShareFirewall();
		if (is_null($id)) {
			$shareFirewall->insert($shareid, $accept);
		} else {
			$shareFirewall->loadById($id);
			$shareFirewall->updateAccept($accept);
		}
		return $shareFirewall->getId();
	}
	/**
	 * @brief Return Shared With Me By Folder
	 * @return bool
	 */
	public static function removeRecord($id) {
		$shareFirewall = new ShareFirewall();
		$shareFirewall->loadById($id);
		return $shareFirewall->delete();
	}

	/**
	 * @brief Return Firewall Records With Path And Status
	 * @return array
	 */
	public static function getRecords() {
		$shareFirewallEntity = new ShareFirewall();
		$shareFirewalls = $shareFirewallEntity->findByMine();
		$shareFolders = Util::getSharedMyFolder();
		foreach ($shareFirewalls as &$shareFirewall) {
			$shareFolder = array_values(array_filter($shareFolders,
				function($itemShare) use ($shareFirewall) {
					return (int)$itemShare['id'] === (int)$shareFirewall['shareid'];
				}
			));
			if (!empty($shareFolder) && is_array($shareFolder)) {
				$shareFirewall['path'] = $shareFolder[0]['path'];
				$shareFirewall['status'] = true;
			} else {
				$shareFirewall['status'] = false;
			}
		}
		return $shareFirewalls;
	}

	/**
	 * @brief Check Firewall Accept Path
	 * @return bool
	 */
	public static function isAccept($path) {
		// check share folder
		$shareid = self::isShareFolder($path);
		if (!$shareid) {
			return true;
		}

		// check set firewall
		$shareFirewallEntity = new ShareFirewall();
		$shareFirewalls = $shareFirewallEntity->findByShareid($shareid);
		if (empty($shareFirewalls) || !is_array($shareFirewalls)) {
			return true;
		}

		// check inCIDR
		foreach ($shareFirewalls as $shareFirewall) {
			if (self::inCIDR($_SERVER['REMOTE_ADDR'], $shareFirewall['accept'])) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @brief Check Shared Folder Path
	 * @return int | false
	 */
	private static function isShareFolder($path) {
		$shareFolders = Util::getSharedWithMeByFolder();
		foreach ($shareFolders as $shareFolder) {
			if (strpos($path, $shareFolder['file_target'], 0)  !== FALSE) {
				return $shareFolder['id'];
			}
		}
		return false;
	}

	/**
	 * @brief Check In Ip From cider
	 * @return int | false
	 */
	private static function inCIDR($ip, $cidr) {
		list($network, $mask_bit_len) = explode('/', $cidr);
		$host = 32 - $mask_bit_len;
		$net = ip2long($network) >> $host << $host; // 11000000101010000000000000000000
		$ip_net = ip2long($ip) >> $host << $host; // 11000000101010000000000000000000
		return $net === $ip_net;
	}
}
