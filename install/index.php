<?php
use Bitrix\Main\Localization\Loc;
IncludeModuleLangFile(__FILE__);

Class savmaxru_forms extends CModule {

	public $MODULE_ID = "savmaxru.forms";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct()
	{
		$this->MODULE_VERSION ="0.0.1";
		$this->MODULE_VERSION_DATE = "2020-04-05 12:00:00";

		$this->MODULE_NAME = Loc::getMessage("SAVMAXRU_FORMS_MODULE_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("SAVMAXRU_FORMS_MODULE_INSTALL_DESCRIPTION");
	}

	public function InstallDB()
	{
		global $DB, $DBType;
		$DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/db/".$DBType."/install.sql");
	}

	public function UnInstallDB()
	{
		global $DB, $DBType;
		$DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/db/".$DBType."/uninstall.sql");
	}

	function InstallFiles()
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/public", $_SERVER["DOCUMENT_ROOT"]."/", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/js", $_SERVER["DOCUMENT_ROOT"]."/local/js", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/components", $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);

		$siteId = \CSite::GetDefSite();
		\Bitrix\Main\UrlRewriter::add($siteId, [
			'CONDITION' => '#^/forms/(\\w+)/([0-9a-z]+)\\/?$#',
			'RULE' => 'mode=$1&id=$2',
			'ID' => 'savmaxru:forms',
			'PATH' => '/forms/index.php',
		]);
	}


	function UnInstallFiles()
	{
		DeleteDirFilesEx("/forms");
		DeleteDirFilesEx("/local/js/savmaxru");
		DeleteDirFilesEx("/local/components/savmaxru");
		//в дальнейшем нужно удалять будет циклом, чтобы не трогать папку разработчика
		//вдруг несколько модулей подключено в savmaxru

		$siteId = \CSite::GetDefSite();
		\Bitrix\Main\UrlRewriter::delete(
			$siteId,
			['ID' => 'savmaxru:forms']
		);
	}

	function DoInstall() {

		RegisterModule($this->MODULE_ID);

		$this->InstallDB();
		$this->InstallFiles();
	}

	function DoUninstall() {

		$this->UnInstallDB();
		$this->UnInstallFiles();

		UnRegisterModule($this->MODULE_ID);
	}
}
?>