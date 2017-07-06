<?php


namespace RstGroup\PhpConsulConfigProvider\Tests\Consul\Helper;


use PHPUnit\Framework\TestCase;
use RstGroup\PhpConsulConfigProvider\Consul\Helper\ConsulJsonToArrayMapper;


class ConsulJsonToArrayMapperTest extends TestCase
{
    public function testItMapsDirectoryRecordToEmptyNestedArray()
    {
        // given: decoded JSON record
        $decodedJsonConsulEntry = [
            'LockIndex' => 0,
            'Key' => 'application/cache/',
            'Flags' => 0,
            'Value' => null,
            'CreateIndex' => 1,
            'ModifyIndex' => 1,
        ];

        // when
        $mappedArray = (new ConsulJsonToArrayMapper())->map($decodedJsonConsulEntry);

        // then
        $this->assertSame([
            'application' => [
                'cache' => []
            ]
        ], $mappedArray);
    }

    public function testItMapsValueRecordToValueInNestedArray()
    {
        // given: decoded JSON record
        $decodedJsonConsulEntry = [
            'LockIndex' => 0,
            'Key' => 'application/cache/uri',
            'Flags' => 0,
            'Value' => 'aHR0cDovL2xvY2FsaG9zdC8=',
            'CreateIndex' => 1,
            'ModifyIndex' => 1,
        ];

        // when
        $mappedArray = (new ConsulJsonToArrayMapper())->map($decodedJsonConsulEntry);

        // then
        $this->assertSame([
            'application' => [
                'cache' => [
                    'uri' => 'http://localhost/'
                ]
            ]
        ], $mappedArray);
    }
}
