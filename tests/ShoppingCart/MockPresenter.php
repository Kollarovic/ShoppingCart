<?php
declare(strict_types=1);

namespace Kollarovic\ShoppingCart\Test;

use Nette\Application\UI\Presenter;


class MockPresenter extends Presenter
{
	public function actionDefault()
	{
		$this->terminate();
	}


	protected function getGlobalState(string $forClass = null): array
	{
		return [];
	}


	public function link(string $destination, $args = []): string
	{
		return 'link';
	}


	public function isLinkCurrent(string $destination = null, $args = []): bool
	{
		$this->createTemplate();
		return $destination == 'Setting:web';
	}
}
