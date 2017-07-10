<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul\Helper;


final class ArrayByConsulKeyReducer
{
    /**
     * @param array  $resultArray
     * @param string $key
     *
     * @return array
     */
    public static function reduce(array $resultArray, $key)
    {
        list($dirs,) = ConsulKeyParser::parseKey($key);

        foreach ($dirs as $dir) {
            if (isset($resultArray[$dir])) {
                $resultArray = $resultArray[$dir];
            } else {
                $resultArray = [];
                break;
            }
        }

        return $resultArray;
    }
}
