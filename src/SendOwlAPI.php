<?php

namespace GooseStudio\SendOwlAPI;

use PhpSpec\Exception\Exception;
use Requests;

/**
 * Class SendOwlAPI
 * @package GooseStudio\SendOwlAPI
 */
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
		$this->key             = $key;
		$this->secret          = $secret;
		$this->options         = $options;
		$this->options['auth'] = array( $this->get_key(), $this->get_secret() );
	}

	/**
	 * Retrieve API Key
	 *
	 * @return string
	 */
	public function get_key(): string {
		return $this->key;
	}

	/**
	 * Retrieve API Secret
	 *
	 * @return string
	 */
	public function get_secret(): string {
		return $this->secret;
	}

	/**
	 * Retrieves products
	 *
	 * @param int $per_page Default is 10
	 * @param int $page Default is 1
	 *
	 * @return array
	 * @throws Exception
	 */
	public function get_products( int $per_page = 10, int $page = 1 ) {
		$headers     = [ 'Accept' => 'application/json' ];
		$query_array = [ 'per_page' => $per_page > 0 ?: 10, 'page' => $page >= 1 ?: 1 ];
		$query       = http_build_query( $query_array );
		$response    = Requests::get( $this->url . '/products/?' . $query, $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new Exception( $response->body, $response->status_code );
	}

	/**
	 * Retrieve a product
	 *
	 * @param int $product_id
	 *
	 * @return array
	 * @throws Exception
	 */
	public function get_product( int $product_id ) {
		$headers  = [ 'Accept' => 'application/json' ];
		$response = Requests::get( $this->url . '/products/' . $product_id, $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new Exception( $response->body, $response->status_code );
	}
}
