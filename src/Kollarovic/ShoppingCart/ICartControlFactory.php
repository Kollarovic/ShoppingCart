<?php

namespace Kollarovic\ShoppingCart;


interface ICartControlFactory
{

	/**
	 * @return CartControl
	 */
	function create();

}