<?php
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;

/**
 * for custom echo stocks and news
 */
class vueShowMore extends CBitrixComponent
{
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
}