<?php

class artemComp extends CBitrixComponent
{
    function var1()
    {
        $arResult['var1'] = 'abc';
        return $arResult;
    }

    public function executeComponent()
    {
        $this->arResult = array_merge($this->arResult, $this->var1());

        $this->includeComponentTemplate();
    }
}