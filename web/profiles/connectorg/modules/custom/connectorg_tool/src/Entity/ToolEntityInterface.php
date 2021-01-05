<?php

namespace Drupal\connectorg_tool\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Tool entities.
 *
 * @ingroup connectorg_tool
 */
interface ToolEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Tool name.
   *
   * @return string
   *   Name of the Tool.
   */
  public function getName();

  /**
   * Sets the Tool name.
   *
   * @param string $name
   *   The Tool name.
   *
   * @return \Drupal\connectorg_tool\Entity\ToolEntityInterface
   *   The called Tool entity.
   */
  public function setName($name);

  /**
   * Gets the Tool creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Tool.
   */
  public function getCreatedTime();

  /**
   * Sets the Tool creation timestamp.
   *
   * @param int $timestamp
   *   The Tool creation timestamp.
   *
   * @return \Drupal\connectorg_tool\Entity\ToolEntityInterface
   *   The called Tool entity.
   */
  public function setCreatedTime($timestamp);

}
