<?php

namespace WhitespaceCookieConsent;

class ExposeSettings {

  public function __construct() {
    /**
     * Create graphql Type WhitespaceCookieSettings
     */

    add_action("graphql_register_types", function () {
      // Register all objects types
      register_graphql_object_type("WhitespaceCookieConsent", [
        "fields" => [
          "active" => [
            "type" => "Boolean",
            "description" => __("", ""),
            'resolve' => function ($source) {
              return !empty($source['active']);
              ;
            },
          ],
          "position" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "strings" => [
            "type" => 'WhitespaceCookieConsentStrings',
            "description" => __("", ""),
          ],
          "whitelist" => [
            "type" => ['list_of' => 'String'],
            "description" => __("", ""),
          ],
        ],
      ]);

      // Register field types
      register_graphql_object_type("WhitespaceCookieConsentStrings", [
        "fields" => [
          "title" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "text" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "allow" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "deny" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "readMore" => [
            "type" => "String",
            "description" => __("", ""),
          ],
          "readMoreURL" => [
            "type" => "String",
            "description" => __("", ""),
          ]
        ],
      ]);

      register_graphql_field('RootQuery', 'whitespaceCookieConsent', [
        'type' => 'WhitespaceCookieConsent',
        'resolve' => function () {
          return get_option('whitespace_cookie_consent');
        },
      ]);
    });
  }
}
