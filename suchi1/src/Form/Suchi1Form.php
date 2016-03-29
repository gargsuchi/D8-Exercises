<?php

/**
 * @file
 * Contains \Drupal\suchi1\Form\Suchi1Form.
 */

namespace Drupal\suchi1\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\PluginFormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Suchi1Form
 * @package Drupal\suchi1\Form
 * The Config Form
 */
class Suchi1Form extends ConfigFormBase {

  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'suchi1_config_form';
  }

  protected function getEditableConfigNames() {
    return ['suchi1.settings'];
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('suchi1.settings');

    $form['suchi1_text1'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Please provide a label'),
      '#default_value' => $config->get('suchi1_text1'),
    );

    $elements = array($this->t('Option1'), $this->t('Option2'), $this->t('Option3'), $this->t('Option4'));

    $form['suchi1_select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select select element'),
      '#default_value' => $config->get('suchi1_select'),
      '#options' => $elements,
    );

    $elements_radio = array(1 => $this->t('Radio1'), 2 => $this->t('Radio2'), 3 => $this->t('Radio3'), 4 => $this->t('Radio4'));

    $form['suchi1_radio'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Select radio element'),
      '#default_value' => $config->get('suchi1_radio'),
      '#options' => $elements_radio,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config('suchi1.settings');
    // Let active plugins save their settings.
    foreach ($this->configurableInstances as $instance) {
      $instance->submitConfigurationForm($form, $form_state);
    }

    if ($form_state->hasValue('suchi1_text1')) {
      $config->set('suchi1_text1', $form_state->getValue('suchi1_text1'));
    }
    if ($form_state->hasValue('suchi1_select')) {
      $config->set('suchi1_select', $form_state->getValue('suchi1_select'));
    }
    if ($form_state->hasValue('suchi1_radio')) {
      $config->set('suchi1_radio', $form_state->getValue('suchi1_radio'));
    }

    $config->save();
  }

}