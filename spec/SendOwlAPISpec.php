<?php

namespace spec\GooseStudio\SendOwlAPI;

use PhpSpec\ObjectBehavior;

class SendOwlAPISpec extends ObjectBehavior {
	public function let() {
		$this->beConstructedWith( 'key', 'secret' );
	}

	public function it_should_take_key_and_secret() {
		$this->getKey()->shouldBe( 'key' );
		$this->getSecret()->shouldBe( 'secret' );
	}

	public function it_should_retrieve_products() {
		$transport       = new MockTransport();
		$transport->code = '200';
		$transport->body = file_get_contents( __DIR__ . '/data/products.json' );
		$this->beConstructedWith( 'key', 'secret', [ 'transport' => $transport ] );
		$this->products()->shouldBeEqualTo( json_decode( $transport->body, true ) );
	}
}
