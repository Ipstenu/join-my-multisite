# Join My Multisite #

Welcome to the GitHub development site for Join My Multisite.

The version here is actually 'trunk' so use at your own risk.

## README ##
**Contributors:** Ipstenu  
**Tags:** multisite, wpmu, registration, users  
**Requires at least:** 3.4  
**Tested up to:** 3.5  
**Stable tag:** 1.2
**Donate link:** https://www.wepay.com/donations/halfelf-wp  

Allow site admins to automatically add existing users to their site, or let users decide at the click a button.

## Description ##

When you want to add a user to every site on your network, you've got some pretty cool plugins for that as a network admin. But sometimes you want to let your site-managers have that control, and sometimes you want to make it optional.

By activating this plugin, you give your Site Admins the following options:

* Auto-add users
* Have a 'Join This Site' button in a widget
* Keep things exactly as they are
* Create a per site registration page

It's really that simple! 

If they decide to auto-add, then any time a logged in user visits a site, they will be magically added to that site. If they decide to use a 'Join This Site' button, then they can customize the button message text for users who are logged in but not members, not logged in, or already members. Don't worry, if you have registation turned off, they won't see the 'register' button.

When you have registration turned on, each site can chose to use 'Per Site Registration,' which will allow them to create a page on their site just for registrations and signups. To display the signup code, just put <code>[join-my-multisite]</code> on the page.

* [Plugin Site](http://halfelf.org/plugins/join-my-multisite/)
* [Donate](https://www.wepay.com/donations/halfelf-wp)

##Changelog##

### 1.3 ###

21 November, 2012 by Ipstenu

* Fixed uninstall issue

### 1.2 ###

13 November, 2012 by Ipstenu

* Fixed issues as noted by [dokkaebi](http://wordpress.org/support/topic/problems-and-workarounds-using-v-11-on-wordpress-342)
* Added in option for login form

### 1.1 ###
12 October, 2012 by Ipstenu

* Added in a per-site registration page option.
* Corrected bug where non-network admins couldn't make changes

###  1.0 ###
07 October, 2012 by Ipstenu

* First completed version.

## Installation ##

This plugin is only network activatable. Configuration is done per-site via a page in the 'Users' section.

## Upgrade Notice ##

None yet.

## Frequently Asked Questions ##

### What happens if the network doesn't allow registrations? ###

If registration is turned off, the widget won't display anything for logged-out users.

The <code>[join-my-multisite]</code> shortcode will display a notice that registration is unavailable.

### How do I style the button? ###

By default it will pick up whatever style your theme has, so if it styles buttons, you'll automatically match. If you want more, the css is `input#join-site.button` to just play with the button.

### How do I style the per-site registration page? ###

In your theme's CSS. This is basically the default WordPress signup page, just done in short-code form, so it will default to use your site's CSS anyway. The css falls under `.mu_register` so you can override it in your theme.

### Can users sign up for a blog as well as an account? ###

No. 

That's such a massive network thing, the tinfoil hat in me didn't want to do it. You could fiddle with the signup page code, if you wanted, but I don't plan to support it.