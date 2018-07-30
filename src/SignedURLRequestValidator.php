<?php
namespace GooseStudio\SendOwlAPI;

/**
 * Class SignedURLRequestValidator
 * This class is used to validate signed URL get requests. Do not use with webhooks.
 *
 * @see WebHookRequestValidator
 * @package GooseStudio\SendOwlAPI
 */
class SignedURLRequestValidator {
	/**
	 * @var string
	 */
	private $sendowl_api_signing_key;
	/**
	 * @var string
	 */
	private $signature_secret;

	/**
	 * SendOwlRequestValidator constructor.
	 *
	 * @param string $sendowl_api_signing_key
	 * @param string $signature_secret
	 */
	public function __construct( string $sendowl_api_signing_key, string $signature_secret ) {
		$this->sendowl_api_signing_key = $sendowl_api_signing_key;
		$this->signature_secret = $signature_secret;
	}

	/**
	 * @param array $get_request the GET array as it is. Do not remove signature from the array.
	 *
	 * @return bool
	 */
	public function validate( array $get_request ) : bool {
		$sendowl_request_signature = $get_request['signature'];
		unset($get_request['signature']);
		$get_request['secret'] = $this->signature_secret;
		ksort($get_request, SORT_STRING);
		$query = urldecode(http_build_query($get_request));
		$digest                           = hash_hmac( 'SHA1', $query, $this->sendowl_api_signing_key.'&'.$this->signature_secret, true );
		$encoded_digest                   = base64_encode( $digest );
		$encoded_digest = trim($encoded_digest);
		return $encoded_digest === $sendowl_request_signature;
	}
}