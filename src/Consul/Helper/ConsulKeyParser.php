<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul\Helper;


final class ConsulKeyParser
{
    /**
     * @param string $key
     * @return array(
     *      string[]    directories
     *      string|null prefix key
     * )
     */
    public static function parseKey($key)
    {
        $dirs = explode('/', $key);
        // get rid of last exploded item
        $lastKeyPart = array_pop($dirs);

        return [ $dirs, $lastKeyPart ];
    }
}
