<?php


namespace RstGroup\PhpConsulKVArrayGetter;


interface ConsulArrayGetterInterface
{
    /**
     * @param string $prefix
     * @return array
     */
    public function getByPrefix($prefix);
}
