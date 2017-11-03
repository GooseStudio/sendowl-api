<?php

namespace GooseStudio\SendOwlAPI;

use Requests;

/**
 * Class SendOwlAPI
 * @package GooseStudio\SendOwlAPI
 */
class SendOwlAPI {

	private $orders_endpoint = 'https://www.sendowl.com/api/v1.3/orders';
	private $products_endpoint = 'https://www.sendowl.com/api/v1.2/products';
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
	 * @throws SendOwlAPIException
	 */
	public function get_products( int $per_page = 10, int $page = 1 ) {
		$headers     = [ 'Accept' => 'application/json' ];
		$per_page = $per_page > 0 ? $per_page: 10;
		$page = $page >= 1 ? $page : 1;
		$query_array = [ 'per_page' => $per_page, 'page' => $page ];
		$query       = http_build_query( $query_array );
		$response    = Requests::get( $this->products_endpoint .'/?' . $query, $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new SendOwlAPIException( $response->body, $response->status_code );
	}

	/**
	 * Retrieve a product
	 *
	 * @param int $product_id
	 *
	 * @return array
	 * @throws SendOwlAPIException
	 */
	public function get_product( int $product_id ) {
		$headers  = [ 'Accept' => 'application/json' ];
		$response = Requests::get( $this->products_endpoint .'/' . $product_id, $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new SendOwlAPIException( $response->body, $response->status_code );
	}

	/**
	 * Deletes a product
	 *
	 * @param int $product_id
	 *
	 * @return bool
	 */
	public function delete_product( int $product_id ) {
		$headers  = [ 'Accept' => 'application/json' ];
		$response = Requests::delete( $this->products_endpoint .'/' . $product_id, $headers, $this->options );
		if ( $response->success ) {
			return true;
		}

		return false;
	}

	/**
	 * @param int $product_id
	 * @param array $fields
	 *
	 * @return bool
	 */
    public function update_product(int $product_id, array $fields)
    {
	    $headers  = [ 'Accept' => 'application/json' ];
	    $response = Requests::put( $this->products_endpoint .'/' . $product_id, $headers, $fields, $this->options );
	    if ( $response->success ) {
		    return true;
	    }

	    return false;
    }

	/**
	 * @param int $product_id
	 * @param string $license_key
	 *
	 * @return array
	 * @throws SendOwlAPIException
	 */
    public function get_license_meta_data( int $product_id, string $license_key)
    {
	    $headers  = [ 'Accept' => 'application/json' ];
	    $response = Requests::get( $this->products_endpoint .'/' . $product_id . '/licenses/check_valid?key='.$license_key, $headers, $this->options );
	    if ( $response->success ) {
		    return json_decode( $response->body, true );
	    }
	    throw new SendOwlAPIException( $response->body, $response->status_code );
    }

	/**
	 * @param int $product_id
	 * @param string $license_key
	 *
	 * @return bool
	 * @throws SendOwlAPIException
	 */
    public function license_key_is_valid(int $product_id, string $license_key)
    {
    	$license_meta_data = $this->get_license_meta_data($product_id, $license_key);
    	if (empty($license_meta_data)) {
    		return false;
	    }
	    if ( !isset($license_meta_data[0]['license']['order_refunded']) || true === $license_meta_data[0]['license']['order_refunded']) {
    		return false;
	    }
	    return true;
    }

	/**
	 * @param int $product_id
	 *
	 * @return array
	 * @throws SendOwlAPIException
	 */
    public function get_licenses_by_product(int $product_id)
    {
	    $headers  = [ 'Accept' => 'application/json' ];
	    $response = Requests::get( $this->products_endpoint .'/' . $product_id . '/licenses/', $headers, $this->options );
	    if ( $response->success ) {
		    return json_decode( $response->body, true );
	    }
	    throw new SendOwlAPIException( $response->body, $response->status_code );
    }

	/**
	 * @param int $product_id
	 *
	 * @return mixed
	 * @throws SendOwlAPIException
	 */
    public function get_licenses_by_order(int $product_id)
    {
	    $headers  = [ 'Accept' => 'application/json' ];
	    $response = Requests::get( $this->products_endpoint .'/' . $product_id . '/licenses/', $headers, $this->options );
	    if ( $response->success ) {
		    return json_decode( $response->body, true );
	    }
	    throw new SendOwlAPIException( $response->body, $response->status_code );
    }

	/**
	 * @param int $order_id
	 * @return array
	 * @throws SendOwlAPIException
	 */
	public function get_order( int $order_id ) {
		$headers  = [ 'Accept' => 'application/json' ];
		$response = Requests::get( $this->orders_endpoint . '/' . $order_id , $headers, $this->options );
		if ( $response->success ) {
			return json_decode( $response->body, true );
		}
		throw new SendOwlAPIException( $response->body, $response->status_code );
    }
}
