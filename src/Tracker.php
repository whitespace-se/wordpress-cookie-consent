<?php

namespace WhitespaceCookieConsent;

use WhitespaceCookieConsent\Database;

class Tracker {
  protected $database;

  const ANSWER_NONE = 0;
  const ANSWER_UNKNOWN = -1;
  const ANSWER_ALLOW = 1;
  const ANSWER_DENY = 2;

  public function __construct() {
    $this->database = new Database();
    if (is_admin()) {
      add_action('wp_ajax_whitespace_cookie_consent_track_answer', [
        $this,
        'track_answer',
      ]);
      add_action('wp_ajax_nopriv_whitespace_cookie_consent_track_answer', [
        $this,
        'track_answer',
      ]);
    }
    add_action('wp_dashboard_setup', [$this, 'dashboard_widgets']);
  }

  public function dashboard_widgets() {
    wp_add_dashboard_widget(
      'whitespace_cookie_consent_statistics',
      'Cookie Consent statistics',
      [$this, 'statistics_dashboard_widget_callback']
    );
  }

  public function statistics_dashboard_widget_callback() {
    $answers = $this->database->getAnswers();
    $from = strtotime('-12 months');
    $to = time();
    $group_by = 'month';
    $date_format = 'Y-m';
    $periods_from = strtotime("first day of this month", $from);
    $periods_to = strtotime("first day of next month", $to);

    $rows = [];
    $date = $periods_from;
    while ($date < $periods_to) {
      $formatted_date = date($date_format, $date);
      $rows[$formatted_date] = [
        'date' => $formatted_date,
        self::ANSWER_ALLOW => 0,
        self::ANSWER_DENY => 0,
        self::ANSWER_NONE => 0,
      ];
      $date = strtotime("next $group_by", $date);
    }

    echo '<table width="100%">';
    echo '<thead><tr>';
    echo '<th>' . __('Period') . '</th>';
    echo '<th>' . __('Allowed') . '</th>';
    echo '<th>' . __('Denied') . '</th>';
    echo '<th>' . __('Resets') . '</th>';
    echo '</tr></thead>';

    // $footer_row = [
    //   self::ANSWER_ALLOW => 0,
    //   self::ANSWER_DENY => 0,
    //   self::ANSWER_NONE => 0,
    // ];

    foreach ($answers as $answer) {
      if (isset($date_format)) {
        $date = date($date_format, strtotime($answer['time']));
        if (isset($rows[$date][$answer['answer']])) {
          $rows[$date][$answer['answer']]++;
        }
        // if (isset($footer_row[$answer['answer']])) {
        //   $footer_row[$answer['answer']]++;
        // }
      } else {
        $rows[0][$answer['answer']]++;
      }
    }

    echo '<tbody>';
    foreach (array_reverse($rows) as $row) {
      $sum = $row[self::ANSWER_ALLOW] + $row[self::ANSWER_DENY];
      echo '<tr>';
      echo '<td>' . $row['date'] ?? $this->t('Total') . '</td>';
      echo '<td>' .
        $row[self::ANSWER_ALLOW] .
        ($sum
          ? ' (' .
            number_format(($row[self::ANSWER_ALLOW] / $sum) * 100, 0) .
            '%)'
          : '') .
        '</td>';
      echo '<td>' .
        $row[self::ANSWER_DENY] .
        ($sum
          ? ' (' .
            number_format(($row[self::ANSWER_DENY] / $sum) * 100, 0) .
            '%)'
          : '') .
        '</td>';
      echo '<td>' . $row[self::ANSWER_NONE] . '</td>';
      echo '</tr>';
    }
    echo '</tbody></table>';
  }

  public function track_answer() {
    $answer = $_POST['answer'];
    if (empty($answer)) {
      $this->database->insertAnswer(self::ANSWER_NONE);
    } else {
      switch ($answer) {
        case 'allow':
          $this->database->insertAnswer(self::ANSWER_ALLOW);
          break;
        case 'deny':
          $this->database->insertAnswer(self::ANSWER_DENY);
          break;
        default:
          $this->database->insertAnswer(self::ANSWER_UNKNOWN);
          break;
      }
    }
    wp_die();
  }
}
