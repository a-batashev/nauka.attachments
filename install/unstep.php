<?php

if (!check_bitrix_sessid()) {
	return;
}

echo CAdminMessage::ShowNote(getMessage('NAUKA_ATTACHMENTS_UNINSTALL_SUCCESS'));
