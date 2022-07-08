<?
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->AddEventHandler("affettaseo", "onBeforeAffettaseoTestLog", "MyonBeforeAffettaseoTestLog");

function MyonBeforeAffettaseoTestLog(&$text)
{
    $text = $text. " добавлено событием";
}