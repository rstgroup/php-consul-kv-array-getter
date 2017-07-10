<?php


namespace RstGroup\PhpConsulConfigProvider;


interface ConsulArrayGetterInterface
{
    /**
     * @param string $prefix
     * @return array
     */
    public function getByPrefix($prefix);
}
