<?php
/**
 * Example of filter that add a temporary "fake" name to a subscriber when sending
 * a newsletter to be sure the {name} tag is replaced.
 * 
 * That is useful when a newsletter is started with Dear {name}.
 */

/**
 * Register a filer for the messages.
 */
add_filter('newsletter_send_user', 'my_newsletter_send_user_filter');

/**
 * Function invoked for EACH subscriber when preparing the message to e sent during a newsletter
 * delivery.
 * 
 * Note: the $subscriber onject IS NOT of TNP_User class, that class is declared only for
 * automatic completion on IDEs.
 * 
 * @param TNP_User $subscriber
 * @return TNP_User
 * 
 * @link https://www.thenewsletterplugin.com/documentation/developers/dev-newsletter-hooks/#filter-newsletter-message
 */
function my_newsletter_send_user_filter($subscriber) {
    
    // If the subscriber is missing the name, we "force" it. That IS NOT a permanent change.
    if (empty($subscriber->name)) {
        $subscriber->name = 'Subscriber';
    }
    
    return $subscriber;
}

