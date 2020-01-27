<?php

namespace Drupal\owp_news\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for News entities.
 */
class OwpNewsViewsData extends EntityViewsData {

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
