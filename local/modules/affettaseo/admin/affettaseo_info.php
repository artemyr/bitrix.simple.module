<?
/** @global CMain $APPLICATION */
/** @global $DB CDatabase */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
Loader::includeModule("affettaseo");
require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaseo/prolog.php");
IncludeModuleLangFile(__FILE__);
$APPLICATION->SetTitle(GetMessage("FORM_PAGE_TITLE"));
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

echo "321";

//require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_after.php");
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>