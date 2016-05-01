<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

// obtaining the entity manager
$entityManager = EntityManager::create( $conn, $config );


##RabbitMQ
$connection = new AMQPStreamConnection(
	$_SERVER["MLB_MESSAGING_PORT_5672_TCP_ADDR"],
	5672,
	$_SERVER["MLB_MESSAGING_ENV_RABBITMQ_DEFAULT_USER"],
	$_SERVER["MLB_MESSAGING_ENV_RABBITMQ_DEFAULT_PASS"]
	);
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);