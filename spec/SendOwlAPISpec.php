<?php

namespace spec\GooseStudio\SendOwlAPI;

use GooseStudio\SendOwlAPI\OrderFilter;
use GooseStudio\SendOwlAPI\SendOwlAPI;
use GooseStudio\SendOwlAPI\SendOwlAPIException;
use PhpSpec\ObjectBehavior;

/**
 * Class SendOwlAPISpec
 * @package spec\GooseStudio\SendOwlAPI
 * @mixin SendOwlAPI
 */
class SendOwlAPISpec extends ObjectBehavior {
	public function let() {
		$this->beConstructedWith( 'key', 'secret' );
	}

	public function it_should_take_key_and_secret() {
		$this->get_key()->shouldBe( 'key' );
		$this->get_secret()->shouldBe( 'secret' );
	}

	public function it_should_retrieve_products() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/products.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		try {
			$this->get_products()->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_retrieve_products_per_page_and_page() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/products.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		try {
			$this->get_products( 5, 1 )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_retrieve_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/product.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		try {
			$this->get_product( 1 )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_delete_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$this->delete_product(1)->shouldReturn(true);
	}

	public function it_should_update_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$fields['self_hosted_url'] = 'url';
		$this->update_product(1, $fields)->shouldReturn(true);
	}

	public function it_should_retrieve_licenses_for_license_key() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/licenses.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_license_meta_data( 1, 'AY3C-7C9E-BC3E-J2MB' )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_validate_valid_license_key() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/licenses.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->license_key_is_valid( 1, 'AY3C-7C9E-BC3E-J2MB' )->shouldReturn( true );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_validate_invalid_license_key() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = json_encode([]);
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->license_key_is_valid( 1, 'AY3C-7C9E-BC3E-J2MB' )->shouldReturn( false );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_validate_valid_license_key_but_order_refunded() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/licenses-refunded.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->license_key_is_valid( 1, 'AY3C-7C9E-BC3E-J2MB' )->shouldReturn( false );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_retrieve_licenses_for_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/licenses-many.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_licenses_by_product( 1 )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_retrieve_licenses_for_order() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/licenses-many.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_licenses_by_order( 1 )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}

	public function it_should_retrieve_order_by_id() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/order.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_order( 3101 )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}

	}

	public function it_should_retrieve_orders() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/orders.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_orders()->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}
	public function it_should_retrieve_orders_with_filter() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/orders.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_orders( new OrderFilter() )->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}
	public function it_should_retrieve_orders_by_term() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/orders.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport] );
		try {
			$this->get_orders_by_term( 'buyer@example.com')->shouldReturn( json_decode( $transport->body, true ) );
		} catch ( SendOwlAPIException $e ) {
		}
	}
}
