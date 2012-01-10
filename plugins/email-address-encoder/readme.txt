=== Email Address Encoder ===
Contributors: tillkruess
Tags: antispam, anti spam, spam, email, e-mail, mail, spider, crawler, harvester, robots, spambot, block, obfuscate, obfuscation, encode, encoder, encoding, encrypt, encryption, protect, protection
Requires at least: 2.0
Tested up to: 3.3
Stable tag: 1.0.3

A lightweight plugin to protect email addresses from email-harvesting robots by encoding them into decimal and hexadecimal entities.

== Description ==

A lightweight plugin to protect plain email addresses and mailto links from email-harvesting robots by encoding them into decimal and hexadecimal entities. Has effect on the posts, pages, comments, excerpts and text widgets. No UI, no shortcode, no JavaScript — just simple spam protection.


== Installation ==

For detailed installation instructions, please read the [standard installation procedure for WordPress plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

1. Upload the `/email-address-encoder/` directory and its contents to `/wp-content/plugins/`.
2. Login to your WordPress installation and activate the plugin through the _Plugins_ menu.
3. Done. This plugin works without a no user interface or configuration options.


== Frequently Asked Questions ==

= What does this plugin do? =

This plugin hooks into the WordPress filters like `the_content`, `widget_text` and others (additional filters can be added). On each filter a quick (disableable) search for an @-sign is performed. If an @-sign is found, a (overridable) regular expression looks for plain text email addresses.
Found email addresses are replaced with the return value of `eae_encode_str()` (changeable), which obfuscates the email addresses to protect it from being read by email-harvesting robots. This function is slightly faster than WP's built-in `antispambot()` and uses additional hexadecimal entities.

= How can I use WP's antispambot() function instead? =

You specify any valid callback function with the `eae_method` filter to apply to found email addresses: `add_filter('eae_method', function() { return 'antispambot'; });`

= How can I filter other parts of my site? =

If it's a WordPress filter, just register the `eae_encode_emails()` function: `add_filter($tag, 'eae_encode_emails');`, otherwise just filter it directly: `eae_encode_emails($text);`. To encode a single email address use the `eae_encode_str()` function: `<?php echo eae_encode_str('user@foobar.com'); ?>`

= How can I change the regular expression pattern? =

You can override [the pattern](http://fightingforalostcause.net/misc/2006/compare-email-regex.php "Comparing E-mail Address Validating Regular Expressions") with the `eae_regexp` filter: `add_filter('eae_regexp', function() { return '/^pattern$/'; });`

= How can I disable the @-sign check? =

Like this: `add_filter('eae_at_sign_check', '__return_false');`


== Changelog ==

= 1.0.3 =

* Added filter to override the function called to encode
* Improved randomness of encode-function
* Improved speed by doing fast @-sign existence check

= 1.0.2 =

* Added filter to override the regular expression.

= 1.0.1 =

* Effects now also page, post and comment excerpts

= 1.0 =

* Initial release


== Upgrade Notice ==

= 1.0.3 =

Speed and "randomness" improvements.

= 1.0.2 =

Added filter to override the regular expression.

= 1.0.1 =

Effects now also page, post and comment excerpts.
