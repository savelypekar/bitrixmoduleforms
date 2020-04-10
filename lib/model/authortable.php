<?php

namespace Vendor\Questionary\Model;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

class AuthorTable extends DataManager
{
	public static function getTableName()
	{
		return 'vendor_questionary_author';
	}

	public static function getMap()
	{
		return [
			new IntegerField("ID", [
				"primary" => true,
				"autocomplete" => true
			]),
			new StringField("NAME", [
				"required" => true
			]),
		];
	}



}