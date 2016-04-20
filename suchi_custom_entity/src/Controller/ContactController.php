<?php

/**
 * @file
 * Contains \Drupal\node\Controller\NodeController.
 */

namespace Drupal\suchi_custom_entity\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Url;
use Drupal\suchi_custom_entity\ContactEntityInterface;
use Drupal\suchi_custom_entity\Entity\ContactEntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Contact routes.
 */
class ContactController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a ContactController object.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(DateFormatterInterface $date_formatter, RendererInterface $renderer) {
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * Displays add content links for available content types.
   *
   * Redirects to contact/add/[type] if only one content type is available.
   *
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   *   A render array for a list of the contact types that can be added; however,
   *   if there is only one contact type defined for the site, the function
   *   will return a RedirectResponse to the contact add page for that one contact
   *   type.
   */
  public function addPage() {
    echo "here";
    $build = [
      '#theme' => 'contact_add_list',
      '#cache' => [
        'tags' => $this->entityManager()->getDefinition('contact_type')->getListCacheTags(),
      ],
    ];

    $content = array();

    // Only use contact types the user has access to.
    foreach ($this->entityManager()->getStorage('contact_type')->loadMultiple() as $type) {
      $access = $this->entityManager()->getAccessControlHandler('contact')->createAccess($type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $content[$type->id()] = $type;
      }
      $this->renderer->addCacheableDependency($build, $access);
    }



    // Bypass the contact/add listing if only one content type is available.
    if (count($content) == 1) {
      $type = array_shift($content);
      return $this->redirect('contact.add', array('contact_type' => $type->id()));
    }

    $build['#content'] = $content;

    kint($build);

    return $build;
  }

  /**
   * Provides the contact submission form.
   *
   * @param \Drupal\suchi_custom_entity\ContactEntityType $contact_type
   *   The contact type entity for the contact.
   *
   * @return array
   *   A contact submission form.
   */
  public function add(ContactEntityType $contact_type) {
    $contact = $this->entityManager()->getStorage('contact')->create(array(
      'type' => $contact_type->id(),
    ));

    $form = $this->entityFormBuilder()->getForm($contact);

    return $form;
  }

  /**
   * The _title_callback for the contact.add route.
   *
   * @param \Drupal\suchi_custom_entity\ContactEntityType $contact_type
   *   The current contact.
   *
   * @return string
   *   The page title.
   */
  public function addPageTitle(ContactEntityType $contact_type) {
    return $this->t('Create @name', array('@name' => $contact_type->label()));
  }

}
