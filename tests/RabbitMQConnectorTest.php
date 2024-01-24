<?php

use LaravelRabbit\Queue\Connectors\RabbitMQConnector;
use LaravelRabbit\Queue\RabbitMQQueue;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPUnit\Framework\TestCase;

class RabbitMQConnectorTest extends TestCase
{
    public function test_connect()
    {
        $config = [
            'host'     => getenv('HOST'),
            'port'     => getenv('PORT'),
            'login'    => 'guest',
            'password' => 'guest',
            'vhost'    => '/',

            'queue'              => 'queue_name',
            'exchange_declare'   => true,
            'queue_declare_bind' => true,

            'queue_params' => [
                'passive'     => false,
                'durable'     => true,
                'exclusive'   => false,
                'auto_delete' => false,
            ],
            'exchange_params' => [
                'name'        => null,
                'type'        => 'direct',
                'passive'     => false,
                'durable'     => true,
                'auto_delete' => false,
            ],
        ];

        $connector = new RabbitMQConnector();
        $queue = $connector->connect($config);

        $this->assertInstanceOf(RabbitMQQueue::class, $queue);
        $this->assertInstanceOf(AMQPStreamConnection::class, $connector->connection());
    }
}
