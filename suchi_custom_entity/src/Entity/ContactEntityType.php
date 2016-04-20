<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\Entity\ContactEntityType.
 */

namespace Drupal\suchi_custom_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\suchi_custom_entity\ContactEntityTypeInterface;

/**
 * Defines the Contact entity type entity.
 *
 * @ConfigEntityType(
 *   id = "contact_type",
 *   label = @Translation("Contact entity type"),
 *   handlers = {
 *     "list_builder" = "Drupal\suchi_custom_entity\ContactEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\suchi_custom_entity\Form\ContactEntityTypeForm",
 *       "edit" = "Drupal\suchi_custom_entity\Form\ContactEntityTypeForm",
 *       "delete" = "Drupal\suchi_custom_entity\Form\ContactEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\suchi_custom_entity\ContactEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "contact_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "contact",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/contact_type/{contact_type}",
 *     "add-form" = "/admin/structure/contact_type/add",
 *     "edit-form" = "/admin/structure/contact_type/{contact_type}/edit",
 *     "delete-form" = "/admin/structure/contact_type/{contact_type}/delete",
 *     "collection" = "/admin/structure/contact_type"
 *   }
 * )
 */
class ContactEntityType extends ConfigEntityBundleBase implements ContactEntityTypeInterface {
  /**
   * The Contact entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Contact entity type label.
   *
   * @var string
   */
  protected $label;

}
