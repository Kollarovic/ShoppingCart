<?

namespace Kollarovic\ShoppingCart\Test;

use Kollarovic\Navigation\Item;
use Nette\Configurator;


abstract class TestCase extends \Tester\TestCase
{


	protected function createContainer()
	{
		$configurator = new Configurator();
		$configurator->setDebugMode(FALSE);
		$configurator->addParameters(array('wwwDir' => TEMP_DIR));
		$configurator->setTempDirectory(TEMP_DIR);
		$configurator->addConfig(__DIR__ . '/../config.neon');
		return $configurator->createContainer();
	}

}
