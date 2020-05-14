<?php

namespace Drupal\connectorg_microsites;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Microsite entity.
 *
 * @see \Drupal\connectorg_microsites\Entity\MicrositeEntity.
 */
class MicrositeEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\connectorg_microsites\Entity\MicrositeEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished microsite entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published microsite entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit microsite entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete microsite entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add microsite entities');
  }


}
