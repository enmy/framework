<?php
namespace Framework\Config;

interface IConfig
{
    public function getKey($key, $default = null);
}