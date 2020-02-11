<?php

namespace Drupal\owp_employee_engagement;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Star entities.
 *
 * @ingroup owp_employee_engagement
 */
class StarEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\owp_employee_engagement\Entity\StarEntity $entity */
    $row['id'] = $entity->id();
    $row['title'] = Link::createFromRoute(
      $entity->label(),
      'entity.star_entity.edit_form',
      ['star_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
