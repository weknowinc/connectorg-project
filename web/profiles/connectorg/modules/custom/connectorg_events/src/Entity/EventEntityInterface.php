<?php

namespace Drupal\connectorg_events\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Event entities.
 *
 * @ingroup connectorg_events
 */
interface EventEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Event name.
   *
   * @return string
   *   Title of the event.
   */
  public function getTitle();

  /**
   * Sets the Event name.
   *
   * @param string $title
   *   The Title name.
   *
   * @return \Drupal\connectorg_events\Entity\EventEntityInterface
   *   The called Event entity.
   */
  public function setTitle($title);

  /**
   * Gets the Event creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Event.
   */
  public function getCreatedTime();

  /**
   * Sets the Event creation timestamp.
   *
   * @param int $timestamp
   *   The Event creation timestamp.
   *
   * @return \Drupal\connectorg_events\Entity\EventEntityInterface
   *   The called Event entity.
   */
  public function setCreatedTime($timestamp);

}
