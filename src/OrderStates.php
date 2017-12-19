<?php

namespace GooseStudio\SendOwlAPI;

/**
 * Class OrderStates
 * @package GooseStudio\SendOwlAPI
 */
class OrderStates {
	/**
	 *    A buyer has clicked the buy button or checkout on a cart purchase. They are either entering payment details or have decided not to buy on the payment screen.
	 */
	const Initial = 'initial';

	/**
	 *    The buyer has entered payment details and charging is about to begin (PayPal and GoogleCheckout only)
	 */
	const PaymentStarted = 'payment_started';
	/**
	 *    The buyer has entered payment details and we are waiting for authorisation of payment (PayPal and GoogleCheckout only)
	 */
	const PaymentPending = 'payment_pending';
	/**
	 * Payment was not successful. No access to files has been provided
	 */
	const Failed = 'failed';
	/**
	 * payment has cleared but the products are yet to be delivered as the buyer chose a delivery date in the future
	 */
	const GiftPending = 'gift_pending';
	/**
	 * payment has cleared and the products are available for download
	 */
	const Complete = 'complete';
	/**
	 * the buyer has chargedback their original payment. They have been barred from future downloads of their purchase
	 */
	const ChargeBack = 'chargeback';
	/**
	 * a dispute has been raised against the order (PayPal only). This will eventually settle to complete with or without a refund
	 */
	const InDispute = 'in_dispute';

	/**
	 * The total for the purchase was free and the buyer was immediately issued their purchase
	 */
	const Free = 'free';

	/**
	 * this order was imported from another system. As many details of the original transaction have been retained as possible
	 */
	const Imported = 'imported';
	/**
	 * the order has been marked as to review by the sellers fraud settings. The order will progress to failed or complete state once this has happened.
	 */
	const FraudReview = 'fraud_review';
	/**
	 * a subscription has been setup by the buyer at the payment gateway and we are waiting for it to activate
	 */
	const SubscriptionSetup = 'subscription_setup';
	/**
	 * the subscription is active and the buyer has access to the subscription files
	 */
	const SubscriptionActive = 'subscription_active';
	/**
	 * the buyer has completed all subscription payments and there are no more to charge. Access to files has not been revoked.
	 */
	const SubscriptionComplete = 'subscription_complete';
	/**
	 * the buyer has cancelled the subscription but the seller is allowing access until the payment period reaches it end
	 */
	const SubscriptionCancelling = 'subscription_cancelling';
	/**
	 * the buyer has cancelled the subscription and access to files has been revoked.
	 */
	const SubscriptionCancelled = 'subscription_cancelled';

}