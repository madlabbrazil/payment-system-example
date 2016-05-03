#!/usr/bin/env php
<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "bootstrap.php";

$callback = function($req) {
	global $entityManager;

	$msg = json_decode( $req->body );

	$sale_list = array();
	switch ( $msg->type ):
		case 'id':
			$sale = $entityManager->find('Sales', $msg->id);

			$sale_list[] = array(
				'id' => $sale->getId(),
				'product_name' => $sale->getProduct_Name(),
				'quantity' => $sale->getQuantity(),
				'sale_date' => $sale->getDta_Sale(),
			);
			break;
		default:
			$saleRepository = $entityManager->getRepository('Sales');
			$sales = $saleRepository->findAll();

			foreach ( $sales as $sale ):
				$sale_list[] = array(
					'id' => $sale->getId(),
					'product_name' => $sale->getProduct_Name(),
					'quantity' => $sale->getQuantity(),
					'sale_date' => $sale->getDta_Sale(),
					);
			endforeach;
			break;
	endswitch;


	$msg = new AMQPMessage(
	 json_encode( $sale_list ),
		array('correlation_id' => $req->get('correlation_id'))
		);

	$req->delivery_info['channel']->basic_publish(
		$msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack(
		$req->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('rpc_queue', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();