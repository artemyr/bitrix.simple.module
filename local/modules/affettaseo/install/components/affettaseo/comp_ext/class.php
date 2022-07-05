<?php

CBitrixComponent::includeComponentClass("artem:comp");

class artemComp_ext extends artemComp
{
    function var2()
    {
        $arResult['var2'] = 'abc45646441';
        return $arResult;
    }

    public function executeComponent()
    {
        $this->arResult = array_merge($this->arResult, $this->var2());

        parent::executeComponent();
//        $this->includeComponentTemplate(); // выполняется у родителя
    }
}