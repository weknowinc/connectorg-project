<?php

namespace Drupal\owp_employee_engagement;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Star entity.
 *
 * @see \Drupal\owp_employee_engagement\Entity\StarEntity.
 */
class StarEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\owp_employee_engagement\Entity\StarEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished star entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published star entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit star entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete star entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add star entities');
  }


}
