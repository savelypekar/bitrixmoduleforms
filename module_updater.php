<?
// config
$moduleName = 'savmaxru.forms';

// updater initialize
global $DB, $DBType;

include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_class.php");

$updater = new CUpdater();
$updater->Init(
	$_SERVER['DOCUMENT_ROOT'].'/local/modules/'.$moduleName.'/',
	$DBType,
	"",
	$_SERVER['DOCUMENT_ROOT'].'/local/modules/'.$moduleName.'/module_updater.php',
	$moduleName
);

$current_version = (int)\Bitrix\Main\Config\Option::get($moduleName, "~database_schema_version", -1);


//will then need to be deleted
$current_version = 0;

// local updaters
if($current_version <= 0)
{
	if ($updater->TableExists('vendor_questionary_book'))
	{
		$updater->Query("
			DROP TABLE vendor_questionary_book;
		");
	}

	if (!$updater->TableExists('vendor_questionary_interview'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_interview
			(
				ID int not null auto_increment,
				ID_AUTHOR int not null,
				TITLE varchar(255) not null,
				DATE_CREATE datetime,
				DATE_EDIT datetime,
				VISIBLE boolean,
			
				PRIMARY KEY(ID)
			);
		");
	}

	if (!$updater->TableExists('vendor_questionary_question'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_question
			(
				ID int not null auto_increment,
				TYPE varchar(20) not null,
				CONTENT varchar(255) not null,
				POSITION int not null,
			
				PRIMARY KEY(ID)
			);
		");
	}

	if (!$updater->TableExists('vendor_questionary_option'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_option
			(
				ID int not null auto_increment,
				ID_QUESTION int not null,
				CONTENT varchar(255) not null,
				POSITION int not null,
			
				PRIMARY KEY(ID)
			);
		");
	}

	if (!$updater->TableExists('vendor_questionary_answer_result'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_answer_result
			(
				ID int not null auto_increment,
				ID_RESULT int not null,
				ID_INTERVIEW int not null ,
				ID_USER int not null,
			
				PRIMARY KEY(ID)
			);
		");
	}

	if (!$updater->TableExists('vendor_questionary_answer_to_question'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_answer_to_question
			(
				ID int not null auto_increment,
				ID_QUESTION int not null ,
				IN_RESULT int not null ,
			
				PRIMARY KEY(ID)
			);
		");
	}

	if (!$updater->TableExists('vendor_questionary_answer_option'))
	{
		$updater->Query("
			CREATE TABLE vendor_questionary_answer_option
			(
				ID int not null auto_increment,
				ID_ANSWER int not null ,
				ID_OPTION int not null ,
			
				PRIMARY KEY(ID)
			);
		");
	}

	\Bitrix\Main\Config\Option::set($moduleName, "~database_schema_version", 1);
}
