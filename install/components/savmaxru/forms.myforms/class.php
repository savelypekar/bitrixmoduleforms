<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

\Bitrix\Main\Loader::includeModule('savmaxru.forms');


class CSavmaxruFormsMyForms extends CBitrixComponent
{
	private $modeNames = [
		"result" =>'result-list',
		'' => 'form-list',
	];

	private function getModeName()
	{
		$modeName = $this->modeNames[$this->arParams['MODE']];
		if($modeName === null)
		{
			$modeName = $this->modeNames[''];
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