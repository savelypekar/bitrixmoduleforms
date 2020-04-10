<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

\Bitrix\Main\Loader::includeModule('savmaxru.forms');

class CVendorQuestionaryComponentListForms extends CBitrixComponent
{
	public function executeComponent()
	{

		echo \Vendor\Questionary\Test::hello('Savely');
		echo 'если из компонента';

		$this->arResult = [
			'BOOKS' => [
				[
					'ID' => 1,
					'TITLE' => Loc::getMessage("VENDOR_MODULENAME_COMPONENTNAME_BOOK_TITLE_1"),
					'TEXT' => $this->arParams['PARAM1']
				]
			]
		];

		$this->includeComponentTemplate();
	}
}