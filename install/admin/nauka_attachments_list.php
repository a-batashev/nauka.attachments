<?php

$path = '/modules/nauka.attachments/admin/nauka_attachments_list.php';

$localPath = $_SERVER['DOCUMENT_ROOT'] . '/local' . $path;
$bitrixPath = $_SERVER['DOCUMENT_ROOT'] . '/bitrix' . $path;

if (file_exists($localPath)) {
	require $localPath;
} else {
	require $bitrixPath;
}
