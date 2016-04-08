<?php

namespace Drupal\suchi_text_filter\Plugin\Filter;

use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Filter(
 *   id = "filter_capitalize",
 *   title = @Translation("Capitalization Filter"),
 *   description = @Translation("This filter capitalizes certain text"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 * )
 */
class FilterCapitalize extends FilterBase {

  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['capitalize_words'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Add words which need to be capitalized.'),
      '#default_value' => $this->settings['capitalize_words'],
      '#description' => $this->t('Capitalize the wrods mentioned here, separated by a comma.'),
    );
    return $form;
  }

  public function process($text, $langcode) {
    $words = $this->settings['capitalize_words'];
    $words_array = explode(",", $words);
    $new_text = $text;

    foreach($words_array AS $word) {
      $new_text = str_replace($word, strtoupper($word), $new_text);
    }
    return new FilterProcessResult($new_text);
  }

}
