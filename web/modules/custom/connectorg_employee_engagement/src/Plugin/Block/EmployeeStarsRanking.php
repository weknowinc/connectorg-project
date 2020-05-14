<?php

namespace Drupal\connectorg_employee_engagement\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;
use PDO;

/**
 * Provides a 'EmployeeStarsRanking' block.
 *
 * @Block(
 *  id = "employee_stars_ranking",
 *  admin_label = @Translation("Ranking"),
 * )
 */
class EmployeeStarsRanking extends BlockBase
{
  /**
   * Return the most ranked employees based on the input limit
   * @param int $limit
   * @return array
   */
  public function getMostRankedEmployees(int $limit)
  {
    $listStars = [];
    $listStars = Drupal::database()->query(
      "select
                sefe.field_employee_target_id as id_user,
                count(sefe.entity_id) as total
            from star_entity se
               inner join star_entity__field_employee sefe on se.id = sefe.entity_id
               inner join users usr on usr.uid = sefe.field_employee_target_id
               inner join user__field_name ufn on ufn.entity_id = usr.uid
               inner join user__field_last_name ufln on ufln.entity_id = usr.uid
               inner join star_entity__field_type seft on se.id = seft.entity_id
               left join star_entity__field_message sefm on se.id = sefm.entity_id
               left join star_entity__field_image sefi on se.id = sefi.entity_id
            group by sefe.field_employee_target_id
            order by total desc
            limit {$limit}"
    )->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listStars as &$star) {
      $rowUser = User::load($star["id_user"]);
      $star['avatar'] = $rowUser->get('field_avatar')->entity->getFileUri();
      $name = $rowUser->get('field_name')->value;
      $lastName = $rowUser->get('field_last_name')->value;
      $fullName = sprintf("%s %s", $name, $lastName);
      $star['name_user'] = ucfirst($fullName);
      $star['job_title'] = $rowUser->get('field_job_title')->entity->getName();
    }

    return $listStars;
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $listUsers = $this->getMostRankedEmployees(5);
    $build = [];
    $build['#theme'] = 'ranking';
    $build['#listUsers'] = $listUsers;

    return $build;
  }
}
