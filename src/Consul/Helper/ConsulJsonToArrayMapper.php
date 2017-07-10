<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul\Helper;


final class ConsulJsonToArrayMapper
{
    /**
     * @param array $consulRecord
     * @return array
     */
    public function map(array $consulRecord)
    {
        return $this->mapDirectories(
            $consulRecord['Key'],
            $consulRecord['Value']
        );
    }

    /**
     * @param string      $key
     * @param string|null $value
     * @return array
     */
    private function mapDirectories($key, $value = null)
    {
        $dirs = explode('/', $key);
        // get rid of last exploded item
        $valueKey = array_pop($dirs);

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
