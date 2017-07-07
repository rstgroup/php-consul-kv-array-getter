<?php


namespace RstGroup\PhpConsulConfigProvider\Consul;


use RstGroup\PhpConsulConfigProvider\ConfigProviderInterface;
use RstGroup\PhpConsulConfigProvider\Consul\Helper\ConsulJsonToArrayMapper;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Services\KVInterface;


final class ConfigProvider implements ConfigProviderInterface
{
    /** @var KVInterface */
    private $consulKeyValueService;

    public function __construct(KVInterface $service)
    {
        $this->consulKeyValueService = $service;
    }

    /** @inheritdoc */
    public function getConfig($prefix)
    {
        /** @var ConsulResponse $response */
        $response = $this->consulKeyValueService->get($prefix, [
            'recurse'
        ]);

        if ($response->getStatusCode() == 200) {
            $mapper = new ConsulJsonToArrayMapper();

            return array_replace_recursive(...array_map([$mapper, 'map'], $response->json()));
        } else {
            return [];
        }
    }
}
