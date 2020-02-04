<?php

namespace Drupal\owp_events\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Event entities.
 */
class EventEntityViewsData extends EntityViewsData {

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
