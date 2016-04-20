<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\Plugin\views\argument\Type.
 */

namespace Drupal\suchi_custom_entity\Plugin\views\argument;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\views\Plugin\views\argument\StringArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Argument handler to accept a contact type.
 *
 * @ViewsArgument("contact_type")
 */
class Type extends StringArgument {

  /**
   * contactType storage controller.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $contactTypeStorage;

  /**
   * Constructs a new Contact Type object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityStorageInterface $contact_type_storage) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->contactTypeStorage = $contact_type_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $entity_manager->getStorage('contact_type')
    );
  }

  /**
   * Override the behavior of summaryName(). Get the user friendly version
   * of the contact type.
   */
  public function summaryName($data) {
    return $this->contact_type($data->{$this->name_alias});
  }

  /**
   * Override the behavior of title(). Get the user friendly version of the
   * contact type.
   */
  function title() {
    return $this->contact_type($this->argument);
  }

  function contact_type($type_name) {
    $type = $this->contactTypeStorage->load($type_name);
    $output = $type ? $type->label() : $this->t('Unknown content type');
    return $output;
  }

}
