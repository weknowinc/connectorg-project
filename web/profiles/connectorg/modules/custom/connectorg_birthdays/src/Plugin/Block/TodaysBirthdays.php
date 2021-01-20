<?php

namespace Drupal\connectorg_birthdays\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a "Today's Birthdays" block.
 *
 * @Block(
 *  id = "todays_birthdays",
 *  admin_label = @Translation("Today's birthdays"),
 * )
 */
class TodaysBirthdays extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'birthday_block_header' => 'Today we celebrate the birthday of',
    ];
  }

  /**
   * @return array
   */
  public function getList(DrupalDateTime $date = NULL) {
    if (empty($date)) {
      $date = new DrupalDateTime();
    }
    $date = $date->format("m-d");
    $query = Drupal::database()->select('users', 'u')->fields('u');
    // @todo refactor to use entity query, this assumes that field exists.
    $query->innerJoin('user__field_birthday', 'field_birthday', 'field_birthday.entity_id = u.uid');
    $expression = "DATE_FORMAT(field_birthday.field_birthday_value,'%m-%d')";
    $query->where($expression . '=:birthday', [':birthday' => $date]);
    $users = $query->execute()->fetchCol();
    // @todo inject dependency.
    $items = [];
    foreach ($users as $uid) {
      $user = User::load($uid);
      $user_picture_uri = $user->hasField('user_picture') ? $user->get('user_picture')->entity->getFileUri() : 'none.jpg';
      $job_title = $user->hasField('field_job_title') ? $user->get('field_job_title')->entity->label() : '';
      $name = $user->hasField('field_name') ? $user->get('field_name')->value : '';
      $last_name = $user->hasField('field_last_name') ? $user->get('field_last_name')->value : '';
      $items[] = [
        'user' => $user,
        'picture' => file_create_url($user_picture_uri),
        'url' => $user->toUrl(),
        'name' => ucwords($name . ' ' . $last_name),
        'job_title' => $job_title,
      ];
    }
    return $items;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $form['birthday_block_header'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Header'),
      '#description' => $this->t('Birthday block header message.'),
      '#default_value' => isset($this->configuration['birthday_block_header']) ? $this->configuration['birthday_block_header'] : '',
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
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['birthdays'] = [
      '#theme' => 'todays_birthdays',
      '#list' => $this->getList(),
      '#header' => $this->t($this->configuration['birthday_block_header']),
    ];
    return $build;
  }

}
