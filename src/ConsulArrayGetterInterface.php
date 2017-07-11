<?php


namespace RstGroup\PhpConsulKVArrayGetter;


interface ConsulArrayGetterInterface
{
    /**
     * @param string $prefix
     * @return array the keys of array are keys from consul
     */
    public function getByPrefix($prefix);
}
