<?php

namespace Kollarovic\ShoppingCart;

use Nette\Object;


/**
 * @method Item setName(string $name)
 * @method Item setLink(string $link)
 * @method Item setLinkArgs(mixed $linkArgs)
 * @method Item setPrice(float $price)
 * @method Item setPriceWithoutVat(float $price)
 * @method Item setPricePrecision(int $precision)
 * @method Item setVatRate(int $vatRate)
 * @method Item setQuantity(int $quantity)
 * @method Item setUnit(string $unit)
 * @method Item setAvailability(string $availability)
 * @method Item setImage(string $image)
 * @method Item setData(array $data)
 *
 * @method int getId()
 * @method string getName()
 * @method string getLink()
 * @method mixed getLinkArgs()
 * @method int getPricePrecision()
 * @method float getVatRate()
 * @method int getQuantity()
 * @method string getUnit()
 * @method string getAvailability()
 * @method string getImage()
 * @method array getOptions()
 * @method array getData()
 */
class Item extends Object 
{
	
	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var string */
	private $link;

	/** @var mixed */
	private $linkArgs = [];

	/** @var float */
	private $price;

	/** @var float */
	private $priceWithoutVat;

	/** @var int */
	private $pricePrecision = 2;

	/** @var int */
	private $vatRate;

	/** @var mixed */
	private $quantity;

	/** @var string */
	private $unit;

	/** @var string */
	private $availability;

	/** @var string */
	private $image;

	/** @var array */
	private $options = [];

	/** @var array */
	private $data = [];


	function __construct($id, $price = NULL, $quantity = 1, array $options = [])
	{
		$this->id = $id;
		$this->price = $price;
		$this->quantity = $quantity;
		$this->options = $options;
	}


	public function addQuantity($quantity)
	{
		$this->quantity += $quantity;
		return $this;
	}


	public function getPrice()
	{
		if ($this->price) {
			return $this->price;
		}
		return round($this->priceWithoutVat + ($this->priceWithoutVat / 100 * $this->vatRate), $this->pricePrecision);
	}


	public function getTotal()
	{
		return $this->getPrice() * $this->quantity;
	}


	public function getPriceWithoutVat()
	{
		if ($this->priceWithoutVat) {
			return $this->priceWithoutVat;
		}
		return round(($this->price / (100 + $this->vatRate)) * 100, $this->pricePrecision);
	}


	public function getTotalWithoutVat()
	{
		return $this->getPriceWithoutVat() * $this->quantity;
	}

}