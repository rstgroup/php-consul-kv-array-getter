<?php


namespace RstGroup\PhpConsulKVArrayGetter\Consul;


use RstGroup\PhpConsulKVArrayGetter\ConsulArrayGetterInterface;
use RstGroup\PhpConsulKVArrayGetter\Consul\Helper\ConsulJsonToArrayMapper;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Services\KVInterface;


final class ConsulArrayGetter implements ConsulArrayGetterInterface
{
    /** @var KVInterface */
    private $consulKeyValueService;

    public function __construct(KVInterface $service)
    {
        $this->consulKeyValueService = $service;
    }

    /** @inheritdoc */
    public function getByPrefix($prefix)
    {
        /** @var ConsulResponse $response */
        $response = $this->consulKeyValueService->get($prefix, [
            'recurse' => true
        ]);

        if ($response->getStatusCode() == 200) {
            $mapper = new ConsulJsonToArrayMapper();

            return array_replace_recursive(...array_map([$mapper, 'map'], $response->json()));
        } else {
            return [];
        }
    }
}
