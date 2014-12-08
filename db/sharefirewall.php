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

use OCP\AppFramework\Db\Entity;

class ShareFirewall extends Entity {

	public $id;
	public $shareid;
	public $uid;
	public $accept;

	/**
	 * Entity to Array Function
	 * @return array
	 */
	public function toArray() {
		$params = array();
		foreach (get_object_vars($this) as $key => $value) {
			$method = 'get' . ucfirst($key);
			$params[$key] = $this->$method();
		}
		return $params;
	}

	/**
	 * Insert From Entity
	 * @param $shareid int
	 * @param $accept string
	 */
	public function insert($shareid, $accept) {
		$sql = "INSERT INTO `*PREFIX*share_firewall` VALUES (?, ?, ?, ?)";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array(null, $shareid, \OC_User::getUser(), $accept));
		$this->loadById(\OCP\DB::insertid(`*PREFIX*share_firewall`));
	}

	/**
	 * Update Accept Value
	 * @param $accept string
	 * @return bool
	 */
	public function updateAccept($accept) {
		if (empty($this->id)) {
			return false;
		}
		$sql = "UPDATE `*PREFIX*share_firewall` SET `accept` = ? WHERE `id` = ? ";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array($accept, $this->id));
		$this->loadById($this->id);
		return true;
	}
	/**
	 * Delete Entity
	 * @return bool
	 */
	public function delete() {
		if (empty($this->id)) {
			return false;
		}
		$sql = "DELETE FROM `*PREFIX*share_firewall` WHERE `id` = ? ";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array($this->id));
		return true;
	}

	/**
	 * Load Entity By Id
	 * @param $id int
	 */
	public function loadById($id) {
		$sql = "SELECT `id`, `shareid`, `uid`, `accept` FROM `*PREFIX*share_firewall` WHERE `id` = ? ";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array($id));
		while ($row = $stmt->fetchRow()) {
			if ($row['uid'] === \OC_User::getUser()) {
				$this->id = $row['id'];
				$this->shareid = $row['shareid'];
				$this->uid = $row['uid'];
				$this->accept = $row['accept'];
			}
		}
	}

	/**
	 * Find Entity By Mine
	 * @return array
	 */
	public function findByMine() {
		$sql = "SELECT `id`, `shareid`, `uid`, `accept` FROM `*PREFIX*share_firewall` WHERE `uid` = ? ";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array(\OC_User::getUser()));
		$results = array();
		while ($row = $stmt->fetchRow()) {
			$this->id = $row['id'];
			$this->shareid = $row['shareid'];
			$this->uid = $row['uid'];
			$this->accept = $row['accept'];
			$results[] = $this->toArray();
		}
		return $results;
	}

	/**
	 * Find Entity By Shareid
	 * @return array
	 */
	public function findByShareid($shareid) {
		$sql = "SELECT `id`, `shareid`, `uid`, `accept` FROM `*PREFIX*share_firewall` WHERE `shareid` = ? ";
		$stmt = \OCP\DB::prepare($sql);
		$stmt->execute(array($shareid));
		$results = array();
		while ($row = $stmt->fetchRow()) {
			$this->id = $row['id'];
			$this->shareid = $row['shareid'];
			$this->uid = $row['uid'];
			$this->accept = $row['accept'];
			$results[] = $this->toArray();
		}
		return $results;
	}

}