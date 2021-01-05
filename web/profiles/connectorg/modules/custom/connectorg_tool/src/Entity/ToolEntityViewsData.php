<?php

namespace Drupal\connectorg_tool\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Tool entities.
 */
class ToolEntityViewsData extends EntityViewsData {

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
