<?php

declare(strict_types=1);

namespace Kollarovic\ShoppingCart;


interface ICartControlFactory
{
	function create(): CartControl;
}
