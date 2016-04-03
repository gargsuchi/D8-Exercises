<?php

/**
 * @file
 * Contains \Drupal\suchi_migrate\Plugin\migrate\source\MoviesgroupActor.
 */

namespace Drupal\suchi_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for movie content.
 *
 * @MigrateSource(
 *   id = "moviesgroup_movie"
 * )
 */
class MoviesgroupMovie extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('movies', 'm')
                 ->fields('m', ['id', 'title', 'body', 'actors', 'genres' ]);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Movie ID'),
      'title' => $this->t('Title of movie'),
      'body' => $this->t('Description of movie'),
      'actors' => $this->t('Actors in the movie'),
      'genres' => $this->t('Genres of movie'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    /**
     * As explained above, we need to pull the genre relationships into our
     * source row here, as an array of 'term' values (the unique ID for
     * the genre migration).
     */
//    $terms = $this->select('movies', 'bt')
//      ->fields('bt', ['genres'])
//      ->condition('id', $row->getSourceProperty('id'))
//      ->execute()
//      ->fetchCol();
//    $row->setSourceProperty('terms', $terms);

    // As we did for favorite beers in the user migration, we need to explode
    // the multi-value country names.
    if ($value = $row->getSourceProperty('actors')) {
      $row->setSourceProperty('actors', explode('|', $value));
    }
    if ($value = $row->getSourceProperty('genres')) {
      $row->setSourceProperty('genres', explode('|', $value));
    }
    //print_r($row);
    return parent::prepareRow($row);
  }
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'm',
      ],
    ];
  }
}
