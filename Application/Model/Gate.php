<?php
namespace Application\Model;

class Gate
{
    //Model('Gate')->isAddons();
    /*
    |--------------------------------------------------------------------------
    | 判断是否addons
    |--------------------------------------------------------------------------
    */
    public function isAddons()
    {
        return Model('RouterAdd')->isAddons();      //是否addons
    }

}


