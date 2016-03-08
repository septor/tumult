# [Tumult](#)

[![Gitter](https://badges.gitter.im/septor/tumult.svg)](https://gitter.im/septor/tumult?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

Tumult is a content aggregator used to publish data from several locations onto one single page for easy viewing. It's written in PHP and utilizes Markdown to serve up static content such as blog posts and "About Me" blurbs.

## Statics (Blog Posts, Static Blocks)

Statics are used to describe content that is handled entirely by Tumult. Static blocks are markdown files that get parsed. Blog posts are things that you handle, they can be created and stored just like static blocks or they can be stored in a GitHub repo for easier editing.

## Services

Think of these as the bulk of your content. Yeah, you can have static content, but that gets old for frequent site vistors. Services are things like your Tweets from Twitter, your new photos on Instagram, your latest listened to tracks according to Last.fm, and even your latest activity on GitHub.

Services are written to be as easy to add as possible. Unless there's an authentication requirement, you can simply drop a service into the `services` folder and be done with it. If authentication is required you only need to modify a `keys.php` file. Additional configuration, for all services, can be achieved by creating a file and throwing it in your `config` directory. More information on this can be found on each individual services wiki article.

## Themes

Yes, Tumult has a theme engine! It's currently in the middle of getting adjustments and finalizations so I won't go into much detail yet!

## Requirements

While Tumult is in a very early stage and these may change, here are the minimum requirements needed in order for it to run:

* PHP 5.6+

**Why 5.6+?** -- In the beginning I was shooting for 5.4+ becuase I was using short arrays `$names = ['tim', 'bob'];` instead of the longer format `$names = array('time', 'bob');` and this is only supported in 5.4+. To make specifying your social usernames easier I want to use an array in a constant. You can do that in `define()` but that requires PHP7+, so, I'm using a different approach.

Please note, as stated above, this is still early in the development so I may throw this last idea out and drop the minimum back down to 5.4+.

### Optional Requirements

Here are some things that are supported, but not required:

* A GitHub repo to store blog posts. This will allow you to add, edit, and remove blog posts without needing access to an FTP client.

## Installation

1. Download the files in the releases tab, or get the repo files for more fixes.
2. Unzip the contents somewhere on your computer.
3. Modify `config/master.example.php` and save it as `config/master.php`
4. Upload everything to your desired location.

That's it! Congratulations!

If you want to utilize GitHub to store your blog posts read up on it in [the wiki](https://github.com/septor/tumult/wiki/Blog-Posts#remote-or-local)!
