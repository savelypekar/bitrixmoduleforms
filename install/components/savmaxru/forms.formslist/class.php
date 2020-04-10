<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

\Bitrix\Main\Loader::includeModule('savmaxru.forms');


class CSavmaxruFormsRouter extends CBitrixComponent
{
	private $modeNames = ["list","edit","run"];

	private function getModeName()
	{
		$modeName = $this->arParams['MODE'];
		if( !in_array($modeName, $this->modeNames) )
		{
			$modeName = "list";
		}

		return $modeName;
	}

	public function executeComponent()
	{
		$this->arResult = [
			'MODE' => $this->getModeName(),
			'URL' => $this->arParams['URL'],
		];

		$this->includeComponentTemplate();
	}
}