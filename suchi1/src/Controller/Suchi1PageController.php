<?php

/**
 * @file
 * Contains \Drupal\suchi1\Controller\Suchi1PageController.
 */

namespace Drupal\suchi1\Controller;

use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Suchi1PageController {

  function show_values_page() {

    $suchi1_text = \Drupal::config('suchi1.settings')->get('suchi1_text1');
    $suchi1_select = \Drupal::config('suchi1.settings')->get('suchi1_select');
    $suchi1_radio = \Drupal::config('suchi1.settings')->get('suchi1_radio');

    $return_value = 'Text value is ' . $suchi1_text . ' <br>';
    $return_value .= 'Select value is ' . $suchi1_select . ' <br>';
    $return_value .= 'Radio value is ' . $suchi1_radio . ' <br>';

    $element = array(
      '#markup' => $return_value,
    );
    return $element;

  }
}