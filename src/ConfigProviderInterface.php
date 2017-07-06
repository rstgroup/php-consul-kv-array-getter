<?php


namespace RstGroup\PhpConsulConfigProvider;


interface ConfigProviderInterface
{
    public function getConfig(string $prefix) : array;
}
