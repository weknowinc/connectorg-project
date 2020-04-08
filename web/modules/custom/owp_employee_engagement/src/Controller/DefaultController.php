<?php

namespace Drupal\owp_employee_engagement\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Messenger\Messenger;
use Drupal\owp_employee_engagement\Entity\StarEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Zend\Diactoros\Response\JsonResponse;

class DefaultController extends ControllerBase
{
  /**
   * @var Messenger
   */
  protected $messenger;

  /**
   * DefaultController constructor.
   * @param $messageInterface
   */
  public function __construct(Messenger $messageInterface)
  {
    $this->messenger = $messageInterface;
  }

  /**
   * Create dependency injection.
   * @param ContainerInterface $container
   * @return DefaultController
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('messenger')
    );

  }

  /**
   * @return array
   */
  public function content()
  {
    return [
      '#theme' => 'list_stars'
    ];
  }

  /**
   * @param Request $request
   * @return void
   */
  public function save(Request $request)
  {
    $_REQUEST['destination'] = "stars";
    $idUser = $request->request->get("id_user", '');
    $typeStar = $request->request->get("type_star", '');
    $description = trim($request->request->get("description", ''));
    $title = trim($request->request->get("title", ''));
    //TODO: Improve this validation
    if (empty($title) || empty($idUser) || empty($typeStar) || empty($description)) {
      $this->messenger->addError('Missing Parameters');
      return;
    }
    $message = "New star created";
    try {
      $star = StarEntity::create([
        "title" => $title,
        "field_employee" => $idUser,
        "field_message" => $description,
        "field_type" => $typeStar
      ]);
      $star->save();
    } catch (EntityStorageException $e) {
      $message = "Troubles on the creation of the star";
    }
    $this->messenger->addError($message);
    return;
  }

}
