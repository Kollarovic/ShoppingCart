<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Kollarovic\ShoppingCart\PriceHelper;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class PriceHelperTest extends TestCase
{
	public function testExtension()
	{
		$priceHelper = $this->createContainer()
			->getByType('Kollarovic\ShoppingCart\PriceHelper');
		Assert::true($priceHelper instanceof PriceHelper);
	}


	public function testFormat()
	{
		$priceHelper = new PriceHelper();
		Assert::same('1 450,15 €', $priceHelper->format(1450.15));
		$priceHelper->setCurrency('Kč');
		Assert::same('1 450,15 Kč', $priceHelper->format(1450.15));
		$priceHelper->setThousandsSep('.');
		Assert::same('1.450,15 Kč', $priceHelper->format(1450.15));
		$priceHelper->setDecimals(1);
		Assert::same('1.450,1 Kč', $priceHelper->format(1450.14));
	}
}


\run(new PriceHelperTest());
