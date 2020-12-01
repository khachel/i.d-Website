<?php
$response = array();

if ( !isset( $_POST['_wpnonce'] )
	|| ! wp_verify_nonce( $_POST['_wpnonce'], 'buy_ticket' ) ) {

	send_failure( __( 'Invalid nonce specified', 'svid-theme-domain' ), 403 );

}

// Get the event ID
$lassie_event_id = $_POST['lassie_event_id'];

// Create Lassie instance for api calls
$personInstance = Lassie::getPersonApi();

// Check we can actually call the API, disappoint the user if not
if(!$personInstance->validate())
	send_failure( __( 'Our system couldn’t find you properly. Weird, right? We’re afraid you have to contact us at svid@tudelft.nl', 'svid-theme-domain' ), 403 );

// Send call to Lassie to sign up for the event and create a payment instance
$LassieResponse = Lassie\Person\Event::pay($personInstance, [
  'activity_id' => $lassie_event_id,
  'mollie_redirect_url' => $_POST['event_url'] . '?return_from=mollie',
]);

// TODO: Error handling transaction creation?

$response['mollie_url'] = $LassieResponse->transactions->mollie_transaction->links->paymentUrl;
$response['message'] = "We’re redirecting you to our payment provider, see you soon!";

wp_send_json_success($response);