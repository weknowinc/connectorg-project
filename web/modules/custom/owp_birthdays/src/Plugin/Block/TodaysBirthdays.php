<?php

namespace Drupal\owp_birthdays\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityInterface;
use Drupal\user\Entity\User;

/**
 * Provides a 'TodaysBirthdays' block.
 *
 * @Block(
 *  id = "todays_birthdays",
 *  admin_label = @Translation("Todays birthdays"),
 * )
 */
class TodaysBirthdays extends BlockBase
{

  /**
   * @return EntityInterface[]
   */
  public function getAll()
  {
    $currentTime = new DrupalDateTime();
    $currentTime = $currentTime->format("m-d");
    $query = Drupal::database()->select('users', 'u')->fields('u');
    $query->innerJoin('user__field_birthday', 'field_birthday', 'field_birthday.entity_id = u.uid');
    $query->innerJoin('user__field_avatar', 'field_avatar', 'field_avatar.entity_id = u.uid');
    $expression = "DATE_FORMAT(field_birthday.field_birthday_value,'%m-%d')";
    $args = [
      ':birthday' => $currentTime
    ];
    $query->where($expression . '=:birthday', $args);
    $ids = $query->execute()->fetchCol();
    $users = User::loadMultiple($ids);
    $listUsers = [];
    foreach ($users as $rowUser) {
      $fileUri = $rowUser->get('field_avatar')->entity->getFileUri();
      $id = $rowUser->id();
      $listUsers[] = [
        'url' => $fileUri,
        'id' => $id
      ];
    }
    return ($listUsers);
  }

  public function getCacheMaxAge()
  {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $todayBirthdays = $this->getAll();
    $build = [];
    $build['#theme'] = 'todays_birthdays';
    $build['#listBirthdays'] = $todayBirthdays;
    return $build;
  }

}
