<?php

/**
 * @file
 * Contains \Drupal\node\Entity\NodeRouteProvider.
 */

namespace Drupal\suchi_custom_entity\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\EntityRouteProviderInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Provides routes for nodes.
 */
class ContactEntityRouteProvider implements EntityRouteProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRoutes( EntityTypeInterface $entity_type) {
    $route_collection = new RouteCollection();
    $route = (new Route('/contact/{contact}'))
      ->addDefaults([
        '_controller' => '\Drupal\suchi_custom_entity\Controller\ContactEntityViewController::view',
        '_title_callback' => '\Drupal\suchi_custom_entity\Controller\ContactEntityViewController::title',
      ])
      ->setRequirement('contact', '\d+')
      ->setRequirement('_entity_access', 'contact.view');
    $route_collection->add('entity.contact.canonical', $route);

    $route = (new Route('/contact/{contact}/delete'))
      ->addDefaults([
        '_entity_form' => 'contact.delete',
        '_title' => 'Delete',
      ])
      ->setRequirement('contact', '\d+')
      ->setRequirement('_entity_access', 'contact.delete')
      ->setOption('_contact_operation_route', TRUE);
    $route_collection->add('entity.contact.delete_form', $route);

    $route = (new Route('/contact/{contact}/edit'))
      ->setDefault('_entity_form', 'contact.edit')
      ->setRequirement('_entity_access', 'contact.update')
      ->setRequirement('contact', '\d+')
      ->setOption('_contact_operation_route', TRUE);
    $route_collection->add('entity.contact.edit_form', $route);

    return $route_collection;
  }

}
