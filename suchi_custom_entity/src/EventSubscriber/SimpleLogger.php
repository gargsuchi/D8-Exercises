<?php
/**
 * Created by PhpStorm.
 * User: suchi.garg
 * Date: 5/29/16
 * Time: 7:46 PM
 */

namespace Drupal\suchi_custom_entity\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SimpleLogger implements  EventSubscriberInterface{

  static function getSubscribedEvents() {
    $events['simple_page.view'][] = array('onPageView');
    //\Drupal::logger('page_simple')->notice('@Page simple visited.');

    return $events;
  }

  function onPageView() {
    \Drupal::logger('page_simple')->notice('Page simple visited.');
  }
}