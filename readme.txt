=== Join My Multisite ===
Contributors: Ipstenu
Tags: multisite, wpmu, registration, users
Requires at least: 3.4
Tested up to: 3.5
Stable tag: 1.0
Donate link: https://www.wepay.com/donations/halfelf-wp

Automatically add existing users to any site on your network that they visit, or let them decide at the click a button.

== Description ==

When you want to add a user to every site on your network, you've got some pretty cool plugins for that as a network admin. But sometimes you want to let your site-managers have that control, and sometimes you want to make it optional.

By activating this plugin, you give your Site Admins the option to

* Auto-add users, so any time a logged in user visits a site, they will be magically added to that site.
* Have a 'Join This Site' button in a widget, that they can customize, so logged in users can decide if they want to join that site or not.
* Keep things exactly as they are.
* Pick a role for the new user.

More?

* [Plugin Site](http://halfelf.org/plugins/sitewide-comment-control/)
* [Donate](https://www.wepay.com/donations/halfelf-wp)

==Changelog==

=  1.0 =
* 29 September, 2012 by Ipstenu
* First completed version.

= Credit =
* Brent Shepherd (for Manage Multisite Users, where I lifted some awesome code for the default roles).

== Installation ==

This plugin is only network activatable. Configuration is done per-site via a page in the 'Users' section.

== Screenshots ==

1. Menu
1. Widget

== Upgrade Notice ==

None yet.

== Frequently Asked Questions ==

= My site admins don't see anything! =

They have to be able to add users to the site to use this plugin. It's a logical extension: If you don't want them adding users, why would you be letting them... add users?

They need access to <em>Users -> Add New</em> in order to use the plugin.

= How do I let my site-admins add new users? =

To activate the <em>Users -> Add New</em> page:

1. Go to Settings in the Network Admin dashboard.
2. Select 'Allow site administrators to add new users to their site via the <strong>Users->Add New</strong> page' under Registration settings.
3. Click "Save Changes"

= What if a site doesn't want to use this at all? =

Check the box to 'keep things as they are' and they will still be able to add users to the site.

= What happens if the network doesn't allow registrations? =

Don't worry, if you have registation turned off, then nothing happens. The auto-add will still run for logged in users, but logged out users won't see the 'register' button if the site is using the widget.

= I want to be in charge of this, not my admins =

Then you want <a href="http://wordpress.org/extend/plugins/multisite-user-management/">Multisite User Management</a>, which lets the Network Admin decide who gets added to what site and with what role.