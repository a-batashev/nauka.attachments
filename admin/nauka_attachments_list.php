<?php

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_admin_before.php");

Loc::loadMessages(__FILE__);

$post = Context::getCurrent()->getRequest()->getPostList();

$iblockId = (int) $post['IBLOCK_ID'];
$elementId = (int) $post['ID'];

if ($iblockId < 1 || $elementId < 1) {
	return;
}

if (!Loader::includeModule('iblock')) {
	return;
}

if (!\CIBlockElementRights::UserHasRightTo($iblockId, $elementId, 'element_edit')) {
	return;
}

$propertyCode = 'FILES';
$imgMaxWidth = 600;

$res = \CIBlockElement::GetProperty(
	$iblockId,
	$elementId,
	['SORT' => 'ASC'],
	['CODE' => $propertyCode]
);

$files = [];

while ($item = $res->GetNext()) {
	if ($item['VALUE']) {
		$files[] = CFile::GetFileArray($item['VALUE']);
	}
}

if (empty($files)) {
	echo Loc::getMessage('NAUKA_ATTACHMENTS_NO_SAVED_FILES');
	return;
}

foreach ($files as $file) :
	$isImage = strpos($file['CONTENT_TYPE'], 'image/') === 0;
	?>
	<div
		class="insert-file"
		data-filename="<?=$file['ORIGINAL_NAME']?>"
		data-src="<?=$file['SRC']?>"
		<?=($isImage) ? ' data-image="data-image" ': ''?>
		<?=($file['WIDTH'] > $imgMaxWidth) ? ' data-maxwidth="'. $imgMaxWidth .'" ' : ''?>
	>
	<?php if ($isImage):?>
		<img src="<?=$file['SRC']?>" alt="<?=$file['ORIGINAL_NAME']?>" title="<?=$file['ORIGINAL_NAME']?>"/>
	<?php else:?>
		<div><?=$file['ORIGINAL_NAME']?></div>
	<?php endif;?>
	</div>
	<?php
endforeach;
