<?php

/* 
 * This is a function that can be integrated in you plugin to create a subscriber
 * when you can collect user's data. You should care to call it and to pass the
 * collected data.
 * 
 * We're keeping the code as simple and plain and understandable as possible.
 * 
 * Please, refer to the TNP_Subscription and TNP_Subscription_Data classes of
 * Newsletter.
 */
function my_subscribe() {
    
    // Ok, at least Newsletter should be there
    if (!class_exists('newsletter')) return;
    
    // Optinally a version check (you should use version_compare())
    if (NEWSLETTER_VERSION < '7.4.0') return;
    
    // This is the object representing a subscription (data and properties) to be
    // sent to Newsletter. The default one is prefilled with some attributes reflecting
    // the plugin settings (opt-mode, pre-assigned lists, ...).
    $subscription = NewsletterSubscription::instance()->get_default_subscription();
    
    // Start filling in the subscriber data.
    $subscription->data->email = '...'; // Of course, mandatory.
    
    // Lists: you integration could optionally add the subscriber to specific list. This is
    // useful to trigger other actions in Newsletter, for example starting an autoresponder series.
    // You should create a configuration side for your plugin where the administrator can select which
    // lists to activate (from 1 to 40).
    $subscription->data->lists['1'] = 1; // Activate list 1.
    $subscription->data->lists['2'] = 0; // Deactivate list 2.
    
    // Those fields are optional!
    $subscription->data->referrer = '...'; // Free string that represent the origin of this subscription
    $subscription->data->email = '...';
    $subscription->data->ip = '...'; // IP address for geolocation
    
    // Subscription options
    $subscription->optin = 'single'; // Or 'double'. Preset following the Newsletter settings, you can comment it out.
    
    $subscription->send_emails = true; // Welcome or activaton emails, should be sent?
    
    $subscription->spamcheck = true; // Perform spam check following the rules set on Newsletter Security page?
    
    // Can return a WP_Error or true.
    $result = NewsletterSubscription::instance()->subscribe2($subscription);
    if (is_wp_error($result)) {
        // You can deal with the error here, but this is a in-process function, do not break the
        // flow with a die(). Do not output messages as well. Best practice is to manage the error
        // from the caller, not here.
    }
    
    return $result;
}
