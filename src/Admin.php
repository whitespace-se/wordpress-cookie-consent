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
      'active', // id
      __('Activate cookie consent'), // title
      function () {
        printf(
          '<input class="regular-text" type="checkbox" name="whitespace_cookie_consent[active]" id="active" %s value="1">',
          empty($this->options['active'])
            ? ''
            : 'checked'
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );


    add_settings_field(
      'position', // id
      __('Position cookie consent'), // title
      function () {

        $positions = [
          "top" => "Top",
          "topLeft" => "Top Left",
          "topRight" => "Top Right",
          "bottom" => "Bottom",
          "bottomLeft" => "Bottom Left",
          "bottomRight" => "Bottom Right"
        ];

        $string = '<select class="regular-text" type="checkbox" name="whitespace_cookie_consent[position]" id="position">';

        foreach ($positions as $key => $value) {
          $isChosenValue = !empty($this->options['position']) && $this->options['position'] == $key ? 'selected' : '';
          $string .= '<option value="' . $key . '" '. $isChosenValue . '>' . $value . '</option>';
        };

        $string .= '</select>';

        printf($string);
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
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
          '<textarea class="large-text" rows="5" name="whitespace_cookie_consent[whitelist]" id="whitelist">%s</textarea><p class="description">%s</p>',
          isset($this->options['whitelist'])
            ? esc_attr(implode("\n", $this->options['whitelist']))
            : '',
          sprintf(
            __(
              'Add URLs to scripts that doesn’t require consent, one per row. Use %s to match parts of the URL, e.g. %s. Scripts on the same host as this website are always allowed.'
            ),
            '<code>*</code>',
            '<code>https://unpkg.com/*</code>'
          )
        );
      }, // callback
      'reading', // page
      'whitespace_cookie_consent' // section
    );
  }

  public function sanitize($input) {
    $sanitary_values = [];
    $sanitary_values['strings'] = [];
    $sanitary_values['active'] = !empty($input['active']);
    if (!empty($input['position'])) {
      $sanitary_values['position'] = $input['position'];
    }
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
