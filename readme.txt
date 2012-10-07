=== Join My Multisite ===
Contributors: Ipstenu
Tags: multisite, wpmu, registration, users
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 1.0
Donate link: https://www.wepay.com/donations/halfelf-wp

Allow site admins to automatically add existing network users to their site, or let users decide at the click a button.

== Description ==

When you want to add a user to every site on your network, you've got some pretty cool plugins for that as a network admin. But sometimes you want to let your site-managers have that control, and sometimes you want to make it optional.

By activating this plugin, you give your Site Admins the following options:

* Auto-add users
* Have a 'Join This Site' button in a widget
* Keep things exactly as they are

It's really that simple! 

If they decide to auto-add, then any time a logged in user visits a site, they will be magically added to that site.

If they decide to use a 'Join This Site' button, then they can customize the button message text for users who are logged in but not members, not logged in, or already members. Don't worry, if you have registation turned off, they won't see the 'register' button.

* [Plugin Site](http://halfelf.org/plugins/sitewide-comment-control/)
* [Donate](https://www.wepay.com/donations/halfelf-wp)

==Changelog==

=  1.0 =
* 07 October, 2012 by Ipstenu
* First completed version.

== Installation ==

This plugin is only network activatable. Configuration is done per-site via a page in the 'Users' section.

== Screenshots ==

1. Menu
1. Widget

== Upgrade Notice ==

None yet.

== Frequently Asked Questions ==

= What happens if the network doesn't allow registrations? =

Then your non-logged in users see nothing.

= How do I style the button? =

By default it will pick up whatever style your theme has, so if it styles buttons, you'll automatically match. If you want more, the css is `input#join-site.button` to just play with the button.