<?php

namespace Framework\Config;

/**
* 
*/
class ConstantsMock implements IConfig
{
    public function get($key)
    {
        $consts = array(
            'PATH.APP' => 'test/',
            'NAMESPACE.CONTROLLERS' => 'App\\Controllers\\'
        );
        
        return $consts[$key];
    }
}