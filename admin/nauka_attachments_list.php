<?php require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

IncludeModuleLangFile(__FILE__);

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
		while ($arItem = $res->GetNext()) {
			if ($arItem["VALUE"]) {
				$arFiles[] = CFile::GetFileArray($arItem["VALUE"]);
			}
		}
		if ($arFiles) {
			foreach ($arFiles as $arFile) {
				$isImage = strpos($arFile["CONTENT_TYPE"], "image/") === 0;
				?>
					<div
						class="insert-file"
						data-filename="<?=$arFile["ORIGINAL_NAME"]?>"
						data-src="<?=$arFile["SRC"]?>"
						<?=($isImage) ? ' data-image="data-image" ': ''?>
					>
					<?if ($isImage):?>
						<img src="<?=$arFile["SRC"]?>" alt="<?=$arFile["ORIGINAL_NAME"]?>" title="<?=$arFile["ORIGINAL_NAME"]?>"/>
					<?else:?>
						<div><?=$arFile["ORIGINAL_NAME"]?></div>
					<?endif;?>
					</div>
				<?
			}
		} else {
			echo GetMessage("NAUKA_ATTACHMENTS_NO_SAVED_FILES");
		}

	}

}
