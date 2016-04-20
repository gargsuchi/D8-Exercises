<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\ContactEntityListBuilder.
 */

namespace Drupal\suchi_custom_entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Contact entity entities.
 *
 * @ingroup suchi_custom_entity
 */
class ContactEntityListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Contact entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\suchi_custom_entity\Entity\ContactEntity */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.contact.edit_form', array(
          'contact' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
