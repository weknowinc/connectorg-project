<?php

namespace Drupal\owp_office\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Office entities.
 *
 * @ingroup owp_office
 */
interface OfficeEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Office name.
   *
   * @return string
   *   Name of the Office.
   */
  public function getName();

  /**
   * Sets the Office name.
   *
   * @param string $name
   *   The Office name.
   *
   * @return \Drupal\owp_office\Entity\OfficeEntityInterface
   *   The called Office entity.
   */
  public function setName($name);

  /**
   * Gets the Office creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Office.
   */
  public function getCreatedTime();

  /**
   * Sets the Office creation timestamp.
   *
   * @param int $timestamp
   *   The Office creation timestamp.
   *
   * @return \Drupal\owp_office\Entity\OfficeEntityInterface
   *   The called Office entity.
   */
  public function setCreatedTime($timestamp);

}
