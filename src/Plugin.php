<?php

namespace WhitespaceCookieConsent;

class Plugin {
  protected $plugin_dir_url;
  public function __construct($wrapper) {
    $this->plugin_dir_url = $wrapper->base_url;
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], -99);
  }

  public function enqueue_scripts() {
    wp_register_script(
      'whitespace-cookie-consent',
      $this->plugin_dir_url . 'assets/dist/cookie-consent.js'
    );

    wp_enqueue_script('whitespace-cookie-consent');

    $options = get_option('whitespace_cookie_consent');
    $settings['currentLanguage'] = get_locale();
    $settings['messages'][get_locale()] = $options['strings'];
    $settings['whitelist'] = $options['whitelist'];
    $settings['trackingUrl'] = admin_url('admin-ajax.php');
    $settings['trackingActions']['answer'] =
      'whitespace_cookie_consent_track_answer';

    wp_localize_script(
      'whitespace-cookie-consent',
      'whitespaceCookieConsentSettings',
      $settings
    );

    wp_register_style(
      'whitespace-cookie-consent',
      $this->plugin_dir_url . 'assets/dist/cookie-consent.css'
    );
    wp_enqueue_style('whitespace-cookie-consent');
  }
}
