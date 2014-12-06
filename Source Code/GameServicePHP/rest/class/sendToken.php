<?php
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/AbstractPayload.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/Payload/Encoder.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/EngineInterface.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/Engine/AbstractSocketIO.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/Client.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/Engine/SocketIO/Session.php');
require( __DIR__ . '/../lib/elephant.io-3.0.0/src/Engine/SocketIO/Version1X.php');
use ElephantIO\Client as Client,
	ElephantIO\Engine\SocketIO\Version1X as Version1X;

class ulti {
	public function sendToken($token){
		$client = new Client(new Version1X('http://localhost:8888'));
		$client->initialize();
		$client->emit('activeToken', ['tokenKey' => $token]);
		$client->close();
	}
}