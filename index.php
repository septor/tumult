<?php
/*
 *
 * THIS FILE IS CURRENTLY FOR TESTING AND WILL CHANGE DRASTICALLY
 *
 */
include('libs/Parsedown.php');
include('libs/statics.php');

$cp = new Statics();

echo $cp->content('statics/about.md');
