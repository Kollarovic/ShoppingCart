<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Kollarovic\ShoppingCart\Cart;
use Nette\Utils\ArrayHash;
use Tester\Assert;


require_once __DIR__ . '/../bootstrap.php';


class CartTest extends TestCase
{
	public function testExtension()
	{
		$cart = $this->createContainer()->getByType('Kollarovic\ShoppingCart\Cart');
		Assert::true($cart instanceof Cart);
	}


	public function testAdd()
	{
		$cart = new Cart(new ArrayHash());
		$cart->addItem(1, 10, 1, ['size' => 'xl', 'color' => 'red']);
		$cart->addItem(1, 10, 2, ['color' => 'red', 'size' => 'xl']);
		$cart->addItem(1, 10, 1, ['size' => 'xl', 'color' => 'red']);
		Assert::count(1, $cart->getItems());
		$cart->addItem(1, 10, 1, ['size' => 'l', 'color' => 'blue']);
		Assert::count(2, $cart->getItems());
		Assert::equal(5, $cart->getQuantity());
		Assert::equal(50.0, $cart->getTotal());
	}


	public function testDelete()
	{
		$cart = new Cart([]);
		Assert::true($cart->isEmpty());
		$cart->addItem(1, 10, 1);
		$cart->addItem(2, 10, 1);
		Assert::false($cart->isEmpty());
		foreach ($cart->getItems() as $key => $item) {
			$cart->delete($key);
		}
		Assert::true($cart->isEmpty());
	}


	public function testClear()
	{
		$cart = new Cart(new ArrayHash());
		Assert::true($cart->isEmpty());
		$cart->addItem(1, 10, 1);
		Assert::false($cart->isEmpty());
		$cart->clear();
		Assert::true($cart->isEmpty());
	}


	/**
	 * @throws InvalidArgumentException
	 */
	public function testCreate()
	{
		new Cart('string');
	}
}


\run(new CartTest());
