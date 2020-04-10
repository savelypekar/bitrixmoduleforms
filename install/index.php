<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class savmaxru_forms extends CModule
{
	public $MODULE_ID = "savmaxru.forms";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;

	public function __construct()
	{
		$this->MODULE_VERSION ="0.0.1";
		$this->MODULE_VERSION_DATE = "2020-04-05 12:00:00";

		$this->MODULE_NAME = Loc::getMessage("VENDOR_QUESTIONARY_MODULE_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("VENDOR_QUESTIONARY_MODULE_INSTALL_DESCRIPTION");
	}

	function InstallDB($install_wizard = true)
	{
		global $DB, $DBType, $APPLICATION;

		$errors = null;
		if (!$DB->Query("SELECT 'x' FROM vendor_questionary_book", true))
			$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/db/".$DBType."/install.sql");

		if (!empty($errors))
		{
			$APPLICATION->ThrowException(implode("", $errors));
			return false;
		}

		RegisterModule($this->MODULE_ID);

		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		global $DB, $DBType, $APPLICATION;

		$errors = null;
		if(array_key_exists("savedata", $arParams) && $arParams["savedata"] != "Y")
		{
			$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/db/".$DBType."/uninstall.sql");

			if (!empty($errors))
			{
				$APPLICATION->ThrowException(implode("", $errors));
				return false;
			}
		}

		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
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

		return true;
	}

	function UnInstallFiles()
	{
		$siteId = \CSite::GetDefSite();
		\Bitrix\Main\UrlRewriter::delete(
			$siteId,
			['ID' => 'savmaxru:forms']
		);

		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;

		$this->errors = null;

		$this->InstallFiles();
		$this->InstallDB(false);

		$GLOBALS["errors"] = $this->errors;
		$APPLICATION->IncludeAdminFile(Loc::getMessage("VENDOR_MODULENAME_MODULE_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/step1.php");
	}

	function DoUninstall()
	{
		global $APPLICATION, $step;

		$this->errors = array();


		//UnRegisterModule($this->MODULE_ID);

		$step = (int)$step;
		if($step<2)
		{
			$GLOBALS["up_module_installer_errors"] = $this->errors;
			$APPLICATION->IncludeAdminFile(Loc::getMessage("VENDOR_MODULENAME_MODULE_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/unstep1.php");
		}
		elseif($step==2)
		{
			$this->UnInstallDB(array(
				'savedata' => $_REQUEST['savedata']
			));
			$this->UnInstallFiles();

			$GLOBALS["up_module_installer_errors"] = $this->errors;
			$APPLICATION->IncludeAdminFile(Loc::getMessage("VENDOR_MODULENAME_MODULE_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/unstep2.php");
		}
	}
}