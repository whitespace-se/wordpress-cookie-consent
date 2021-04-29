<?php

/*
Plugin Name: Whitespace Cookie Consent
Description: Cookie consent dialog with tracking for Wordpress
Author: Whitespace Code
Version: 1.0.0
*/

namespace WhitespaceCookieConsent;

use WhitespaceCookieConsent\Admin;
use WhitespaceCookieConsent\Database;
use WhitespaceCookieConsent\Plugin;
use WhitespaceCookieConsent\Tracker;
use WhitespaceCookieConsent\ExposeSettings;

$base_url = plugin_dir_url(__FILE__);
$base_path = plugin_dir_path(__FILE__);

require $base_path . 'vendor/autoload.php';

$plugin = (object) [
  'file' => __FILE__,
  'base_url' => $base_url,
  'base_path' => $base_path,
];

Database::init($plugin);

new Admin($plugin);
new Plugin($plugin);
new Tracker($plugin);
new ExposeSettings($plugin);
