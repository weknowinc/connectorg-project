<?php

namespace Drupal\connectorg_hero\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Hero entity entities.
 *
 * @ingroup connectorg_hero
 */
interface HeroEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Hero entity name.
   *
   * @return string
   *   Name of the Hero entity.
   */
  public function getTitle();

  /**
   * Sets the Hero entity name.
   *
   * @param string $name
   *   The Hero entity name.
   *
   * @return \Drupal\connectorg_hero\Entity\HeroEntityInterface
   *   The called Hero entity entity.
   */
  public function setTitle($title);

  /**
   * Gets the Hero entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Hero entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Hero entity creation timestamp.
   *
   * @param int $timestamp
   *   The Hero entity creation timestamp.
   *
   * @return \Drupal\connectorg_hero\Entity\HeroEntityInterface
   *   The called Hero entity entity.
   */
  public function setCreatedTime($timestamp);

}
