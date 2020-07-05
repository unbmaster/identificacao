<?php
/*
 * This file is part of the https://github.com/unbmaster
 * For demonstration purposes, use it at your own risk.
 * (c) UnBMaster <unbmaster@outlook.com>
 * License GNU General Public License (GPL)
 */

namespace Core;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * MessageBroker Class
 *
 * Manipula publish/subscribe RabbitMQ
 * @author UnBMaster <unbmaster@outlook.com>
 * @version 0.1.0
 */
class MessageBroker
{

    /**
     * publish Method
     *
     * Envia mensagem para um exchange/fila
     * @param $exchange string da exchange/fila
     * @param $payload array a ser propagada
     */
    public static function publish($exchange, $payload)
    {
        $cfg = new Config();
        $connection = new AMQPStreamConnection(
            $cfg('rabbitmq.host'),
            $cfg('rabbitmq.port'),
            $cfg('rabbitmq.username'),
            $cfg('rabbitmq.password')
        );
        $channel = $connection->channel();
        $channel->exchange_declare($exchange, 'fanout', false, false, false);
        $payload = json_encode($payload);
        $message = new AMQPMessage($payload);
        $channel->basic_publish($message, $exchange);
        $channel->close();
        $connection->close();
    }

    /**
     * subscribe Method
     *
     * Escuta uma fila e executa uma ação (class/method) quando há evento
     * @param $exchange string nome da exchange
     * @param $queue string nome da fila
     * @param $class string classe a ser instanciada para processar a fila/evento
     * @param $method string método a ser invocado para realizar uma ação
     * @param mixed ...$args argumentos do método
     */
    public static function subscribe($exchange, $queue, $class, $method, ...$args)
    {
        $cfg = new Config();
        $connection = new AMQPStreamConnection(
            $cfg('rabbitmq.host_ip'),
            $cfg('rabbitmq.port'),
            $cfg('rabbitmq.username'),
            $cfg('rabbitmq.password')
        );
        $channel = $connection->channel();
        $channel->exchange_declare($exchange, 'fanout', false, false, false);
        $channel->queue_declare($queue, false, true, false, false);
        $channel->queue_bind($queue, $exchange);
        $callback = function ($message) use ($class, $method, $args) {
            $message = json_decode($message->body, true);
            $instance = new $class();
            $instance->$method($message, ...$args);
        };
        echo "- {$exchange}/{$queue}:\n";
        echo "  Aguardando por requisições...\n\n";
        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}