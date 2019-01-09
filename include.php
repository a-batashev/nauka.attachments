<?php
global $MESS, $DOCUMENT_ROOT;

class CNaukaAttachments {

	function OnBeforeHTMLEditorScriptRunsHandler() {
		CJSCore::RegisterExt(
			'nauka_attachments',
			array(
				'js' => '/bitrix/js/nauka.attachments/nauka_attachments.js',
				'lang' => '/bitrix/modules/nauka.attachments/lang/ru/install/js/nauka_attachments.php',
				'rel' => array('ajax')
			)
		);
		CJSCore::Init(array('nauka_attachments'));
	}

}
