**Warning: This project is a WIP, but is under active development. Things are added as they are ready for testing. The below text is all based on the end product and could change over the course of this projects development. Stay tuned and keep up to date with things by starring this repo, or bookmarking it and checking back!**

# [Tumult](#)

Tumult is a content aggregator used to publish data from several locations onto one single page for easy viewing. It's written in PHP and utilizes Markdown to serve up static content such as blog posts, **About Me** blurbs, and anything else that isn't parsed in using one of several included Services.

## Services

Think of these as the bulk of your content. Yeah, you can have static content, but that gets old for frequent site vistors. Services are things like your Tweets from Twitter, your new photos on Instagram, your latest listened to tracks according to Last.fm, and even your latest activity on GitHub.

Services are simple to use and set up. In most cases you just need to upload the service you want into the `services` directory and add a few line to your configuration file and Tumult handles the rest. Of course, some people my want to fine tune things. That's cool, you can do that too by including a separete config file for the specific service inside the `config` folder.

## Requirements

While Tumult is in a very early stage and these may change, here are the minimum requirements needed in order for it to run:

* PHP 5.4+

### Optional Requirements

Here are some things that are supported, but not required:

* A GitHub repo to store blog posts. This will allow you to add, edit, and remove blog posts without needing access to an FTP client.
