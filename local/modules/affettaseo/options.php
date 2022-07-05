<?php
/**
 * @var global $mid - module id
 * @var global $APPLICATION
 * @var global $Update - if post method save
 * @var global $RestoreDefaults - if post method restoreDefaults
 */

use Bitrix\Main\Loader;

Loader::includeModule('affettaseo');   //инитит классы типа CAffettaseo
IncludeModuleLangFile(__FILE__);

//user rigths for buttons
$FORM_RIGHT = $APPLICATION->GetGroupRight($mid);

//if request method restore
//require before option list
if ($_SERVER['REQUEST_METHOD'] == "GET" && CAffettaseo_ext::IsAdmin() && $RestoreDefaults <> '' && check_bitrix_sessid())
{
    COption::RemoveOption($mid);
    $z = CGroup::GetList($v1, $v2, array("ACTIVE" => "Y", "ADMIN" => "N"));
    while($zr = $z->Fetch())
    {
        $APPLICATION->DelGroupRight($mid, array($zr["ID"]));
    }
}

//module option list and default values
$arAllOptions = array(
    array("MODULE_ACTIVE", "Состояние", array("checkbox", COption::GetOptionString($mid, "MODULE_ACTIVE"))),
    array("PICTURE_FOLDER", "Папка для хранения миниатюр", array("text", COption::GetOptionString($mid, "PICTURE_FOLDER"))),
);



//if request method update
if($_SERVER['REQUEST_METHOD'] == "POST" && CAffettaseo_ext::IsAdmin() && $Update <> '' && check_bitrix_sessid())
{
    foreach($arAllOptions as $ar)
    {
        $name = $ar[0];
        $val = ${$name};
        if($ar[2][0] == "checkbox" && $val != "Y")
        {
            $val = "N";
        }

        COption::SetOptionString($mid, $name, $val);
    }
}

//if request method clear folder
if($_SERVER['REQUEST_METHOD'] == "POST" && CAffettaseo_ext::IsAdmin() && $_POST['clearFolder'] == 'Y' && check_bitrix_sessid())
{
    foreach (glob($_SERVER["DOCUMENT_ROOT"].'/upload/my_resize_cache/*') as $file) {
        if(is_dir($file)) {
            foreach (glob($file."/*") as $file2) {
                unlink($file2);
            }
        }
    }
}

//tabs list title and name
$aTabs = array(
    array("DIV" => "settings", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "form_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
    array("DIV" => "clear", "TAB" => "Не нажимай!", "ICON" => "form_settings", "TITLE" => "Просил же не нажимать!"),
    array("DIV" => "desc", "TAB" => "Описание", "ICON" => "form_settings", "TITLE" => "Как это работает?"),
    array("DIV" => "rights", "TAB" => "Доступ", "ICON" => "form_settings", "TITLE" => "Уровень доступа к модулю"),
);

//tabs init
$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();

//form init
?><form method="POST" id="affettaseo_form_settings" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>"><?=bitrix_sessid_post()?>
    <input type="hidden" name="clearFolder" value="">
<?
//first tab
$tabControl->BeginNextTab();?>
<?php
if(COption::GetOptionString($mid, "MODULE_ACTIVE") == 'Y')
    echo "Модуль роботает!! Не мешай ему.";
else
    echo "Включи его";

//arr options
if (is_array($arAllOptions)):
    foreach($arAllOptions as $Option):
        $val = COption::GetOptionString($mid, $Option[0]);
        $type = $Option[2];
	?>
    <tr>
        <td valign="top" width="50%"><?	if($type[0]=="checkbox")
                echo "<label for=\"".htmlspecialcharsbx($Option[0])."\">".$Option[1]."</label>";
            else
                echo $Option[1];?>
        </td>
        <td valign="top" nowrap width="50%"><?
            if($type[0]=="checkbox"):
                ?><input type="checkbox" name="<?echo htmlspecialcharsbx($Option[0])?>" id="<?echo htmlspecialcharsbx($Option[0])?>" value="Y"<?if($val=="Y")echo" checked";?>><?
            elseif($type[0]=="text"):
                ?><input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?
            elseif($type[0]=="textarea"):
                ?><textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?echo htmlspecialcharsbx($Option[0])?>"><?echo htmlspecialcharsbx($val)?></textarea><?
            endif;
            ?></td>
    </tr>
    <?
    endforeach;
endif;

//second tab
$tabControl->BeginNextTab();?><?
$fs = disk_free_space("/")/1024/1024/1024;
$ts = disk_total_space("/")/1024/1024/1024;
$al = $fs + $ts;
echo "свободного места ".$fs." gb<br>";
echo "занятого места ".$ts." gb<br>";
echo "всего места ".$al." gb<br><br>";?>
<div class="adm-info-message" style="width: 60%">
    Переименованные файлы занимают дополнительное место в дисковом пространстве сервера. Если лимит дисковой квоты привышен модуль перестает генерировать картинки с ЧПУ. Если недостаточно места на сервере можно выключить модуль и затем очистить папку с файлами.
</div><br>
<script type="text/javascript">
    function ClearImageFolder()
    {
        if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')){
            document.querySelector('input[name=clearFolder]').value = 'Y';
            document.querySelector('#affettaseo_form_settings').submit();
        }
    }
