<?php

/**
 * @file
 * Contains \Drupal\suchi_custom_entity\Form\ContactEntityTypeForm.
 */

namespace Drupal\suchi_custom_entity\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContactEntityTypeForm.
 *
 * @package Drupal\suchi_custom_entity\Form
 */
class ContactEntityTypeForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $contact_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $contact_type->label(),
      '#description' => $this->t("Label for the Contact entity type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $contact_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\suchi_custom_entity\Entity\ContactEntityType::load',
      ),
      '#disabled' => !$contact_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $contact_type = $this->entity;
    $status = $contact_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Contact entity type.', [
          '%label' => $contact_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Contact entity type.', [
          '%label' => $contact_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($contact_type->urlInfo('collection'));
  }

}
