<?php
global $MESS;

$langPath = str_replace("\\", "/", __FILE__);
$langPath = substr($langPath, 0, strlen($langPath) - strlen("/install/index.php"));
include(GetLangFileName($langPath . "/lang/", "/install/index.php"));

class nauka_attachments extends CModule {
	var $MODULE_ID = "nauka.attachments";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $INSTALL_DIR;

	public function __construct() {
		$arModuleVersion = array();
		$this->INSTALL_DIR = str_replace("\\", "/", __DIR__);
		
		include($this->INSTALL_DIR."/version.php");
		
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		
		$this->MODULE_NAME = getMessage('NAUKA_ATTACHMENTS_MODULE_NAME');
		$this->MODULE_DESCRIPTION = getMessage('NAUKA_ATTACHMENTS_MODULE_DESCRIPTION');
		
		$this->PARTNER_NAME = "AA.Batashev";
		$this->PARTNER_URI = "https://npo-nauka.ru";
	}

	public function InstallFiles() {
		CopyDirFiles($this->INSTALL_DIR."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin/");
		CopyDirFiles($this->INSTALL_DIR."/images", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/".$this->MODULE_ID);
		CopyDirFiles($this->INSTALL_DIR."/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/".$this->MODULE_ID);
		
		return true;
	}
	
	public function UnInstallFiles() {
		DeleteDirFiles($this->INSTALL_DIR."/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		DeleteDirFilesEx("/bitrix/js/".$this->MODULE_ID);
		DeleteDirFilesEx("/bitrix/images/".$this->MODULE_ID);
		
		return true;
	}

	public function DoInstall() {
		RegisterModule($this->MODULE_ID);
		
		RegisterModuleDependences("fileman", "OnBeforeHTMLEditorScriptRuns", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeHTMLEditorScriptRunsHandler" );
		//RegisterModuleDependences("iblock", "OnBeforeIBlockElementUpdate", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeIBlockElementAddOrUpdateHandler");
		//RegisterModuleDependences("iblock", "OnBeforeIBlockElementAdd", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeIBlockElementAddOrUpdateHandler");
		
		$this->InstallFiles();
	}

	public function DoUninstall() {
		UnRegisterModuleDependences("fileman", "OnBeforeHTMLEditorScriptRuns", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeHTMLEditorScriptRunsHandler" );
		//UnRegisterModuleDependences("iblock", "OnBeforeIBlockElementUpdate", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeIBlockElementAddOrUpdateHandler");
		//UnRegisterModuleDependences("iblock", "OnBeforeIBlockElementAdd", $this->MODULE_ID, "CNaukaAttachments", "OnBeforeIBlockElementAddOrUpdateHandler");
		
		UnRegisterModule($this->MODULE_ID);
		
		$this->UnInstallFiles();
	}
}