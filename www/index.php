<?php
// Simple php-amqplib demo by @tomroyal	
// works with the CloudAMQP add-on
// index.php - web interface to send simple message	
$message_to_send = "some message here";
	
require('./../vendor/autoload.php');
// define('AMQP_DEBUG', true);

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$rmqurl = parse_url(getenv('CLOUDAMQP_URL'));

function sendthis($message,$rmqurl)
    {
        $msgconn = new AMQPConnection($rmqurl['host'], 5672, $rmqurl['user'], $rmqurl['pass'], substr($rmqurl['path'], 1));
		$ch = $msgconn->channel();
		$exchange = 'amq.direct';
		$queue = 'basic_get_queue';
		$ch->queue_declare($queue, false, true, false, false);
		$ch->exchange_declare($exchange, 'direct', true, true, false);
		$ch->queue_bind($queue, $exchange);
		
		$msg = new AMQPMessage($message);
		$ch->basic_publish($msg, $exchange);
		
        $ch->close();
		$msgconn->close();
    }

echo('about to send.. ');
sendthis($message_to_send,$rmqurl);
echo('.. sent.');

?>