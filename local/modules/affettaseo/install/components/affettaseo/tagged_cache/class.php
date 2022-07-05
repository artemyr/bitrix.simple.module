<?php
use \Bitrix\Main\Data\Cache;
use \Bitrix\Main\Application;

/**
 * for custom echo stocks and news
 */
class customNewsList extends CBitrixComponent
{
    private function getNews()
    {
        $arSelect = array("ID", "NAME", "PROPERTY_TYPE", "DETAIL_PAGE_URL", "ACTIVE_FROM");
        $arFilter = array("IBLOCK_ID" => NEWS_IB, "PROPERTY_TYPE" => "5", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(array("SORT"=>"ASC"), $arFilter, false, array("nPageSize" => 4, 'iNumPage' => 1), $arSelect);
        while ($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $tmp['ITEMS']['NEWS'][] = $arFields;
        }

        $arSelect = array("ID", "NAME", "PROPERTY_TYPE", "DETAIL_PAGE_URL", "ACTIVE_FROM");
        $arFilter = array("IBLOCK_ID" => NEWS_IB, "PROPERTY_TYPE" => "6", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(array("SORT"=>"ASC"), $arFilter, false, array("nPageSize" => 4, 'iNumPage' => 1), $arSelect);
        while ($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $tmp['ITEMS']['STOCKS'][] = $arFields;
        }

        // lable
        if (!empty($tmp['ITEMS']['NEWS']) && !empty($tmp['ITEMS']['STOCKS']) )
            $arResult['LABEL'] = "Новости и <span>акции</span>";
        elseif (!empty($tmp['ITEMS']['NEWS']))
            $arResult['LABEL'] = "Новости";
        elseif (!empty($tmp['ITEMS']['STOCKS']))
            $arResult['LABEL'] = "<span>Акции</span>";

        // magic sorting
        $g = 4 - count($tmp['ITEMS']['STOCKS']);
        for ($g;$g > 0;$g--){
            array_unshift($tmp['ITEMS']['STOCKS'],[]);
        }
        for($i = 0; $i < $this->arParams['NEWS_COUNT'];$i++){
            if($i < 2) {
                if (!empty($tmp['ITEMS']['NEWS'][$i]))
                    $arResult['ITEMS'][] = $tmp['ITEMS']['NEWS'][$i];
                elseif (!empty($tmp['ITEMS']['STOCKS'][$i]))
                    $arResult['ITEMS'][] = $tmp['ITEMS']['STOCKS'][$i];
            }
            if($i > 1){
                if (!empty($tmp['ITEMS']['STOCKS'][$i]))
                    $arResult['ITEMS'][] = $tmp['ITEMS']['STOCKS'][$i];
                elseif (!empty($tmp['ITEMS']['NEWS'][$i]))
                    $arResult['ITEMS'][] = $tmp['ITEMS']['NEWS'][$i];
            }
        }

        return $arResult;
    }

    public function executeComponent()
    {
        $cache = Cache::createInstance(); // Служба кеширования
        $taggedCache = Application::getInstance()->getTaggedCache(); // Служба пометки кеша тегами

        /*
         * Чтобы тегированный кеш нашел что ему сбрасывать, необходим
         * одинаковый путь в $cache->initCache() и  $taggedCache->startTagCache()
         * У нас путь указан в $cachePath
         */
        $cachePath = 'mycachepath';
        $cacheTtl = $this->arParams['CACHE_TIME'];
        $cacheKey = 'mycachekey';

        if ($cache->initCache($cacheTtl, $cacheKey, $cachePath)) {
            $this->arResult = $cache->getVars();
//            $cache->output(); // Выводим HTML пользователю в браузер

            /*
             * Еще тут можно вывести данные в браузер, через $cache->output();
             * Тогда получится замена классу CPageCache
             */
        } elseif ($cache->startDataCache()) {
            // Начинаем записывать теги
            $taggedCache->startTagCache($cachePath);

            $this->arResult = $this->getNews();
            // Добавляем теги

            // Кеш сбрасывать при изменении данных в инфоблоке с ID 1
            $taggedCache->registerTag('iblock_id_'.$this->arParams['IBLOCK_ID']);

            // Если что-то пошло не так и решили кеш не записывать
            $cacheInvalid = false;
            if ($cacheInvalid) {
                $taggedCache->abortTagCache();
                $cache->abortDataCache();
            }

            // Всё хорошо, записываем кеш
            $taggedCache->endTagCache();
            $cache->endDataCache($this->arResult);
        }

        $this->includeComponentTemplate();
    }
}