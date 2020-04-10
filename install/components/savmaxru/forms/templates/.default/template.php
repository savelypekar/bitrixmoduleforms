<div class="savmaxru-forms-main-container">

<?php
require $_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php";

$APPLICATION->IncludeComponent(
	'savmaxru:forms.'.$arResult['MODE'],
	'.default',
	[
		'URL' => $arResult['URL'],
	]
);

require $_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php";
?>
</div>
