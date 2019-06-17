<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Nette\Configurator;


abstract class TestCase extends \Tester\TestCase
{
	protected function createContainer()
	{
		$configurator = new Configurator();
		$configurator->setDebugMode(false);
		$configurator->addParameters(['wwwDir' => TEMP_DIR]);
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addConfig(__DIR__ . '/../config.neon');
		return $configurator->createContainer();
	}
}
