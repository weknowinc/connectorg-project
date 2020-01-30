<?php

namespace Drupal\owp_news\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining News entities.
 *
 * @ingroup owp_news
 */
interface NewsEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the News title.
   *
   * @return string
   *   Title of the News.
   */
  public function getTitle();

  /**
   * Sets the News title.
   *
   * @param string $title
   *   The News title.
   *
   * @return \Drupal\owp_news\Entity\NewsEntityInterface
   *   The called News entity.
   */
  public function setTitle($title);

  /**
   * Gets the News creation timestamp.
   *
   * @return int
   *   Creation timestamp of the News.
   */
  public function getCreatedTime();

  /**
   * Sets the News creation timestamp.
   *
   * @param int $timestamp
   *   The News creation timestamp.
   *
   * @return \Drupal\owp_news\Entity\NewsEntityInterface
   *   The called News entity.
   */
  public function setCreatedTime($timestamp);

}
