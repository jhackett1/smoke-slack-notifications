<?php
/*
Plugin Name: Smoke Slack Notifications
Plugin URI: https://github.com/jhackett1/smoke-slack-notifications
Description: Sends notifications of newly published posts into the Smoke Slack team via incoming webhook integration
Version: 1.0.0
Author: Joshua Hackett
Author URI: http://joshuahackett.com
*/

// Actually send the notification, passing in the ID and post object of the published post
function send_notification($ID){
  $slackUrl = "";
  $message = "A new article has been published: <" . get_permalink( $ID ) . "|" . get_the_title( $ID ) . ">";

  $data = array(
    'payload'   => json_encode( array(
      "text"       =>  $message,
      )
    )
  );

  $response = wp_remote_post( $slackUrl, array(
    'method' => 'POST',
    'timeout' => 30,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'body' => $data,
    'cookies' => array()
      )
  );
};

// Run the function on post publication
add_action('publish_post', 'send_notification');
