<?php

namespace spec\GooseStudio\SendOwlAPI;

use GooseStudio\SendOwlAPI\SendOwlAPI;
use PhpSpec\ObjectBehavior;

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
		$this->get_products()->shouldReturn( json_decode( $transport->body, true ) );
	}

	public function it_should_retrieve_products_per_page_and_page() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/products.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$this->get_products(5,1)->shouldReturn( json_decode( $transport->body, true ) );
	}

	public function it_should_retrieve_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/product.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$this->get_product(1)->shouldReturn(json_decode( $transport->body, true ));
	}

	public function it_should_delete_product() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$this->delete_product(1)->shouldReturn(true);
	}
}
