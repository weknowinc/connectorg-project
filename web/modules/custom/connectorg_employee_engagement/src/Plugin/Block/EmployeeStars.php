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
   * @return array
   */
  public function getAll()
  {
    $listStars = [];
    $listStars = Drupal::database()->query(
      "
    select
        se.id  as id_star,
       usr.uid  as id_user,
       concat(ufn.field_name_value, ' ', ufln.field_last_name_value) as name_user,
       ttfd.name as type_star,
       substring(sefm.field_message_value, 1, 6000) as message_star
from star_entity se
         inner join star_entity__field_employee sefe on se.id = sefe.entity_id
         inner join users usr on usr.uid = sefe.field_employee_target_id
         inner join user__field_name ufn on ufn.entity_id = usr.uid
         inner join user__field_last_name ufln on ufln.entity_id = usr.uid
         inner join star_entity__field_type seft on se.id = seft.entity_id
         inner join taxonomy_term_field_data ttfd on ttfd.tid = seft.field_type_target_id
         left join star_entity__field_message sefm on se.id = sefm.entity_id
         left join star_entity__field_image sefi on se.id = sefi.entity_id
order by se.created desc"
    )->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listStars as &$star) {
      $rowUser = User::load($star["id_user"]);
      $star['user_avatar'] = $rowUser->get('field_avatar')->entity->getFileUri();
      $star['user_job_title'] = $rowUser->get('field_job_title')->entity->getName();
    }

    return $listStars;
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $listStars = $this->getAll();
    $build = [];
    $build['#theme'] = 'list_stars';
    $build['#listStars'] = $listStars;

    return $build;
  }
}
