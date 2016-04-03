<?php

/**
 * @file
 * Contains \Drupal\suchi_migrate\Plugin\migrate\source\MoviesgroupActor.
 */

namespace Drupal\suchi_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for beer content.
 *
 * @MigrateSource(
 *   id = "moviesgroup_actor"
 * )
 */
class MoviesgroupActor extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('actors', 'b')
                 ->fields('b', ['id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Actor ID'),
      'name' => $this->t('Name of Actor'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'b',
      ],
    ];
  }
}
