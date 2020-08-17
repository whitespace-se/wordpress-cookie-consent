<?php

namespace WhitespaceCookieConsent;

/**
 * Partially enerated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class Admin {
  protected $options;

  public function __construct() {
    $this->options = get_option('whitespace_cookie_consent');
    if (is_admin()) {
      add_action('admin_init', [$this, 'page_init']);
    }
  }

  public function page_init() {
    register_setting(
      'reading', // option_group
      'whitespace_cookie_consent', // option_name
      [$this, 'sanitize'] // sanitize_callback
    );

    add_settings_section(
      'whitespace_cookie_consent', // id
      __('Whitespace Cookie Consent'), // title
      function () {
        // echo 'yo';
      }, // callback
      'reading' // page
    );

    add_settings_field(
      'title', // id
      __('Title'), // title
      function () {
        printf(
          '<input class="regular-text" type="text" name="whitespace_cookie_consent[strings][title]" id="title" value="%s">',
          isset($this->options['strings']['title'])
            ? esc_attr($this->options['strings']['title'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'text', // id
      __('Text'), // title
      function () {
        printf(
          '<textarea class="large-text" rows="5" name="whitespace_cookie_consent[strings][text]" id="text">%s</textarea>',
          isset($this->options['strings']['text'])
            ? esc_attr($this->options['strings']['text'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'allow', // id
      __('Allow button label'), // title
      function () {
        printf(
          '<input class="regular-text" type="text" name="whitespace_cookie_consent[strings][allow]" id="allow" value="%s">',
          isset($this->options['strings']['allow'])
            ? esc_attr($this->options['strings']['allow'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'deny', // id
      __('Deny button label'), // title
      function () {
        printf(
          '<input class="regular-text" type="text" name="whitespace_cookie_consent[strings][deny]" id="deny" value="%s">',
          isset($this->options['strings']['deny'])
            ? esc_attr($this->options['strings']['deny'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'readMore', // id
      __('Read more link text'), // title
      function () {
        printf(
          '<input class="regular-text" type="text" name="whitespace_cookie_consent[strings][readMore]" id="readMore" value="%s">',
          isset($this->options['strings']['readMore'])
            ? esc_attr($this->options['strings']['readMore'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'readMoreURL', // id
      __('Read more link URL'), // title
      function () {
        printf(
          '<input class="regular-text" type="text" name="whitespace_cookie_consent[strings][readMoreURL]" id="readMoreURL" value="%s">',
          isset($this->options['strings']['readMoreURL'])
            ? esc_attr($this->options['strings']['readMoreURL'])
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );

    add_settings_field(
      'whitelist', // id
      __('Whitelisted URL patterns'), // title
      function () {
        printf(
          '<textarea class="large-text" rows="5" name="whitespace_cookie_consent[whitelist]" id="whitelist">%s</textarea>',
          isset($this->options['whitelist'])
            ? esc_attr(implode("\n", $this->options['whitelist']))
            : ''
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );
  }

  public function sanitize($input) {
    $sanitary_values = [];
    $sanitary_values['strings'] = [];
    if (!empty($input['strings']['title'])) {
      $sanitary_values['strings']['title'] = $input['strings']['title'];
    }
    if (!empty($input['strings']['text'])) {
      $sanitary_values['strings']['text'] = $input['strings']['text'];
    }
    if (!empty($input['strings']['allow'])) {
      $sanitary_values['strings']['allow'] = $input['strings']['allow'];
    }
    if (!empty($input['strings']['deny'])) {
      $sanitary_values['strings']['deny'] = $input['strings']['deny'];
    }
    if (!empty($input['strings']['readMore'])) {
      $sanitary_values['strings']['readMore'] = $input['strings']['readMore'];
    }
    if (!empty($input['strings']['readMoreURL'])) {
      $sanitary_values['strings']['readMoreURL'] =
        $input['strings']['readMoreURL'];
    }
    if (!empty($input['whitelist'])) {
      preg_match_all('/^\s*(.+?)\s*$/m', $input['whitelist'], $matches);
      $whitelist = $matches[1] ?? [];
      $sanitary_values['whitelist'] = $whitelist;
    } else {
      $sanitary_values['whitelist'] = [];
    }

    return $sanitary_values;
  }
}

/*
 * Retrieve this value with:
 * $options = get_option( 'whitespace_cookie_consent' ); // Array of All Options
 * $title = $options['strings']['title']; // Title
 */
