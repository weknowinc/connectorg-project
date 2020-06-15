<?php

namespace Drupal\connectorg_hero;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Hero entity entity.
 *
 * @see \Drupal\connectorg_hero\Entity\HeroEntity.
 */
class HeroEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\connectorg_hero\Entity\HeroEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished hero entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published hero entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit hero entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete hero entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add hero entity entities');
  }


}
