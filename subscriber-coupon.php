<?php
/**
 * Example of filter on each message sent to subscribers to customize per
 * subscriber. The filter replace the tag {coupon} computing it for each subscriber.
 */

/**
 * Register a filer for the messages.
 */
add_filter('newsletter_message', 'my_newsletter_message_filter', 10, 3);

/**
 * Function invoked for EACH message when ready to be sent to a subscriber.
 * It looks for the tag {coupon} and replace it with the result of a coupon generating
 * shortcode (a fake shortcode in this example...).
 * 
 * @param TNP_Mailer_Message $message
 * @param TNP_User $subscriber
 * @return TNP_Mailer_Message
 * 
 * @link https://www.thenewsletterplugin.com/documentation/developers/dev-newsletter-hooks/#filter-newsletter-message
 */
function my_newsletter_message_filter($message, $email, $subscriber) {
    
    // Generate the content to be inserted where the {coupon} tag is found.
    $content = do_shortcode('[coupon email="' . $subscriber->email . '"]');

    // Replacement...
    $message->body = str_replace('{coupon}', $content, $message->body);
    
    return $message;
}


/* Fake shortcode ONLY for test, DO NOT copy this code! */

add_shortcode('coupon', 'my_coupon_shortcode');

function my_coupon_shortcode($attrs, $content) {
    return 'Coupon for ' . $attrs['email'];
}

