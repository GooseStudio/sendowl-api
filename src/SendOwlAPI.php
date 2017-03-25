<?php

namespace GooseStudio\SendOwlAPI;

use PhpSpec\Exception\Exception;
use Requests;

class SendOwlAPI {

	private $url = 'https://www.sendowl.com/api/v1';
	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $secret;
	/**
	 * @var array|null
	 */
	private $options;

	/**
	 * SendOwlAPI constructor.
	 *
	 * @param string $key
	 * @param string $secret
	 * @param array|null $options
	 */
	public function __construct( string $key, string $secret, array $options = null ) {
		$this->key     = $key;
		$this->secret  = $secret;
		$this->options = $options;
		$this->options['auth'] = array( $this->getKey(), $this->getSecret() );
	}

	/**
	 * @return string
	 */
	public function getKey(): string {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function getSecret(): string {
		return $this->secret;
	}

	/**
	 * Retrieves products
	 *
	 * @return array
	 * @throws Exception
	 */
	public function products() {
		$headers = array('Accept' => 'application/json');
		$response = Requests::get( $this->url .'/products', $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new Exception( $response->body, $response->status_code );
	}
}
