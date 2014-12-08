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

class Util {

	/**
	 * @brief Return My Shared By Folder
	 * @return array
	 */
	public static function getSharedMyFolder() {
		$itemShared = \OCP\Share::getItemShared('file', null);
		return array_values(array_filter($itemShared, function($itemShare) {return $itemShare['item_type'] === 'folder';}));
	}

	/**
	 * @brief Return Shared With Me By Folder
	 * @return array
	 */
	public static function getSharedWithMeByFolder() {
		$itemShared = \OC\Share\Share::getItemsSharedWith('file');
		return array_values(array_filter($itemShared, function($itemShare) {return $itemShare['item_type'] === 'folder';}));
	}
}
