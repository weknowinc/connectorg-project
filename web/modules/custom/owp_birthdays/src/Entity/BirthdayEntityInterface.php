<?php

namespace Drupal\owp_birthdays\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Birthday entities.
 *
 * @ingroup owp_birthdays
 */
interface BirthdayEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Birthday name.
   *
   * @return string
   *   Name of the Birthday.
   */
  public function getName();

  /**
   * Sets the Birthday name.
   *
   * @param string $name
   *   The Birthday name.
   *
   * @return \Drupal\owp_birthdays\Entity\BirthdayEntityInterface
   *   The called Birthday entity.
   */
  public function setName($name);

  /**
   * Gets the Birthday creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Birthday.
   */
  public function getCreatedTime();

  /**
   * Sets the Birthday creation timestamp.
   *
   * @param int $timestamp
   *   The Birthday creation timestamp.
   *
   * @return \Drupal\owp_birthdays\Entity\BirthdayEntityInterface
   *   The called Birthday entity.
   */
  public function setCreatedTime($timestamp);

}
