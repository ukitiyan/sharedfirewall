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

namespace OCA\SharedFirewall\Controller;


use \OCP\IRequest;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Http\JSONResponse;

use \OCA\SharedFirewall\AppInfo\Application;


class PageControllerTest extends \PHPUnit_Framework_TestCase {

	private $container;

	public function setUp () {
		$app = new Application();
		$phpunit = $this;
		$this->container = $app->getContainer();
		$this->container->registerService('Request', function($c) use ($phpunit) {
			return $phpunit->getMockBuilder('\OCP\IRequest')->getMock();
		});
		$this->container->registerParameter('UserId', 'john');
	}


	public function testIndex () {
		$result = $this->container->query('PageController')->index();

		$this->assertEquals(array('user' => 'john'), $result->getParams());
		$this->assertEquals('main', $result->getTemplateName());
		$this->assertTrue($result instanceof TemplateResponse);
	}


	public function testEcho () {
		$result = $this->container->query('PageController')->doEcho('hi');

		$this->assertEquals(array('echo' => 'hi'), $result);
	}


}