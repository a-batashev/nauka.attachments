<?php

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class nauka_attachments extends \CModule
{
	public $MODULE_ID = 'nauka.attachments';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $PARTNER_NAME;
	public $PARTNER_URI;

	/** @var string */
	protected $installDir = '';

	public function __construct()
	{
		$this->installDir = str_replace("\\", "/", __DIR__);

		$arModuleVersion = [];
		include($this->installDir . '/version.php');

		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

		$this->MODULE_NAME = Loc::getMessage('NAUKA_ATTACHMENTS_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('NAUKA_ATTACHMENTS_MODULE_DESCRIPTION');

		$this->PARTNER_NAME = Loc::getMessage('NAUKA_ATTACHMENTS_PARTNER_NAME');
		$this->PARTNER_URI = Loc::getMessage('NAUKA_ATTACHMENTS_PARTNER_URI');
	}

	public function doInstall()
	{
		$this->installEvents();
		$this->installFiles();

		ModuleManager::registerModule($this->MODULE_ID);
	}

	public function doUninstall()
	{
		$this->uninstallEvents();
		$this->uninstallFiles();

		ModuleManager::unRegisterModule($this->MODULE_ID);
	}

	public function installEvents()
	{
		EventManager::getInstance()->registerEventHandler(
			'fileman',
			'OnBeforeHTMLEditorScriptRuns',
			$this->MODULE_ID,
			'Nauka\\Attachments\\EventHandler',
			'onBeforeHTMLEditorScriptRunsHandler'
		);
	}

	public function uninstallEvents()
	{
		// Старая версия события
		EventManager::getInstance()->unRegisterEventHandler(
			'fileman',
			'OnBeforeHTMLEditorScriptRuns',
			$this->MODULE_ID,
			'CNaukaAttachments',
			'OnBeforeHTMLEditorScriptRunsHandler'
		);

		EventManager::getInstance()->unRegisterEventHandler(
			'fileman',
			'OnBeforeHTMLEditorScriptRuns',
			$this->MODULE_ID,
			'Nauka\\Attachments\\EventHandler',
			'onBeforeHTMLEditorScriptRunsHandler'
		);
	}

	public function installFiles()
	{
		$docRoot = Application::getDocumentRoot();

		\CopyDirFiles($this->installDir .'/admin', $docRoot .'/bitrix/admin/');
		\CopyDirFiles($this->installDir .'/images', $docRoot .'/bitrix/images/'. $this->MODULE_ID);
		\CopyDirFiles($this->installDir .'/js', $docRoot .'/bitrix/js/'. $this->MODULE_ID);
	}

	public function uninstallFiles()
	{
		$docRoot = Application::getDocumentRoot();

		\DeleteDirFiles($this->installDir .'/admin/', $docRoot .'/bitrix/admin');
		\DeleteDirFilesEx('/bitrix/js/'. $this->MODULE_ID);
		\DeleteDirFilesEx('/bitrix/images/'. $this->MODULE_ID);
	}
}
