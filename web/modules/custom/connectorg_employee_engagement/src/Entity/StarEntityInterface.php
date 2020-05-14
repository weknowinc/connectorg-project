<?php

namespace Drupal\connectorg_employee_engagement\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Star entities.
 *
 * @ingroup connectorg_employee_engagement
 */
interface StarEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Title name.
   *
   * @return string
   *   Title of the Star.
   */
  public function getTitle();

  /**
   * Sets the Star name.
   *
   * @param $title
   * @return StarEntityInterface
   *   The called Star entity.
   */
  public function setTitle($title);

  /**
   * Gets the Star creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Star.
   */
  public function getCreatedTime();

  /**
   * Sets the Star creation timestamp.
   *
   * @param int $timestamp
   *   The Star creation timestamp.
   *
   * @return StarEntityInterface
   *   The called Star entity.
   */
  public function setCreatedTime($timestamp);

}
