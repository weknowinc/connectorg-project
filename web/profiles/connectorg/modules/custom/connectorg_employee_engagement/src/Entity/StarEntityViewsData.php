<?php

namespace Drupal\connectorg_employee_engagement\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Star entities.
 */
class StarEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
