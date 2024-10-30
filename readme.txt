=== Plugin Name ===
Contributors: mihirdhandha
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mihir_d1@yahoo.com&item_name=plugin_domation&currency_code=USD
Tags: limit number of posts, limit posts, number of posts, limit autoblog posts
Requires at least: 2.0.2
Tested up to: 3.0.4

This plugin is useful in conjuction with any auto blogging plugin which automatically posts content to your blog but you don't have total control on number of daily posts. Basically you can set maximum daily posts allowed on your blog.

== Description ==

This plugin is useful in conjuction with any auto blogging plugin which automatically posts content to your blog but you don't have total control on number of daily posts. Basically you can set maximum daily posts allowed on your blog.

Most of the autoblogging plugins use wordpress cron so their frequency is not so accurate. 

To post X posts on your blog regularly, you can enter number of posts allowed daily and all other exceeding posts will be moved to trash (or directly deleted depending on your configuration and wordpress installation version).

If you have selected skip trash option, it won't be possible to recover that post so please make a note of that.

You can suggest new features at http://www.mihir.info/limit-daily-posts

UPDATE: Added most requested "Limit per user" feature.


== Installation ==

1. Upload `limit-daily-posts.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set maximum daily posts in configuration option of "Limit Daily Posts". Default is 2.
4. If you are using Wordpress 2.9+, you can also configure it to automatically delete exceeding posts without moving it to trash to minimize database size.


== Changelog ==

= 1.0 =
* First version.

= 1.0.1 =
* Corrected subdirectory issue which was failing activation of plugin.

= 1.0.2 =
* Added 'Limit per user' feature


== Upgrade Notice ==

= 1.0.1 =
This version fixes a bug failing activation of this plugin, must upgrade.
