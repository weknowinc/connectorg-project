<?php

namespace Drupal\connectorg_employee_engagement\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal;
use Drupal\user\Entity\User;
use PDO;

/**
 * Provides a 'AddStar' block.
 *
 * @Block(
 *  id = "add_star",
 *  admin_label = @Translation("Add Star"),
 * )
 */
class AddStar extends BlockBase implements BlockPluginInterface
{
  /**
   * @return array
   */
  public function getAllUsers()
  {
    $query = Drupal::database()->select('users', 'u')->fields('u');
    $ids = $query->execute()->fetchCol();
    $users = User::loadMultiple($ids);
    $listUsers = [];

    foreach ($users as $rowUser) {
      $id = $rowUser->id();
      $name = $rowUser->get('field_name')->value;
      $lastName = $rowUser->get('field_last_name')->value;
      $fullName = sprintf("%s %s", $name, $lastName);
      $listUsers[] = [
        'id' => $id,
        'name' => ucfirst($fullName)
      ];
    }

    return $listUsers;
  }

  /**
   * @return array
   */
  public function getAllTypes()
  {
    $query = Drupal::database()->select('taxonomy_term_field_data ', 'ttfd')->fields('ttfd');
    $query->where("ttfd.vid = 'rewards'");
    return $query->execute()->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $users = $this->getAllUsers();
    $types = $this->getAllTypes();

    return [
      '#theme' => 'add_star',
      '#listUsers' => $users,
      '#listTypes' => $types,
    ];
  }
}
