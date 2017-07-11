<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul;


use RstGroup\PhpConsulKVArrayGetter\Consul\Helper\ArrayByConsulKeyReducer;
use RstGroup\PhpConsulKVArrayGetter\ConsulArrayGetterInterface;
use RstGroup\PhpConsulKVArrayGetter\Consul\Helper\ConsulJsonToArrayMapper;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Exception\ClientException;
use SensioLabs\Consul\Exception\ServerException;
use SensioLabs\Consul\Services\KVInterface;


final class ConsulArrayGetter implements ConsulArrayGetterInterface
{
    /** @var KVInterface */
    private $consulKeyValueService;

    public function __construct(KVInterface $service)
    {
        $this->consulKeyValueService = $service;
    }

    /**
     * @inheritdoc
     * @throws ClientException when Consul responds with 4XX code
     * @throws ServerException when Consul responds with 5XX code
     */
    public function getByPrefix($prefix)
    {
        /** @var ConsulResponse $response */
        $response = $this->consulKeyValueService->get($prefix, [
            'recurse' => true
        ]);

        return ArrayByConsulKeyReducer::reduce(
            array_replace_recursive(...array_map([ConsulJsonToArrayMapper::class, 'map'], $response->json())),
            $prefix
        );
    }
}
