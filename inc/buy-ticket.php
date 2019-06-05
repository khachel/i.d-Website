<?php
$response = array();

if ( !isset( $_POST['_wpnonce'] )
	|| ! wp_verify_nonce( $_POST['_wpnonce'], 'buy_ticket' ) ) {

	send_failure( __( 'Invalid nonce specified', 'svid-theme-domain' ), 403 );

}

$lassie_event_id = $_POST['lassie_event_id'];

$current_user = wp_get_current_user();
$lassie_user_id = (int)$current_user->user_login;

$event_subscription = Lassie::getModel(
  'person_model',
  'insert_subscription',
  array(
    'event_id' => $lassie_event_id,
    'person_id' => $lassie_user_id
  )
);

print_r($event_subscription);

$response['event'] = $event_subscription;
$response['message'] = sprintf("you signed up user %s for event %s", $lassie_user_id, $lassie_event_id);
$response['user_id'] = $lassie_user_id;
$response['lassie_event_id'] = $lassie_event_id;

wp_send_json_success($response);