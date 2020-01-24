<?php

namespace Drupal\owp_office;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Office entity.
 *
 * @see \Drupal\owp_office\Entity\OfficeEntity.
 */
class OfficeEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\owp_office\Entity\OfficeEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished office entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published office entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit office entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete office entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add office entities');
  }


}
