=== ScrubBill ===
Contributors: ScrubBill, MattGeri
Tags: woocommerce, shipping
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 8.0
Stable tag: 1.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Multi-courier shipping software that makes fulfilment a breeze.

== Description ==

The ScrubBill WooCommerce plugin helps stores connect to their existing ScrubBill account. 

A few notes about this plugin:

*   You cannot create an account or signup via this plugin, this plugin can only be used by existing ScrubBill customers.
*   The plugin will modify some of your checkout labels to help gather better address data.

== Frequently Asked Questions ==

= Can anyone use this plugin? =

No. You need a ScrubBill.com account to use this plugin. Please contact us via trouble@scrubbill.com should you wish to connect your store.

= How can I reach ScrubBill? =

You can visit us online at www.scrubbill.com, or via our helpdesk on trouble@scrubbill.com

== Changelog ==

= 1.1.2 =
* Updated: Changed Scrubbill_Shipping_Method class check to be more robust

= 1.1.1 =
* Added: Build files for the block based checkout experience

= 1.1 =
* Added: Support for Gutenberg based block checkout experience

= 1.0.5 =
* Added: Support for new HPOS in WooCommerce

= 1.0.4 =
* Updated: Changed the validation hook for checking if a PostNet branch is selected
* Updated: Store the branch name in the order meta

= 1.0.3 =
* Updated: Rename PostNet label

= 1.0.2 =
* Added: Added the ability to use either the cart Sub-Total or cart Total for the rates calculation

= 1.0.1 =
* Updated: Force numeric shipping values to string and control decimal precision on API call

= 1.0 =
* Added: Stable initial production release

== Upgrade Notice ==

= 1.0 =
Stable initial production release