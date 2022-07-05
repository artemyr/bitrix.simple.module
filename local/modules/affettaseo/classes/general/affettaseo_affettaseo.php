<?
class CAffettaseo
{
    public static function IsAdmin()
    {
        global $USER, $APPLICATION;
        if (!is_object($USER)) $USER = new CUser;
        if ($USER->IsAdmin()) return true;
        $FORM_RIGHT = $APPLICATION->GetGroupRight("affettaseo");
        if ($FORM_RIGHT>="W") return true;
    }
}