<?php

namespace Drupal\connectorg_employee_engagement\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;
use PDO;

/**
 * Provides a 'EmployeeStars' block.
 *
 * @Block(
 *  id = "employee_stars",
 *  admin_label = @Translation("Employee stars"),
 * )
 */
class EmployeeStars extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $build = [];
    $build['#theme'] = 'list_stars';
    $build['#listStars'] = [];

    return $build;
  }
}
