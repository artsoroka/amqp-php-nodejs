<?php 

namespace App\Http\Controllers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessageController extends Controller {
	
	public function sendMessage(){
		
		$connection = new AMQPStreamConnection('amqpphpnodejs_rabbit_1', 5672, 'rabbitadmin', 'rabbitpass', '/');
		$channel = $connection->channel();

		$queue = 'test'; 
		$exchange = 'router'; 

		/*
		    name: $queue
		    passive: false
		    durable: true // the queue will survive server restarts
		    exclusive: false // the queue can be accessed in other channels
		    auto_delete: false //the queue won't be deleted once the channel is closed.
		*/
		$channel->queue_declare($queue, false, true, false, false);
		/*
		    name: $exchange
		    type: direct
		    passive: false
		    durable: true // the exchange will survive server restarts
		    auto_delete: false //the exchange won't be deleted once the channel is closed.
		*/
		$channel->exchange_declare($exchange, 'direct', false, true, false);
		$channel->queue_bind($queue, $exchange);

		$message = new AMQPMessage('hello world', [
			'content_type' => 'text/plain', 
			'delivery_mode' => 2
		]);
		$channel->basic_publish($message, $exchange);
		$channel->close();
		$connection->close();


		return "message sent"; 
	}

}