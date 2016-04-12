<?php
// Simple php-amqplib demo by @tomroyal
// works with the CloudAMQP add-on
// worker.php - worker to listen for message, and log it
	
require(__DIR__.'/../vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$rmqurl = parse_url(getenv('CLOUDAMQP_URL'));

function listen($rmqurl)
    {
        $msgconn = new AMQPConnection($rmqurl['host'], 5672, $rmqurl['user'], $rmqurl['pass'], substr($rmqurl['path'], 1));
		$ch = $msgconn->channel();
		$exchange = 'amq.direct';
		$queue = 'basic_get_queue';
		$ch->queue_declare($queue, false, true, false, false);
		$ch->exchange_declare($exchange, 'direct', true, true, false);
		$ch->queue_bind($queue, $exchange);
		
		$ch->basic_consume('basic_get_queue','tomconsumer',false,true,false,false,'outputfunc');
		
		while(count($ch->callbacks)) {
            $ch->wait();
        }
		
        $ch->close();
		$msgconn->close();
    }
    

function outputfunc($msg){
	error_log('received message');
	error_log($msg->body);
};	

listen($rmqurl);
	
?>