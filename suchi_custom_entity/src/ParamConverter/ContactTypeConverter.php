<?php

namespace Drupal\suchi_custom_entity\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\node\Entity\Node;
use Drupal\suchi_custom_entity\Entity\ContactEntityType;
use Symfony\Component\Routing\Route;

class ContactTypeConverter implements ParamConverterInterface {
  public function convert($value, $definition, $name, array $defaults) {
    return ContactEntityType::load($value);
  }

  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'contact_type');
  }
}
