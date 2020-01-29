<?php

namespace Drupal\owp_tool;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Tool entity.
 *
 * @see \Drupal\owp_tool\Entity\ToolEntity.
 */
class ToolEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\owp_tool\Entity\ToolEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished tool entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published tool entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit tool entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete tool entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add tool entities');
  }


}
