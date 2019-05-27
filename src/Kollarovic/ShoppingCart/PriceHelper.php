<?php

namespace Kollarovic\ShoppingCart;


class PriceHelper
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


	public function setCurrency($currency)
	{
		$this->currency = $currency;
		return $this;
	}


	public function setDecimals($decimals)
	{
		$this->decimals = $decimals;
		return $this;
	}


	public function setDecimalPoint($decimalPoint)
	{
		$this->decimalPoint = $decimalPoint;
		return $this;
	}


	public function setThousandsSep($thousandsSep)
	{
		$this->thousandsSep = $thousandsSep;
		return $this;
	}


	public function setPriceFormat($priceFormat)
	{
		$this->priceFormat = $priceFormat;
		return $this;
	}

}