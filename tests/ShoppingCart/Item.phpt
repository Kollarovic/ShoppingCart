<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Kollarovic\ShoppingCart\Item;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ItemTest extends TestCase
{
	public function testPrice()
	{
		$item = new Item(1, 5980.0);
		$item->setVatRate(21);
		Assert::equal(4942.15, $item->getPriceWithoutVat());
		$item->setPricePrecision(3);
		Assert::equal(4942.149, $item->getPriceWithoutVat());
		$item->setPriceWithoutVat(4000);
		Assert::equal(4000.0, $item->getPriceWithoutVat());

		$item = new Item(1);
		$item->setVatRate(21)->setPriceWithoutVat(4942.15);
		Assert::equal(5980.00, $item->getPrice());
	}


	public function testTotal()
	{
		$item = new Item(1, 5980.0, 4);
		$item->setVatRate(21);
		Assert::equal(23920.0, $item->getTotal());
		Assert::equal(19768.6, $item->getTotalWithoutVat());
	}
}


\run(new ItemTest());
