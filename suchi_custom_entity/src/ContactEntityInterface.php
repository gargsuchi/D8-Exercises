<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\ContactEntityInterface.
 */

namespace Drupal\suchi_custom_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Contact entity entities.
 *
 * @ingroup suchi_custom_entity
 */
interface ContactEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Contact entity type.
   *
   * @return string
   *   The Contact entity type.
   */
  public function getType();

  /**
   * Gets the Contact entity name.
   *
   * @return string
   *   Name of the Contact entity.
   */
  public function getName();

  /**
   * Sets the Contact entity name.
   *
   * @param string $name
   *   The Contact entity name.
   *
   * @return \Drupal\suchi_custom_entity\ContactEntityInterface
   *   The called Contact entity entity.
   */
  public function setName($name);

  /**
   * Gets the Contact entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Contact entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Contact entity creation timestamp.
   *
   * @param int $timestamp
   *   The Contact entity creation timestamp.
   *
   * @return \Drupal\suchi_custom_entity\ContactEntityInterface
   *   The called Contact entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Contact entity published status indicator.
   *
   * Unpublished Contact entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Contact entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Contact entity.
   *
   * @param bool $published
   *   TRUE to set this Contact entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\suchi_custom_entity\ContactEntityInterface
   *   The called Contact entity entity.
   */
  public function setPublished($published);

}
