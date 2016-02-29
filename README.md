**WARNING: This project is in extreme alpha! It is in active development, but progress is slow going with the limited time I can work on things. You should note: directory structure, file structure, file naming, and tons of other things may change drastically over the course of the alpha. If you wish to follow along and contribute (as of this writing some of the most basic functionality is working) you are welcome to do so, but if you submit an issue _please_ add the date to your post or issue title so I can reference the files you were using!**

# [Tumult](#)

[![Gitter](https://badges.gitter.im/septor/tumult.svg)](https://gitter.im/septor/tumult?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

Tumult is a content aggregator used to publish data from several locations onto one single page for easy viewing. It's written in PHP and utilizes Markdown to serve up static content such as blog posts, **About Me** blurbs, and anything else that isn't parsed in using one of several included Services.

## Services

Think of these as the bulk of your content. Yeah, you can have static content, but that gets old for frequent site vistors. Services are things like your Tweets from Twitter, your new photos on Instagram, your latest listened to tracks according to Last.fm, and even your latest activity on GitHub.

Services are simple to use and set up. In most cases you just need to upload the service you want into the `services` directory and add a few lines to your configuration file and Tumult handles the rest. Of course, some people my want to fine tune things. That's cool, you can do that too by including a separete config file for the specific service inside the `config` folder.

## Requirements

While Tumult is in a very early stage and these may change, here are the minimum requirements needed in order for it to run:

* PHP 5.4+

### Optional Requirements

Here are some things that are supported, but not required:

* A GitHub repo to store blog posts. This will allow you to add, edit, and remove blog posts without needing access to an FTP client.
