<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
/**
 * Declara qual a fila que será usada
 */
$channel->queue_declare('hello', false, true, false, false);
/**
 * Cria a nova mensagem
 */
$obj = ['nome' => "Rodrigo",
        'idade'=> 37];

$obj = json_encode($obj);

$msg = new AMQPMessage($obj);
/**
 * Envia para a fila
 */
$channel->basic_publish($msg, '', 'hello');
/**
 * Encerra conexão
 */
$channel->close();
$connection->close();