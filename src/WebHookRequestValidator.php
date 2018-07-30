<?php
namespace GooseStudio\SendOwlAPI;

/**
 * Class WebHookRequestValidator
 * This class is used to validate WebHook POST requests. Do not use with signed URLs.
 *
 * @see SignedURLRequestValidator
 *
 * @package GooseStudio\SendOwlAPI
 */
class WebHookRequestValidator {
	/**
	 * @var string
	 */
	private $sendowl_api_signing_secret;

	/**
	 * WebHookRequestValidator constructor.
	 * @param string $sendowl_api_signing_secret
	 */
	public function __construct( string $sendowl_api_signing_secret ) {
		$this->sendowl_api_signing_secret = $sendowl_api_signing_secret;
	}

	/**
	 * This test so that the request comes from SendOwl using your API secret string.
	 *
	 * @param string $sendowl_request_signature Found in $_SERVER['HTTP_X_SENDOWL_HMAC_SHA256']
	 * @param string $raw_request_body Usually retrieved using file_get_contents('php://input')
	 *
	 * @return bool
	 */
	public function validate( $sendowl_request_signature, $raw_request_body ) : bool {
		$digest = hash_hmac('SHA256', $raw_request_body, $this->sendowl_api_signing_secret, true );
		$encoded_digest = base64_encode($digest);
		$encoded_digest = trim($encoded_digest);
		return $encoded_digest === $sendowl_request_signature;
	}
}
