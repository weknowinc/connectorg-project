<?php

namespace Drupal\connectorg_birthdays;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\connectorg_birthdays\Entity\BirthdayEntityInterface;

/**
 * Access controller for the Birthday entity.
 *
 * @see \Drupal\connectorg_birthdays\Entity\BirthdayEntity.
 */
class BirthdayEntityAccessControlHandler extends EntityAccessControlHandler
{

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
  {
    /** @var BirthdayEntityInterface $entity */

    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished birthday entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published birthday entities');
      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit birthday entities');
      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete birthday entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL)
  {
    return AccessResult::allowedIfHasPermission($account, 'add birthday entities');
  }
}