</script>
<input <?if ($FORM_RIGHT<"W") echo "disabled" ?> type="submit" onclick="ClearImageFolder();" value="<?echo GetMessage("CLEAR_IMAGE_FOLDER")?>">
<?

//third tab
$tabControl->BeginNextTab();?>
<div class="adm-info-message" style="width: 60%">
    Модуль занимается переписыванием урлов картинок. К тому же он ресайзит их. Картинки по умолчанию хранятся в папке /upload/my_resize_cache/. <br>
    Если места не хватает эту папку можно удалить и она создастся заново сама при необходимости. Модуль можно отключить через галочку, но лучше удалить его полностью и тогда все будет работать как раньше через стандартный ResizeImageGet.<br><br>
    Код для встраивания логики.<br>
    <pre>
if (CModule::IncludeModule('affettaseo')){
    //обрабатываем картинку как нам надо
    $file = Bitrix\Affettaseo\Utils::art_image_resize(
        $item['PREVIEW_PICTURE']['ID'],                 // id файла в битре
        array("width" => 310, "height" => 264),         // настройки сжатия
        $item['NAME'],                                  //будет транслетированно в название файла
        BX_RESIZE_IMAGE_EXACT                           //типы маштабирования
    );
} else {
    // псевдо стандартная логика
    $file = CFile::ResizeImageGet(
        $item['PREVIEW_PICTURE']['ID'],
        array('width' => '310', 'height' => '264'),
        BX_RESIZE_IMAGE_EXACT,
        true
    );
}
/**
 * типы маштабирования
 * BX_RESIZE_IMAGE_EXACT - масштабирует в прямоугольник $arSize без сохранения пропорций;
 * BX_RESIZE_IMAGE_PROPORTIONAL - масштабирует с сохранением пропорций, размер ограничивается $arSize;
 * BX_RESIZE_IMAGE_PROPORTIONAL_ALT - масштабирует с сохранением пропорций, размер ограничивается $arSize, улучшенная обработка
 * */
    </pre>
</div>

<?
//forth tab
$tabControl->BeginNextTab();?>
<?
echo "Ваши права: ".$FORM_RIGHT;
$module_id = "affettaseo"; //need for rights
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>

<? //buttons
$tabControl->Buttons();?>
    <input <?if ($FORM_RIGHT<"W") echo "disabled" ?> type="submit" name="Update" value="<?echo GetMessage("FORM_SAVE_CUSTOM")?>">
    <script type="text/javascript">
        function RestoreDefaults()
        {
            if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?=LANGUAGE_ID?>&mid=<?echo urlencode($mid)?>&<?=bitrix_sessid_get()?>";
        }
    </script>
    <input <?if ($FORM_RIGHT<"W") echo "disabled" ?> type="button" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
    <input type="reset" name="reset" value="<?=GetMessage("FORM_RESET")?>">
<?$tabControl->End();?>

</form>
