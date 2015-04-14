<?php

namespace Kollarovic\ShoppingCart\Test;

use Nette\Application\UI\Presenter;


class MockPresenter extends Presenter
{


	protected function getGlobalState($forClass = NULL)
	{
		return [];
	}


	public function link($destination, $args = array())
	{
		return 'link';
	}


	public function isLinkCurrent($destination = NULL, $args = array())
	{
		$this->createTemplate();
		return ($destination == 'Setting:web');
	}

}