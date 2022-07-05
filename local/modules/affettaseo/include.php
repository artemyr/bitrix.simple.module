<?
/**
 * данный файл подключается в тот момент, когда речь идет о подключении модуля в коде,
 * в нем должны находиться включения всех файлов с библиотеками функций и классов модуля;
 */

global $DB, $MESS, $APPLICATION;
//require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/filter_tools.php");
//
//IncludeModuleLangFile(__FILE__);
//IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/form/errors.php");
//
//define('FORM_CRM_DEFAULT_PATH', '/crm/configs/import/lead.php');
//
$DBType = mb_strtolower($DB->type);

CModule::AddAutoloadClasses(
    "affettaseo",
    array(
//        "CForm" => "classes/".$DBType."/form_cform.php",
        "CAffettaseo" => "classes/general/affettaseo_affettaseo.php",
        "CAffettaseo_ext" => "classes/".$DBType."/affettaseo_affettaseo.php",
    )
);

// set event handlers
//AddEventHandler('form', 'onAfterResultAdd', array('CFormEventHandlers', 'sendOnAfterResultStatusChange'));
//AddEventHandler('form', 'onAfterResultStatusChange', array('CFormEventHandlers', 'sendOnAfterResultStatusChange'));

// append core form field validators
//$path = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/form/validators";
//$handle = opendir($path);
//if ($handle)
//{
//    while(($filename = readdir($handle)) !== false)
//    {
//        if($filename == "." || $filename == "..")
//            continue;
//
//        if (!is_dir($path."/".$filename) && mb_substr($filename, 0, 4) == "val_")
//        {
//            require_once($path."/".$filename);
//        }
//    }
//}