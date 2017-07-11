<?php


namespace RstGroup\PhpConsulKVArrayGetter\Tests\Consul\Helper;


use RstGroup\PhpConsulKVArrayGetter\Consul\Helper\ArrayByConsulKeyReducer;


class ArrayByConsulKeyReducerTest extends \PHPUnit_Framework_TestCase
{
    public function testItReducesArrayToGivenSubarray()
    {
        // given: complicated array
        $complicated = [
            'x' => 'y',
            'foo' => [
                'bar' => [
                    'baz' => 'baz'
                ]
            ]
        ];

        // when
        $reduced = ArrayByConsulKeyReducer::reduce($complicated, 'foo/bar/');

        // then
        $this->assertSame(
            [
                'baz' => 'baz'
            ],
            $reduced
        );
    }
}
