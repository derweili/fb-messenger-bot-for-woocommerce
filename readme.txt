=== Plugin Name ===
Contributors: derweili
Donate link: http://derweili.com/
Tags: facebook, woocommerce, messenger
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Send your order summaries and notices to your customers via Facebook Messenger

== Description ==

This Plugin gives you the ability to send your customer messages to via Facebook Messenger.

Following Messages are supported:

*	[Order Receipts](https://developers.facebook.com/docs/messenger-platform/send-api-reference/receipt-template, "Facebook Documentation")
*	Order status changes
*	Customer Order notes


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/fb-messenger-bot-for-woocomemrce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress




= How do I configure the plugin =

You can find the plugin settings screen here:
WooCommerce->Settings->Messenger Bot

To Configure the plugin follow theese steps

1. Go to https://developers.facebook.com/apps/ and add an new app (or use an existing one)
1.1 Store the App ID on the Plugins Settings Page
2. Got to your Facebook App Settings and fill out the forms (spectialy the Display Name and contact mail)
3. Add "Messenger" as a Product
3. Get the Page Access Token:
3.1. Go to the "Token Generation" section on the Products->Messenger Screen.
3.2. Select the Page you want to use
3.3. Take the Access token you get and save it

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`
