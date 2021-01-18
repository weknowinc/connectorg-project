<?php

namespace Drupal\connectorg_employee_engagement\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Star entity.
 *
 * @ingroup connectorg_employee_engagement
 *
 * @ContentEntityType(
 *   id = "star_entity",
 *   label = @Translation("Star"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\connectorg_employee_engagement\StarEntityListBuilder",
 *     "views_data" = "Drupal\connectorg_employee_engagement\Entity\StarEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\connectorg_employee_engagement\Form\StarEntityForm",
 *       "add" = "Drupal\connectorg_employee_engagement\Form\StarEntityForm",
 *       "edit" = "Drupal\connectorg_employee_engagement\Form\StarEntityForm",
 *       "delete" = "Drupal\connectorg_employee_engagement\Form\StarEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\connectorg_employee_engagement\StarEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\connectorg_employee_engagement\StarEntityAccessControlHandler",
 *   },
 *   base_table = "star_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer star entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/star_entity/{star_entity}",
 *     "add-form" = "/admin/structure/star_entity/add",
 *     "edit-form" = "/admin/structure/star_entity/{star_entity}/edit",
 *     "delete-form" = "/admin/structure/star_entity/{star_entity}/delete",
 *     "collection" = "/admin/structure/star_entity",
 *   },
 *   field_ui_base_route = "star_entity.settings"
 * )
 */
class StarEntity extends ContentEntityBase implements StarEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->label();
  }

  /**
   * {@inheritdoc}
   */
  public function label()
  {
    if (!$this->get('field_type')->isEmpty()) {
      $type = $this->get('field_type')->referencedEntities();
      $type = current($type);
      $label = $type->label();
    } else {
      $label = 'Unknown reward type';
    }
    return $label;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Sent by'))
      ->setDescription(t('The user who sent this star.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status']->setDescription(t('A flag indicating whether this star is hidden.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
