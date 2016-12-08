=== Join My Multisite ===
Contributors: Ipstenu
Tags: multisite, registration, users
Requires at least: 3.7
Tested up to: 4.7
Stable tag: 1.8
Donate link: https://store.halfelf.org/donate/

Allow site admins to automatically add existing users to their site, or let users decide at the click of a button.

== Description ==

<em>This plugin is for Multisite instances only.</em>

When you want to add a user to every site on your network, you've got some pretty cool plugins for that as a network admin. But sometimes you want to let your site-managers have that control, and sometimes you want to make it optional.

By activating this plugin, you give your Site Admins the following options:

* Auto-add users
* Have a 'Join This Site' button in a widget
* Keep things exactly as they are
* Create a per site registration page
* Use a shortcode to put a 'join this site' button on any page/post.

It's really that simple! 

If they decide to auto-add, then any time a logged in user visits a site, they will be magically added to that site. If they decide to use a 'Join This Site' button, then they can customize the button message text for users who are logged in but not members, not logged in, or already members. Don't worry, if you have registration turned off, they won't see the 'register' button.

When you have registration turned on, each site can chose to use 'Per Site Registration,' which will allow them to create a page on their site just for registrations and signups. To display the signup code, just put <code>[join-my-multisite]</code> on the page.

* [Plugin Site](http://halfelf.org/plugins/join-my-multisite/)
* [Donate](https://store.halfelf.org/donate/)

== Installation ==

This plugin is only network activatable. Configuration is done per-site via a page in the 'Users' section.

== Screenshots ==

1. Menu
1. Widget
1. Sample per-site registration front end

== Frequently Asked Questions ==

= This doesn't work if I'm not using Multisite =

It's not supposed to. "Join My <em>Multisite</em>", eh?

= What happens if the network doesn't allow registrations? =

If registration is turned off, the widget won't display anything for logged-out users.

The <code>[join-my-multisite]</code> shortcode will display a notice that registration is unavailable.

= How do I use the per-site registration page? =

<em>None of this will work if the Network Admin has not enabled registrations.</em>

First make a page for your registration. You can name it anything you want, however you can only use top-level pages (so domain.com/pagename/ and not domain.com/parentpage/childpage/). On that page, enter the shortcode <code>[join-my-multisite]</code> around any other content you want.

Next, go to Users > Join My Multisite and check the box to allow for Per Site Registration. Once that option is saved, a new dropdown will appear that will let you select a top-level page on your site. Select which page, and you are good to go.

= Can I put a button for signups on a page or in a post? =

Yep! Use <code>[join-this-site]</code>

= If I use the per-site registration, do I have to use the widget? =

Nope! In fact, you can even select 'none' (i.e. leave things as they are) and <em>still</em> use the per-site shortcode, because magic.

= What if the network allows registration and I don't make a site page? =

Then non-logged-in users will be redirected to the network registration page, and they may not be automatically added to your site (I'm working on that). I strongly suggest you create a page.

= How do I style the button? =

By default it will pick up whatever style your theme has, so if it styles buttons, you'll automatically match. If you want more, the css is `input#join-site.button` to play with the button.

= How do I style the per-site registration page? =

In your theme's CSS. This is basically the default WordPress signup page, just done in short-code form, so it will default to use your site's CSS anyway. The css falls under `.mu_register` of you want to override it in your theme.

= Can users sign up for a blog and an account via this plugin? =

No. That's such a massive network thing, the tinfoil hat in me didn't want to do it. You could fiddle with the signup page code, if you wanted, but I don't plan to support it.

= Is this BuddyPress compatible? =

As far as the BuddyPress basics go (one instance, network activated) it seems to, however it's not supported at this time. One user reported that with BP and JMM active, they weren't getting any emails for registration, so it's probably best to be used as a 'Join if you're logged in' thing, versus a 'Sign up on this site' one.

= Can I set global options? =

At this time, no. I don't have any interest in making per-site registration pages that are controlled by the network admin. You're welcome to fork or submit a pull request on the github repository - https://github.com/Ipstenu/join-my-multisite

= How can I personalize my widget for members? =

This usually means you want to have something like "Howdy, Membername!" show in the widget, versus the default "Nice to see you again." For that you want to filter `jmm_member_welcome()` like this:

`
function filter_jmm_member_welcome( ) {
	global $current_user;
    get_currentuserinfo();
	$welcome = 'Howdy, '.$current_user->display_name.'!';
	return $welcome;
}
add_filter('jmm_member_welcome', 'filter_jmm_member_welcome');
`

==Changelog==

= 1.8 =
08 December, 2016

* Made widget 'welcome' for logged in users filterable
* Changed shortcode 'welcome' for logged in users to announce username.

= 1.7.8 =
06 July, 2015

* Updating widgets to be [compatible with PHP 5 constructors](https://markjaquith.wordpress.com/2009/09/29/using-php5-object-constructors-in-wp-widget-api/). Props chriscct7.

== Upgrade Notice ==
