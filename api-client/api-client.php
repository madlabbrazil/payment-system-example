<?php
/*
Plugin Name: Payment System Example
Plugin URI:  https://github.com/madlabbrazil/payment-system-example
Description: This is just a plugin to explain a test
Version:     1.0
Author:      Mesaque Silva
Author URI:  https://madlabbrazil.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PaymentSystemRpcClient {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;

	public function __construct() {
		$this->connection = new AMQPStreamConnection(
			'paysys.madlabbrazil.com', 5672, 'madlab', '290T0CmNFSgLNXF');
		$this->channel = $this->connection->channel();
		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);
		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}
	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}

	public function call($n) {
		$this->response = null;
		$this->corr_id = uniqid();

		$msg = new AMQPMessage(
		 json_encode($n),
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);
		$this->channel->basic_publish($msg, '', 'rpc_queue');
		while(!$this->response) {
			$this->channel->wait();
		}
		return json_decode( $this->response );
	}
};


function payment_system_menu() {
    add_menu_page(
        'Payment Admin',
        'Payment Admin',
        'manage_options',
        'payment-system.php',
        'render_menu',
        plugins_url( 'api-client/img/rsz_23.png' ),
        6
    );
}
add_action( 'admin_menu', 'payment_system_menu' );

function render_menu(){
	$payment = new PaymentSystemRpcClient();
	$response = $payment->call( array('type' => 'fetch_all') );

	$total = count( $response );
	?>
	<meta http-equiv="refresh" content="60">
	<h1>Sumary:</h1>
	<h2>Total: <?php echo $total; ?> products sold</h2>
	<h2>Active search: "fetch_all"</h2>
	<h3>Connection Status: <span style="color:green">Alive<span></h3>
	<h3>Host: paysys.madlabbrazil.com:15672</h3>
	<h3>User: madlab</h3>
	<h3>Password: 290T0CmNFSgLNXF</h3>
	<hr>
	Results:
	<style>
                pre {
		  display:block;
		  font:normal 12px/22px Monaco,Monospace !important;
		  color:#CFDBEC;
		  background-color:#2f2f2f;
		  background-image:-webkit-repeating-linear-gradient(top, #444 0px, #444 22px, #2f2f2f 22px, #2f2f2f 44px);
		  background-image:-moz-repeating-linear-gradient(top, #444 0px, #444 22px, #2f2f2f 22px, #2f2f2f 44px);
		  background-image:-ms-repeating-linear-gradient(top, #444 0px, #444 22px, #2f2f2f 22px, #2f2f2f 44px);
		  background-image:-o-repeating-linear-gradient(top, #444 0px, #444 22px, #2f2f2f 22px, #2f2f2f 44px);
		  background-image:repeating-linear-gradient(top, #444 0px, #444 22px, #2f2f2f 22px, #2f2f2f 44px);
		  padding:0em 1em;
		  overflow:auto;
		}
        </style>
        
	<pre>
	<?php
	var_dump( array_reverse( $response, true ) );
}
?>
