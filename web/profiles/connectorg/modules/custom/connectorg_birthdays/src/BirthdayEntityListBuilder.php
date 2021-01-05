<?php

namespace Drupal\connectorg_birthdays;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\connectorg_birthdays\Entity\BirthdayEntity;

/**
 * Defines a class to build a listing of Birthday entities.
 *
 * @ingroup connectorg_birthdays
 */
class BirthdayEntityListBuilder extends EntityListBuilder {

  /**
   *´ {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Birthday ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var BirthdayEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.birthday_entity.edit_form',
      ['birthday_entity' => $entity->id()]
    );
    $row = parent::buildRow($entity);
    return $row;
  }

}
