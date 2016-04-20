<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\Entity\ContactEntity.
 */

namespace Drupal\suchi_custom_entity\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Contact entity entities.
 */
class ContactEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['contact']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Contact entity'),
      'help' => $this->t('The Contact entity ID.'),
    );

    return $data;
  }

}
