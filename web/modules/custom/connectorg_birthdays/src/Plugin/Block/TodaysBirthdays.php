<?php

namespace Drupal\connectorg_birthdays\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormStateInterface;

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
    $config = $this->getConfiguration();
    $currentTime = new DrupalDateTime();
    $currentTime = $currentTime->format("m-d");
    $query = Drupal::database()->select('users', 'u')->fields('u');
    $query->innerJoin('user__field_birthday', 'field_birthday', 'field_birthday.entity_id = u.uid');
    $query->innerJoin('user__user_picture', 'field_avatar', 'field_avatar.entity_id = u.uid');
    $expression = "DATE_FORMAT(field_birthday.field_birthday_value,'%m-%d')";
    $args = [
      ':birthday' => $currentTime
    ];
    $query->where($expression . '=:birthday', $args);
    $ids = $query->execute()->fetchCol();
    $users = User::loadMultiple($ids);
    $listUsers = [];
    foreach ($users as $rowUser) {
      $fileUri =  ($rowUser->hasField('user_picture')) ? $rowUser->get('user_picture')->entity->getFileUri() : 'none.jpg';
      $id = $rowUser->id();
      $name = $rowUser->get('field_name')->value;
      $jobTitle = $rowUser->get('field_job_title')->entity->getName();
      $lastName = $rowUser->get('field_last_name')->value;
      $fullName = sprintf("%s %s", $name, $lastName);
      $listUsers[] = [
        'url' => $fileUri,
        'id' => $id,
        'name' => ucfirst($fullName),
        'jobTitle' => ucfirst($jobTitle),
        'header' => $config['birthday_block_header'] ?: $this->t('Today is we celebrate the birthday of'),
        'footer' => $config['birthday_block_footer'] ?: $this->t('Send a regard through Slack.'),
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
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['birthday_block_header'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Header'),
      '#description' => $this->t('Birthday block header message.'),
      '#default_value' => isset($config['birthday_block_header']) ? $config['birthday_block_header'] : '',
    ];

    $form['birthday_block_footer'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Footer'),
      '#description' => $this->t('Birthday block footer message.'),
      '#default_value' => isset($config['birthday_block_footer']) ? $config['birthday_block_footer'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['birthday_block_header'] = $values['birthday_block_header'];
    $this->configuration['birthday_block_footer'] = $values['birthday_block_footer'];
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
