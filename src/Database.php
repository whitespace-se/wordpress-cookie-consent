<?php

namespace WhitespaceCookieConsent;

global $whitespace_cookie_consent_db_version;
$whitespace_cookie_consent_db_version = '1';

class Database {
  const DB_VERSION = '1';

  protected $answer_table;

  public function __construct() {
    global $wpdb;
    $this->answer_table = $wpdb->prefix . 'whitespace_cookie_consent_answer';
  }

  public static function init($plugin) {
    $instance = new self();
    register_activation_hook($plugin->file, [$instance, 'install']);
  }

  public function install() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $this->answer_table (
      id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
      answer tinyint(3),
      time datetime,
      PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    add_option('whitespace_cookie_consent_db_version', self::DB_VERSION);
  }

  public function insertAnswer($answer) {
    global $wpdb;
    $wpdb->insert($this->answer_table, [
      'answer' => $answer,
      'time' => current_time('mysql'),
    ]);
  }

  public function getAnswers() {
    global $wpdb;
    return $wpdb->get_results("SELECT * from $this->answer_table", ARRAY_A);
  }
}
