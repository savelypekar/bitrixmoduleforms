<?php

namespace Vendor\Questionary\Controller;

use Bitrix\Main\Engine;
use Up\Module\Model\BookTable;

class Book extends Engine\Controller
{
	public function getAction($id)
	{
		return [
			'ID' => $id,
			'TITLE' => 'Our first book'
		];
	}
}