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


use \OCP\AppFramework\App;
use \OCP\IContainer;

use \OCA\SharedFirewall\Controller\PageController;

class Application extends App {


	public function __construct (array $urlParams=array()) {
		parent::__construct('sharedfirewall', $urlParams);
	}


}