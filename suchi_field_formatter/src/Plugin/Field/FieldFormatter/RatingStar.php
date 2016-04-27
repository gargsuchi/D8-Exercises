<?php

/**
 * @file
 * Contains \Drupal\suchi_field_formatter\Plugin\Field\FieldFormatter\RatingStar.
 */

namespace Drupal\suchi_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\DecimalFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'rating_star' formatter.
 *
 * @FieldFormatter(
 *   id = "rating_star",
 *   label = @Translation("Rating star"),
 *   field_types = {
 *     "decimal"
 *   }
 * )
 */
class RatingStar extends DecimalFormatter {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      // Implement default settings.
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array(
      // Implement settings form.
    ) + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'rating_formatter',
        '#rating' => $item->value,
      );
    }
    return $elements;
  }
}
