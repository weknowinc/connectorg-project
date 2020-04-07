<?php

namespace Drupal\owp_employee_engagement\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase
{
  public function content()
  {
    $employees[] = [
      "id" => 1,
      "name" => "andres"
    ];
    $categories = [];
    $build = [
      '#theme' => 'owp_employee_engagement_theme',
      '#list_employees' => $employees,
      '#categories' => $categories
    ];
    return $build;
  }

}
