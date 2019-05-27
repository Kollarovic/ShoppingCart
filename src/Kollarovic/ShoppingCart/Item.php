<?php

namespace Kollarovic\ShoppingCart;


class Item
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


	public function getId()
	{
		return $this->id;
	}


	public function getName()
	{
		return $this->name;
	}


	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}


	public function getLink()
	{
		return $this->link;
	}


	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}


	public function getLinkArgs()
	{
		return $this->linkArgs;
	}


	public function setLinkArgs($linkArgs)
	{
		$this->linkArgs = $linkArgs;
		return $this;
	}


	public function getPricePrecision()
	{
		return $this->pricePrecision;
	}


	public function setPricePrecision($pricePrecision)
	{
		$this->pricePrecision = $pricePrecision;
		return $this;
	}


	public function getVatRate()
	{
		return $this->vatRate;
	}


	public function setVatRate($vatRate)
	{
		$this->vatRate = $vatRate;
		return $this;
	}


	public function getQuantity()
	{
		return $this->quantity;
	}


	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}


	public function getUnit()
	{
		return $this->unit;
	}


	public function setUnit($unit)
	{
		$this->unit = $unit;
		return $this;
	}


	public function getAvailability()
	{
		return $this->availability;
	}


	public function setAvailability($availability)
	{
		$this->availability = $availability;
		return $this;
	}


	public function getImage()
	{
		return $this->image;
	}


	public function setImage($image)
	{
		$this->image = $image;
		return $this;
	}


	public function getOptions()
	{
		return $this->options;
	}


	public function getData()
	{
		return $this->data;
	}


	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}


	public function setPriceWithoutVat($priceWithoutVat)
	{
		$this->priceWithoutVat = $priceWithoutVat;
	}

}