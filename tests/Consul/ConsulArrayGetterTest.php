<?php


namespace RstGroup\PhpConsulKVArrayGetter\Tests\Consul;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RstGroup\PhpConsulKVArrayGetter\Consul\ConsulArrayGetter;
use SensioLabs\Consul\Services\KV;


class ConsulArrayGetterTest extends TestCase
{
    public function testItReturnsArrayGeneratedFromConsulKeyValueStorage()
    {
        // given: prepared HTTP Consul Response
        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient->method('request')->willReturn(
            new Response(
                200, [], file_get_contents(__DIR__ . '/../resources/response-prefix-without-leading-dir.json')
            )
        );

        $kvService = new KV(new \SensioLabs\Consul\Client(
            [], null, $httpClient
        ));

        //
        $configProvider = new ConsulArrayGetter($kvService);


        // when: retrieving config
        $config = $configProvider->getByPrefix('application');

        // then
        $this->assertEquals(
            [
                'application' => [
                    'db' => [
                        'name' => 'database_name',
                    ],
                    'cache' => [
                        'uri' => 'http://localhost/'
                    ]
                ]
            ],
            $config
        );
    }

    public function testItReturnValuesRelativeToLastGivenPrefixDirectory()
    {
        // given: prepared HTTP Consul Response
        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient->method('request')->willReturn(
            new Response(
                200, [], file_get_contents(__DIR__ . '/../resources/response-prefix-with-leading-dir.json')
            )
        );

        $kvService = new KV(new \SensioLabs\Consul\Client(
            [], null, $httpClient
        ));

        //
        $configProvider = new ConsulArrayGetter($kvService);


        // when: retrieving config
        $config = $configProvider->getByPrefix('application/fol');

        // then
        $this->assertEquals(
            [
                'fold' => 'tralalala',
                'folder' => [
                    'xxx' => 'acx'
                ]
            ],
            $config
        );
    }
}
