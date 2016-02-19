<?php
/*
 *
 * THIS FILE IS CURRENTLY FOR TESTING AND WILL CHANGE DRASTICALLY
 *
 */
include('libs/Parsedown.php');
include('libs/statics.php');

$content = new Statics();

echo $content->getContent('statics/about.md');
