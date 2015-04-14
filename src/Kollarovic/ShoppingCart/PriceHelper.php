<?php

namespace Kollarovic\ShoppingCart;

use Nette;


/**
* @method PriceHelper setCurrency(string $currency)
* @method PriceHelper setDecimals(int $decimals)
* @method PriceHelper setDecimalPoint(int $decimalPoint)
* @method PriceHelper setThousandsSep(string $thousandsSep)
* @method PriceHelper setPriceFormat(int $priceFormat)
*/
class PriceHelper extends Nette\Object
{
	
	/** @var string */
	private $currency;

	/** @var int */
	private $decimals;

	/** @var string */
	private $decimalPoint;

	/** @var string */
	private $thousandsSep;

	/** @var string */
	private $priceFormat;


	function __construct($currency = '€', $decimals = 2,  $decimalPoint = ',', $thousandsSep = ' ', $priceFormat = '{price} {currency}')
	{
		$this->currency = $currency;
		$this->decimals = $decimals;
		$this->decimalPoint = $decimalPoint;
		$this->thousandsSep = $thousandsSep;
		$this->priceFormat = $priceFormat;
	}


	public function format($price)
	{
		$price = number_format($price, $this->decimals, $this->decimalPoint, $this->thousandsSep);
		$search = array('{price}', '{currency}', ' ');
		$replace = array($price, $this->currency, "\xc2\xa0");
		return str_replace($search, $replace, $this->priceFormat);
	}

	
}