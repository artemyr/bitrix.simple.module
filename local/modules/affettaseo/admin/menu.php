<?php

IncludeModuleLangFile(__FILE__);

if ($APPLICATION->GetGroupRight("form") > "D") {
    $aMenu = array(
        "parent_menu" => "global_menu_services",
        "section" => "form",
        "sort" => 100,
        "text" => GetMessage("MODULE_NAME"),
        "title" => 'wats is das',
        "icon" => "form_menu_icon",
        "page_icon" => "form_page_icon",
        "module_id" => "affettaseo",
        "items_id" => "menu_affettaseo",
        "items" => array(),
    );

    $aMenu["items"][] = array(
        "text" => GetMessage("SUBMENU"),
        "dynamic" => false,
        "module_id" => "affettaseo",
        "title" => '????',
        "items_id" => "menu_affettaseo_list",
        "url" => "affettaseo_info.php?lang=".LANGUAGE_ID,
//        "items" => $arFormsList,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    $arFormsList[] = array(
        "text" => "Настройки",
        "dynamic" => false,
        "module_id" => "affettaseo",
        "title" => 'ejig',
        "items_id" => "menu_affettaseo_list",
        "url" => "affettaseo_managing.php?lang=".LANGUAGE_ID,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    $aMenu["items"][] = array(
        "text" => GetMessage("SUBMENU"),
        "dynamic" => true,
        "module_id" => "affettaseo",
        "title" => '????',
        "items_id" => "menu_affettaseo_list",
        "items" => $arFormsList,
        "more_url" => array(
            "form_result_list.php",
            "form_result_edit.php",
        )
    );

    return $aMenu;
}
return false;

