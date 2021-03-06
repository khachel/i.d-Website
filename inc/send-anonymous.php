<?php

  global $response;

  /*
    Inputs possible (* if required):
		- *input
    - about
    - relation
  */

	/**
	 * Send the email and return the success rate
	 *
	 * @param string $input, string $name, string $email
	 * @return bool
	 */
  function send_mail($input, $about, $relation) {

		$options = get_option('id_settings');
    $receiver = $options['id_anonymous_email_addresses_field'];
		$subject = 'Anonymous input form website';

    $message = "<!DOCTYPE html>
        <html>
         <head>
          <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
          <title>Education input: $subject</title>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>";
    $message .= "<body><i>Sent using the contact form at " . get_site_url() .
      "</i><br><br>" . esc_html($input) .
      "<br><br>About: " . esc_html($about) .
      "<br><br>Relation: " . esc_html($relation);
    $message .= "</body>";
    $message .= "</html>";

    $message = wordwrap($message, 70);

		$headers = "From: Anonymous <anonymous@svid.nl>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return wp_mail($receiver, $subject, $message, $headers);

  }



	if(isset($_POST['submit'])) {

    $reCaptchaResponse = captcha_verification();

    if ($reCaptchaResponse) {

			$input = $_POST['feedback'];
	    $about = $_POST['about'];
	    $relation = $_POST['relation'];

      /* VALIDATE INPUT */
      $all_valid = true; // If this value isn't changed to false, it will send. Else it will be reported to the user.

      if(!empty($input)) {
        $send_return = send_mail($input, $about, $relation);
        if($send_return) {
          $response['success'] = true;
        } else {
          $response['success'] = false;
          $response['timestamp'] = date(DATE_ATOM);
          $response['error'] = 'Something went wrong on the server. Apologies for the inconvenience. Does this keep happening? Send an email to svid@tudelft.nl.';
        }
      } else {
        $response['success'] = false;
				$response['error'] = 'You have not entered any input, or something else went wrong. Please try again!';
      }

    } else {
      $response['success'] = false;
      $response['error'] = 'reCaptcha failed, it would appear you are a robot.';
    }

		wp_send_json($response);

  } else {

		wp_send_json(array( 'error' => 'no-submit' ));

	}
