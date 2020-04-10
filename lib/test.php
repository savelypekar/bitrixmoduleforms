<?php

namespace Vendor\Questionary;

use Bitrix\Main\Localization\Loc;

class Test
{
	public static function hello(string $name): string
	{
		return Loc::getMessage('VENDOR_TEST_HELLO',['#NAME#' => $name]);
	}
}