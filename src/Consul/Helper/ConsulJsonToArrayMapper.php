<?php


namespace RstGroup\PhpConsulConfigProvider\Consul\Helper;


final class ConsulJsonToArrayMapper
{
    public function map(array $consulRecord) : array
    {
        return $this->mapDirectories(
            $consulRecord['Key'],
            $consulRecord['Value']
        );
    }

    private function mapDirectories(string $key, string $value = null) : array
    {
        $dirs = explode('/', $key);
        // get rid of last exploded item
        $valueKey = array_pop($dirs);

        $result = [];
        $pointer = &$result;

        foreach($dirs as $nestedDirectory) {
            $pointer[$nestedDirectory] = [];
            $pointer = &$pointer[$nestedDirectory];
        }

        if (!empty($valueKey) && $value !== null) {
            $pointer[$valueKey] = base64_decode($value);
        }

        return $result;
    }
}
