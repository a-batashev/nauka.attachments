<?php

namespace Nauka\Attachments;

use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Application;
use Bitrix\Main\Context;

class EventHandler
{
	public static function onBeforeHTMLEditorScriptRunsHandler()
	{
		$propertyCode = 'FILES';

		$get = Context::getCurrent()->getRequest()->getQueryList();

		$iblockId = (int) $get['IBLOCK_ID'];
		$elementId = (int) $get['ID'];

		if ($iblockId < 1 || $elementId < 1) {
			return;
		}

		// Check if the property for attachments exists
		$property = PropertyTable::getRow([
			'filter' => [
				'=IBLOCK_ID' => $iblockId,
				'=CODE' => $propertyCode,
			],
		]);

		if (is_null($property)) {
			return;
		}

		$docRoot = Application::getDocumentRoot();
		$modulePath = str_replace(realpath($docRoot), '', dirname(__DIR__));

		\CJSCore::RegisterExt(
			'nauka_attachments',
			[
				'js' => '/bitrix/js/nauka.attachments/nauka_attachments.js',
				'css' => '/bitrix/js/nauka.attachments/nauka_attachments.css',
				'lang' => $modulePath .'/lang/'. LANGUAGE_ID .'/install/js/nauka_attachments.php',
				'rel' => ['ajax'],
			]
		);

		\CJSCore::Init(['nauka_attachments']);
	}
}
