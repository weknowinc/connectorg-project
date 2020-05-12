<?php

namespace Drupal\connectorg_employee_engagement\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Messenger\Messenger;
use Drupal\connectorg_employee_engagement\Entity\StarEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
   * @return RedirectResponse
   */
  public function save(Request $request)
  {
    $idUser = $request->request->get("id_user", '');
    $typeStar = $request->request->get("type_star", '');
    $description = trim($request->request->get("description", ''));
    $title = trim($request->request->get("title", ''));
    if (empty($title) || empty($idUser) || empty($typeStar) || empty($description)) {
      $this->messenger->addError('Missing Parameters');
    } else {
      try {
        $star = StarEntity::create([
          "title" => $title,
          "field_employee" => $idUser,
          "field_message" => $description,
          "field_type" => $typeStar
        ]);
        $star->save();
        $message = "New star created";
        $this->messenger->addStatus($message);
      } catch (EntityStorageException $e) {
        $message = "Troubles on the creation of the star";
        $this->messenger->addError($message);
      }
    }
    return new RedirectResponse('/stars');
  }

}
