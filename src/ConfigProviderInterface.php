<?php


namespace RstGroup\PhpConsulConfigProvider;


interface ConfigProviderInterface
{
    /**
     * @param string $prefix
     * @return array
     */
    public function getConfig($prefix);
}
