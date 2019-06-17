<?php

declare(strict_types=1);

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


	public function __construct(
		string $currency = '€',
		int $decimals = 2,
		string $decimalPoint = ',',
		string $thousandsSep = ' ',
		string $priceFormat = '{price} {currency}'
	) {
		$this->currency = $currency;
		$this->decimals = $decimals;
		$this->decimalPoint = $decimalPoint;
		$this->thousandsSep = $thousandsSep;
		$this->priceFormat = $priceFormat;
	}


	public function format($price): string
	{
		$price = number_format($price, $this->decimals, $this->decimalPoint, $this->thousandsSep);
		$search = ['{price}', '{currency}', ' '];
		$replace = [$price, $this->currency, "\xc2\xa0"];
		return str_replace($search, $replace, $this->priceFormat);
	}


	public function setCurrency(string $currency): self
	{
		$this->currency = $currency;
		return $this;
	}


	public function setDecimals(int $decimals): self
	{
		$this->decimals = $decimals;
		return $this;
	}


	public function setDecimalPoint(string $decimalPoint): self
	{
		$this->decimalPoint = $decimalPoint;
		return $this;
	}


	public function setThousandsSep(string $thousandsSep): self
	{
		$this->thousandsSep = $thousandsSep;
		return $this;
	}


	public function setPriceFormat(string $priceFormat): self
	{
		$this->priceFormat = $priceFormat;
		return $this;
	}
}
