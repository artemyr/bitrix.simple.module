<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * @var array $arResult
 */
//dump($arResult);
?>
<div class="news__top">
    <h2><?=$arResult['LABEL']?></h2>
    <a class="button button-bord" href="/news/">
        <span>Все новости<svg class="ar"><use xlink:href="#arrow2"></use></svg></span>
    </a>
</div>
<div class="row">
    <div class="col-6">
        <div class="row">
        <?foreach ($arResult['ITEMS'] as $key => $item) :
            if($key > 1) continue;
        //    dump($item['DISPLAY_ACTIVE_FROM']);
            $date = strtotime($item['ACTIVE_FROM']);
            $arr = [
                'январь',
                'февраль',
                'март',
                'апрель',
                'май',
                'июнь',
                'июль',
                'август',
                'сентябрь',
                'октябрь',
                'ноябрь',
                'декабрь'
            ];
            $month = $arr[date('m', $date) - 1];
            ?>
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                <div class="news__item <?=($item['PROPERTY_TYPE_ENUM_ID'] == 6) ? 'news__item-color' : '';?>"><a href="<?=$item['DETAIL_PAGE_URL']?>"></a>
                    <div class="news__item-title"><?=$item['NAME']?></div>
                    <div class="news__item-bottom">
                        <div class="news__item-data"><b class="text-reveal"><span><span><?=date('d', $date)?></span></span><span aria-hidden="true"><span data-text="<?=date('d', $date)?>"></span></span></b>
                            <div class="news__item-data-mn"><?=$month?></div>
                        </div>
                        <div class="news__item-arrow"><svg><use xlink:href="#arrow2"></use></svg></div>
                    </div>
                </div>
            </div>
            <?endforeach?>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <?foreach ($arResult['ITEMS'] as $key => $item) :
                if($key < 2) continue;
                //    dump($item['DISPLAY_ACTIVE_FROM']);
                $date = strtotime($item['ACTIVE_FROM']);
                $arr = [
                    'январь',
                    'февраль',
                    'март',
                    'апрель',
                    'май',
                    'июнь',
                    'июль',
                    'август',
                    'сентябрь',
                    'октябрь',
                    'ноябрь',
                    'декабрь'
                ];
                $month = $arr[date('m', $date) - 1];
                ?>
                <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
                    <div class="news__item <?=($item['PROPERTY_TYPE_ENUM_ID'] == 6) ? 'news__item-color' : '';?>"><a href="<?=$item['DETAIL_PAGE_URL']?>"></a>
                        <div class="news__item-title"><?=$item['NAME']?></div>
                        <div class="news__item-bottom">
                            <div class="news__item-data"><b class="text-reveal"><span><span><?=date('d', $date)?></span></span><span aria-hidden="true"><span data-text="<?=date('d', $date)?>"></span></span></b>
                                <div class="news__item-data-mn"><?=$month?></div>
                            </div>
                            <div class="news__item-arrow"><svg><use xlink:href="#arrow2"></use></svg></div>
                        </div>
                    </div>
                </div>
            <?endforeach?>
        </div>
    </div>
</div>
