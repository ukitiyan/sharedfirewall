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

namespace OCA\SharedFirewall\Db;

use OCP\AppFramework\Db\Mapper;

class ShareFirewallMapper extends Mapper {

	public function __construct($db) {
		parent::__construct($db, 'sharedfirewall');
	}

	/**
	 * find Unique object
	 * @params int
	 * @params SearchGroonga | null
	 */
	public function findByUid($uid) {
		$sql = "SELECT * FROM ". $this->getTableName(). " WHERE `uid` =?";
		$entities = $this->findEntities($sql, array($uid));
		return count($entities) > 0 ? $entities[0] : null;
	}

}