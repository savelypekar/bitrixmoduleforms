<?php
require $_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php";

$APPLICATION->IncludeComponent(
	'savmaxru:forms',
	'.default',
	[
		'MODE' => $_GET["mode"],
		'URL' => $_GET["url"],
	]
);

require $_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php";