=== Messengerbot for WooCommerce ===
Contributors: derweili
Donate link: http://derweili.de/
Tags: facebook, woocommerce, messenger
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 1.12
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Send order summaries and notices to your WooCommerce customers via Facebook Messenger API

== Description ==

This Plugin gives you the ability to send your customers order notifications via the Facebook Messenger API.

Following Messages are supported:

*	[Order Receipts](https://developers.facebook.com/docs/messenger-platform/send-api-reference/receipt-template, "Facebook Documentation")
*	Order status changes
*	Customer Order notes


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/fb-messenger-bot-for-woocomemrce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How do I configure the plugin =

You can find the plugin settings screen here:
WooCommerce->Settings->Messenger Bot

To Configure the plugin follow theese steps

1. Go to https://developers.facebook.com/apps/ and add an new app (or use an existing one)
1.1 Store the App ID on the Plugins Settings Page
2. Got to your Facebook App Settings and fill out the forms
3. Add "Messenger" as a Product
3. Get the Page Access Token:
3.1. Go to the "Token Generation" section on the Products->Messenger Screen.
3.2. Select the Page you want to use
3.3. Take the Access token you get and save it
4. Set up the webhook
4.1. Add a webhook to you Facebook App: Add Product -> Webhooks -> Get started
4.2. Add a Subscription: New Subsciption-> Page
4.3. Fill out the Callback URL. You can find you callback url within the Plugin Settings screen
4.4. Save a custom Verify Token on the plugin settings screen
4.5. Paste this custom verify token in the webhook screen on facebook.
4.6. Check following Subscription Fields: message_delivery, messages, message_account_linking, message_optins, messaging_postbacks
4.7. Click "Verify and Safe"

5. You have finished. Well done!

= Why are the messenger checkbox and send to messenger button not displayed? =

If your FB-App is in development mode (The review process hasn't finished) only the FB-App Developers can see the Buttons while they are logged in into their Facebook Account.

= I still can't see the checkbox and send to Messenger Button =

Please go to the Plugin settings and resave the API Credentials. In most cases this solves the problem.

= The Callback verification failed with HTTP Status Code 404 =

Go to Settings > Permalink and resave the Permalink settings. After this, try again.

= Where can I report bugs? =

Please open an issue on [Github](https://github.com/derweili/fb-messenger-bot-for-woocommerce, "Github") if you found a bug:
https://github.com/derweili/fb-messenger-bot-for-woocommerce

== Screenshots ==

1. **Plugin Settings Screen**

== Changelog ==

= 1.11 =
* Feature: Settings page refactored
* Feature: Tutorial for Settings Page added


= 1.7 =
* Feature: The messages send to the users can now be edited via the plugin settings.

= 1.5 =
* Bugfix: Domain Whitelisting failed while WordPress is installed in subdirectory

= 1.1 =
* Added: Error log for Webhook Calls when WP_DEBUG is enabled 


= 1.1 =
* Webhook function refactored to match WordPress plugin directory guidelines

= 1.0 =
* Initial Plugin Setup
