<?php
/**
 * Created by PhpStorm.
 * User: suchi.garg
 * Date: 5/29/16
 * Time: 7:34 PM
 */

namespace Drupal\suchi_custom_entity\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AccessOriginSubscriber implements EventSubscriberInterface{

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('addAccessAllowOriginHeaders');
    return $events;
  }

  public function addAccessAllowOriginHeaders(FilterResponseEvent $event) {
    $response= $event->getResponse();
    $response->headers->set('Access-Control-Allow-Origin', '*');
  }

}