<?php

/**
 * @file
 * Contains Drupal\suchi_queues\Plugin\QueueWorker\SendUserMail.php
 */

namespace Drupal\suchi_queues\Plugin\QueueWorker;

/**
 * A Mail sender that sends mails on CRON run.
 *
 * @QueueWorker(
 *   id = "cron_user_mail",
 *   title = @Translation("Cron User Mail"),
 *   cron = {"time" = 10}
 * )
 */

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SendUserMail extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The node storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $userStorage;

  /**
   * Creates a new NodePublishBase object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $node_storage
   *   The node storage.
   */
  public function __construct(EntityStorageInterface $user_storage) {
    $this->userStorage = $user_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity.manager')->getStorage('user')
    );
  }

  /**
   * Sends mail to user.
   *
   * @param UserInterface $user
   * @return int
   */
  protected function sendMail($account) {
    $params['account'] = $account;
    // MailManagerInterface->mail() parameter.
    \Drupal::service('plugin.manager.mail')
      ->mail('suchi_queues', 'notice', $account->mail, $account->langcode->value, $params);
        //user_preferred_langcode($account), $params);

  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    /** @var UserInterface $user */
    $user = $this->userStorage->load($data->uid);
    if ($user instanceof UserInterface) {
      return $this->sendMail($user);
    }
  }
}