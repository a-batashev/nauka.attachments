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
		CJSCore::Init('nauka_attachments');
	}

	/*
	function OnBeforeIBlockElementAddOrUpdateHandler(&$arFields) {
		
		
		return $arFields;
	}
	*/

	/**
	* Wrapper for EMTypograph::fast_apply()
	*
	* Set excludes and options by default
	*
	* @param string $text
	* @param array $options
	* @return string
	*/
	public static function fastApply($text, $options = array()) {

		// Excludes
		if (
			$text == ''
			|| strpos($text, '<!--askaron.include') !== false // Fix for Askaron Include Module
			|| strpos($text, ';base64,') !== false // Typograph hangs on base64 images, so exclude it
		) {
			return $text;
		}

		// Options by default
		if (!is_array($options) || $options === array()) {
			$options = array(
				'OptAlign.all'   => 'off', // Disable "Optical align"
				'Text.breakline' => 'off', // Disable "Text auto-breakline"
				//'Symbol.arrows_symbols' => 'off', // Disable "Arrows to symbols"
				//'Number.thinsp_between_number_triads' => 'off', // Disable "Numbers triads delimiters"
			);
		}

		$attachments = new EMTypograph();
		$new_text = $attachments->fast_apply($text, $options);

		if ($new_text == '') {
			$new_text = $text;
		}

		return $new_text;
	}

}
