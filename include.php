<?php
global $MESS, $DOCUMENT_ROOT;

class CNaukaAttachments {

	function OnBeforeHTMLEditorScriptRunsHandler() {

		$IBLOCK_ID = intval($_GET["IBLOCK_ID"]);
		$ID = intval($_GET["ID"]);
		$PROPERTY_CODE = "FILES";

		if ($IBLOCK_ID > 0 && $ID > 0) {
			// Check if the property for attachments exists
			$res = CIBlockElement::GetProperty(
				$IBLOCK_ID,
				$ID,
				array("SORT" => "ASC"),
				array("CODE" => $PROPERTY_CODE)
			);
			if ($res->Fetch()) {
				CJSCore::RegisterExt(
					'nauka_attachments',
					array(
						'js' => '/bitrix/js/nauka.attachments/nauka_attachments.js',
						'css' => '/bitrix/js/nauka.attachments/nauka_attachments.css',
						'lang' => '/bitrix/modules/nauka.attachments/lang/ru/install/js/nauka_attachments.php',
						'rel' => array('ajax')
					)
				);
				CJSCore::Init(array('nauka_attachments'));
			}

		}
	}

}
