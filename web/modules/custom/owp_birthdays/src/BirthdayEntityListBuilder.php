<?php

namespace Drupal\owp_birthdays;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Birthday entities.
 *
 * @ingroup owp_birthdays
 */
class BirthdayEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
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
    /* @var \Drupal\owp_birthdays\Entity\BirthdayEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.birthday_entity.edit_form',
      ['birthday_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
