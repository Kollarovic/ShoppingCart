<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Kollarovic\ShoppingCart\Cart;
use Kollarovic\ShoppingCart\CartControl;
use Nette\Application\Request;
use Tester\Assert;
use Tester\DomQuery;

require_once __DIR__ . '/../bootstrap.php';


class CartControlTest extends TestCase
{
	public function testExtension()
	{
		$cartControl = $this->createContainer()
			->getByType('Kollarovic\ShoppingCart\ICartControlFactory')->create();
		Assert::true($cartControl instanceof CartControl);
	}


	public function testRender()
	{
		ob_start();
		$this->createControl()->render();
		$html = ob_get_clean();
		$dom = DomQuery::fromHtml($html);
		Assert::count(2, $dom->find('input[type="number"]'));
	}


	protected function createControl()
	{
		$container = $this->createContainer();
		$presenter = new MockPresenter();
		$container->callInjects($presenter);
		$request = new Request('Mock', 'GET', ['action' => 'default']);
		$presenter->run($request);

		$cart = new Cart([]);
		$cart->addItem(1, 10, 1, ['size' => 'xl', 'color' => 'red']);
		$cart->addItem(2, 10, 1, ['size' => 'xl', 'color' => 'red']);
		$control = new CartControl($cart);
		$presenter->addComponent($control, 'control');
		return $control;
	}
}


\run(new CartControlTest());
