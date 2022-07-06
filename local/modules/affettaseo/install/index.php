<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class affettaseo extends CModule
{
    var $MODULE_ID = "affettaseo";  // - хранит ID модуля (полный код партнерского модуля);
    var $MODULE_VERSION;            //- текущая версия модуля в формате XX.XX.XX;
    var $MODULE_VERSION_DATE;       //- строка содержащая дату версии модуля; дата должна быть задана в формате YYYY-MM-DD HH:MI:SS;
    var $MODULE_NAME;               // - имя модуля;
    var $MODULE_DESCRIPTION;        //- описание модуля;
    var $MODULE_CSS;                //
    var $MODULE_GROUP_RIGHTS = "Y"; //- если задан метод GetModuleRightList, то данное свойство должно содержать Y

    public function __construct()
    {
        $arModuleVersion = array();

        $path = str_replace("\\","/",__FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = 'affettaseo';
        $this->MODULE_DESCRIPTION = 'affettaseo desc';
    }


    function InstallDB($install_wizard = true)
    {
        RegisterModule("affettaseo");
        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        UnRegisterModule("affettaseo");
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        if($_ENV["COMPUTERNAME"]!='BX')
        {
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaseo/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true);
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaseo/install/components", $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
        }

        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaseo/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");

//        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/affettaseo/install/components", $_SERVER["DOCUMENT_ROOT"]."/local/components"); //не рекурсивна
//        DeleteDirFilesEx($_SERVER["DOCUMENT_ROOT"]."/local/components/affettaseo/");
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUninstall()
    {
        $this->UnInstallFiles();
        $this->UnInstallDB(false);
    }

    function GetModuleRightList()
    {
        global $MESS;
        $arr = array(
            "reference_id" => array("D","R","W"),
            "reference" => array(
                "[D] ".GetMessage("FORM_DENIED"),
                "[R] ".GetMessage("FORM_OPENED"),
                "[W] ".GetMessage("FORM_FULL"))
        );
        return $arr;
    }
}
?>