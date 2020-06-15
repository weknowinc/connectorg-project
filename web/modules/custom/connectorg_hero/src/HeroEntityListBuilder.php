<?php

namespace Drupal\connectorg_hero;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Hero entity entities.
 *
 * @ingroup connectorg_hero
 */
class HeroEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('Title');
    $header['published'] = $this->t('Published');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\connectorg_hero\Entity\HeroEntity $entity */
    $row['id'] = $entity->id();
    $row['title'] = Link::createFromRoute(
      $entity->label(),
      'entity.hero_entity.edit_form',
      ['hero_entity' => $entity->id()]
    );
    $row['published'] = $entity->status->value
     ? t('Published') : t('Unpublished');
    return $row + parent::buildRow($entity);
  }

}
