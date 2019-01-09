<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

if ($_POST["IBLOCK_ID"] && $_POST["ID"]) {

	$IBLOCK_ID = intval($_POST["IBLOCK_ID"]);
	$ID = intval($_POST["ID"]);
	$PROPERTY_CODE = "FILES";
	
	if (CModule::IncludeModule("iblock")) {
		
		$res = CIBlockElement::GetProperty(
			$IBLOCK_ID,
			$ID,
			array("SORT" => "ASC"),
			array("CODE" => $PROPERTY_CODE)
		);
		$arFiles = array();
		while ($arItem = $res->Fetch()) {
			if ($arItem["VALUE"]) {
				$arFiles[] = CFile::GetFileArray($arItem["VALUE"]);
			}
		}
		if ($arFiles) {
			foreach ($arFiles as $arFile) {
				echo '<a class="insert-files" href="javascript:void(0)">';
				if (strpos($arFile["CONTENT_TYPE"], "image/") === 0) {
					echo '<p><img src="'.$arFile["SRC"].'" alt="'.$arFile["ORIGINAL_NAME"].'" width="100"></p>';
				} else {
					echo '<p>'.$arFile["ORIGINAL_NAME"].'</p>';
				}
				echo '</a>';
			}
		} else {
			echo "No files attached.";
		}
	
	}

}
?>
