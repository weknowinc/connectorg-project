<?php

namespace Drupal\connectorg_microsites\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Microsite entities.
 *
 * @ingroup connectorg_microsites
 */
interface MicrositeEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Microsite name.
   *
   * @return string
   *   Name of the Microsite.
   */
  public function getName();

  /**
   * Sets the Microsite name.
   *
   * @param string $name
   *   The Microsite name.
   *
   * @return \Drupal\connectorg_microsites\Entity\MicrositeEntityInterface
   *   The called Microsite entity.
   */
  public function setName($name);

  /**
   * Gets the Microsite creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Microsite.
   */
  public function getCreatedTime();

  /**
   * Sets the Microsite creation timestamp.
   *
   * @param int $timestamp
   *   The Microsite creation timestamp.
   *
   * @return \Drupal\connectorg_microsites\Entity\MicrositeEntityInterface
   *   The called Microsite entity.
   */
  public function setCreatedTime($timestamp);

}
