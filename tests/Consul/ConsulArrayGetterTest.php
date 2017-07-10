<?php


namespace RstGroup\PhpConsulKVArrayGetter\Tests\Consul;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RstGroup\PhpConsulKVArrayGetter\Consul\ConsulArrayGetter;
use SensioLabs\Consul\Services\KV;


class ConsulArrayGetterTest extends TestCase
{
    /**
     * @dataProvider consulResponseProvider
     *
     * @param Response $response
     * @param array    $expectedConfig
     */
    public function testItReturnsArrayGeneratedFromConsulKeyValueStorage(Response $response, array $expectedConfig)
    {
        // given: prepared HTTP Consul Response
        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient->method('request')->willReturn($response);

        $kvService = new KV(new \SensioLabs\Consul\Client(
            [], null, $httpClient
        ));

        //
        $configProvider = new ConsulArrayGetter($kvService);


        // when: retrieving config
        $config = $configProvider->getByPrefix('application');

        // then
        $this->assertEquals($expectedConfig, $config);
    }

    public function consulResponseProvider()
    {
        return [
            [
                new Response(
                    200, [],
                    '[
    {
        "LockIndex": 0,
        "Key": "application/",
        "Flags": 0,
        "Value": null,
        "CreateIndex": 11,
        "ModifyIndex": 11
    },
    {
        "LockIndex": 0,
        "Key": "application/cache/",
        "Flags": 0,
        "Value": null,
        "CreateIndex": 14,
        "ModifyIndex": 14
    },
    {
        "LockIndex": 0,
        "Key": "application/cache/uri",
        "Flags": 0,
        "Value": "aHR0cDovL2xvY2FsaG9zdC8=",
        "CreateIndex": 17,
        "ModifyIndex": 17
    },
    {
        "LockIndex": 0,
        "Key": "application/db/",
        "Flags": 0,
        "Value": null,
        "CreateIndex": 13,
        "ModifyIndex": 13
    },
    {
        "LockIndex": 0,
        "Key": "application/db/name",
        "Flags": 0,
        "Value": "ZGF0YWJhc2VfbmFtZQ==",
        "CreateIndex": 19,
        "ModifyIndex": 19
    }
]'
                ),
                [
                    'application' => [
                        'db' => [
                            'name' => 'database_name',
                        ],
                        'cache' => [
                            'uri' => 'http://localhost/'
                        ]
                    ]
                ]
            ]
        ];
    }
}
