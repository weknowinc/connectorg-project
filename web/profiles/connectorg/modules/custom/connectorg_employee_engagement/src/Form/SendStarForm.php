<?php

namespace Drupal\connectorg_employee_engagement\Form;

use Drupal\connectorg_employee_engagement\Entity\StarEntity;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\taxonomy\TermInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form to send a reward.
 */
class SendStarForm extends FormBase implements ContainerInjectionInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'send_star_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, TermInterface $type = NULL, User $user = NULL) {
    $form['markup'] = [
      '#type' => 'markup',
      '#markup' => $this->getFormTitle($type, $user),
      '#weight' => 0,
      '#access' => FALSE
    ];

    $enable_to = (empty($user) || $user->isAnonymous() || ($user->id() == $this->currentUser()->id()));
    $form['to'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('To'),
      '#target_type' => 'user',
      '#default_value' => $enable_to ? NULL : $user,
      '#selection_settings' => [
        'include_anonymous' => FALSE,
        'filter' => [
          'type' => 'role',
          'role' => ['employee'],
        ],
      ],
      '#required' => TRUE,
      '#access' => $enable_to
    ];

    $enable_type = (empty($type) || !$type->isPublished());
    $form['type'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Reward type'),
      '#target_type' => 'taxonomy_term',
      '#default_value' => $enable_type ? NULL : $type,
      '#selection_settings' => ['target_bundles' => ['rewards']],
      '#required' => TRUE,
      '#access' => $enable_type
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('I send this star because...')
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send star!')
    ];


    return $form;
  }

  public function getFormTitle(TermInterface $type = NULL, User $user = NULL) {
    $title = 'Send a star to %user';

    $username = 'someone';
    if (!empty($user) && !$user->isAnonymous() && ($user->id() != $this->currentUser()->id())) {
      $username = $user->label();
    }

    $type_label = '';
    if(!empty($type)) {
      $type_label = $type->label();
      $title = 'Send a %type star to %user';
    }

    return $this->t($title, [
      '%type' => $type_label,
      '%user' => $username
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = $form_state->getValue('to');
    $type = $form_state->getValue('type');
    $message = $form_state->getValue('message');

    $entity = StarEntity::create([
        'field_type' => $type,
        'field_employee' => $user,
        'field_message' => $message,
      ]
    )->save();

    if (!empty($entity)) {
      // emoji star ✨ &#10024;
      // emoji tada 🎉 &#127881;
      $this->messenger()->addStatus(Markup::create("<span style='font-size:3em;'>&#127881;</span> <span>You sent a star!</span>"));
      $form_state->setRedirect('entity.user.canonical', ['user' => $user]);
    } else {
      $this->messenger()->addError($this->t('Oh no!, an error occurred. Please try again.'));
    }

  }

}
