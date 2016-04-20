<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\Form\DeleteMultiple.
 */

namespace Drupal\suchi_custom_entity\Form;

use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Provides a contact deletion confirmation form.
 */
class DeleteMultiple extends ConfirmFormBase {

  /**
   * The array of contacts to delete.
   *
   * @var string[][]
   */
  protected $contactInfo = array();

  /**
   * The tempstore factory.
   *
   * @var \Drupal\user\PrivateTempStoreFactory
   */
  protected $tempStoreFactory;

  /**
   * The contact storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $manager;

  /**
   * Constructs a DeleteMultiple form object.
   *
   * @param \Drupal\user\PrivateTempStoreFactory $temp_store_factory
   *   The tempstore factory.
   * @param \Drupal\Core\Entity\EntityManagerInterface $manager
   *   The entity manager.
   */
  public function __construct(PrivateTempStoreFactory $temp_store_factory, EntityManagerInterface $manager) {
    $this->tempStoreFactory = $temp_store_factory;
    $this->storage = $manager->getStorage('contact');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.private_tempstore'),
      $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'contact_multiple_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->formatPlural(count($this->contactInfo), 'Are you sure you want to delete this item?', 'Are you sure you want to delete these items?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('system.admin_content');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->contactInfo = $this->tempStoreFactory->get('contact_multiple_delete_confirm')->get(\Drupal::currentUser()->id());
    if (empty($this->contactInfo)) {
      return new RedirectResponse($this->getCancelUrl()->setAbsolute()->toString());
    }
    /** @var \Drupal\suchi_custom_entity\contactInterface[] $nodes */
    $contacts = $this->storage->loadMultiple(array_keys($this->contactInfo));

    $items = [];
    foreach ($this->contactInfo as $id => $langcodes) {
      foreach ($langcodes as $langcode) {
        $contact = $contacts[$id]->getTranslation($langcode);
        $key = $id . ':' . $langcode;
        $default_key = $id . ':' . $contact->getUntranslated()->language()->getId();

        // If we have a translated entity we build a nested list of translations
        // that will be deleted.
        $languages = $contact->getTranslationLanguages();
        if (count($languages) > 1 && $contact->isDefaultTranslation()) {
          $names = [];
          foreach ($languages as $translation_langcode => $language) {
            $names[] = $language->getName();
            unset($items[$id . ':' . $translation_langcode]);
          }
          $items[$default_key] = [
            'label' => [
              '#markup' => $this->t('@label (Original translation) - <em>The following content translations will be deleted:</em>', ['@label' => $contact->label()]),
            ],
            'deleted_translations' => [
              '#theme' => 'item_list',
              '#items' => $names,
            ],
          ];
        }
        elseif (!isset($items[$default_key])) {
          $items[$key] = $contact->label();
        }
      }
    }

    $form['contacts'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
    );
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('confirm') && !empty($this->contactInfo)) {
      $total_count = 0;
      $delete_contacts = [];
      /** @var \Drupal\Core\Entity\ContentEntityInterface[][] $delete_translations */
      $delete_translations = [];
      /** @var \Drupal\suchi_custom_entity\contactInterface[] $contacts */
      $contacts = $this->storage->loadMultiple(array_keys($this->contactInfo));

      foreach ($this->contactInfo as $id => $langcodes) {
        foreach ($langcodes as $langcode) {
          $contact = $contacts[$id]->getTranslation($langcode);
          if ($contact->isDefaultTranslation()) {
            $delete_contacts[$id] = $contact;
            unset($delete_translations[$id]);
            $total_count += count($contact->getTranslationLanguages());
          }
          elseif (!isset($delete_contacts[$id])) {
            $delete_translations[$id][] = $contact;
          }
        }
      }

      if ($delete_contacts) {
        $this->storage->delete($delete_contacts);
        $this->logger('content')->notice('Deleted @count posts.', array('@count' => count($delete_contacts)));
      }

      if ($delete_translations) {
        $count = 0;
        foreach ($delete_translations as $id => $translations) {
          $contact = $contacts[$id]->getUntranslated();
          foreach ($translations as $translation) {
            $contact->removeTranslation($translation->language()->getId());
          }
          $contact->save();
          $count += count($translations);
        }
        if ($count) {
          $total_count += $count;
          $this->logger('content')->notice('Deleted @count content translations.', array('@count' => $count));
        }
      }

      if ($total_count) {
        drupal_set_message($this->formatPlural($total_count, 'Deleted 1 post.', 'Deleted @count posts.'));
      }

      $this->tempStoreFactory->get('contact_multiple_delete_confirm')->delete(\Drupal::currentUser()->id());
    }

    $form_state->setRedirect('system.admin_content');
  }

}
