<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul\Helper;


final class ConsulJsonToArrayMapper
{
    /**
     * @param array $consulRecord
     * @return array
     */
    public static function map(array $consulRecord)
    {
        return self::mapDirectories(
            $consulRecord['Key'],
            $consulRecord['Value']
        );
    }

    /**
     * @param string      $key
     * @param string|null $value
     * @return array
     */
    private static function mapDirectories($key, $value = null)
    {
        list($dirs, $valueKey) = ConsulKeyParser::parseKey($key);

        $result  = [];
        $pointer = &$result;

        foreach ($dirs as $nestedDirectory) {
            $pointer[$nestedDirectory] = [];
            $pointer                   = &$pointer[$nestedDirectory];
        }

        if (!empty($valueKey) && $value !== null) {
            $pointer[$valueKey] = base64_decode($value);
        }

        return $result;
    }
}
