<?php

namespace Drupal\owp_events\Controller;

use DateTime;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\File\FileSystem;

/**
 * An example controller.
 */
class IcsDownloadController extends ControllerBase
{
  /**
   * @var FileSystem
   */
  protected $fileSystem;
  /**
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  /**
   * @var RequestStack
   */
  protected $request;

  /**
   * Constructor.
   * @param EntityTypeManagerInterface $entityTypeManager
   * @param RequestStack $request
   * @param FileSystem $fileStorage
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, RequestStack $request, FileSystem $fileStorage)
  {
    $this->entityTypeManager = $entityTypeManager;
    $this->request = $request;
    $this->fileSystem = $fileStorage;

  }

  /**
   * Create dependency injection.
   * @param ContainerInterface $container
   * @return IcsDownloadController
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('request_stack'),
      $container->get('file_system')
    );

  }

  /**
   * Borrowed from Kent Shelley via 'File Download'.
   *
   * Project https://www.drupal.org/project/file_download.
   * @param $entityType
   * @param $id
   * @param $fieldName
   * @param $delta
   * @return bool|BinaryFileResponse|Response
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  public function download($entityType, $id, $fieldName, $delta)
  {
    $entity = $this->entityTypeManager->getStorage($entityType)->load($id);
    if (!array_key_exists($delta, $entity->get($fieldName)->getValue())) {
      return new Response(
        'Delta is not a correct index'
      );
    }
    $dtStart = $entity->get($fieldName)->getValue()[$delta]["value"];
    $dtEnd = $entity->get($fieldName)->getValue()[$delta]["end_value"];
    $duration = $entity->get($fieldName)->getValue()[$delta]["duration"];
    $urlEvent = $entity->get("field_url")->getValue()[$delta]["uri"];

    $host = $this->request->getCurrentRequest()->getHost();
    $calendarService = new Calendar($host);
    $eventService = new Event();

    $startDate = new DateTime();
    $endDate = new DateTime();
    $startDate->setTimestamp($dtStart);
    $endDate->setTimestamp($dtEnd);

    $allDay = ($duration == $entity::ALL_DAY_EVENT);
    $nameEvent = $entity->label();
    $eventService
      ->setDtStart($startDate)
      ->setDtEnd($endDate)
      ->setUrl($urlEvent)
      ->setNoTime($allDay)
      ->setSummary($nameEvent);

    // 4. Add Event to Calendar.
    $calendarService->addComponent($eventService);

    // 5. Send output.
    $fileName = sprintf(
      "event_%s.ics",
      $id
    );
    $uri = 'public://' . $fileName;
    $content = $calendarService->render();
    $file = file_save_data($content, $uri, FILE_EXISTS_REPLACE);
    if (empty($file)) {
      return new Response(
        'Simple ICS Error, Please contact the System Administrator'
      );
    }

    $mimeType = 'text/calendar';
    $scheme = 'public';
    $parts = explode('://', $uri);
    $fileDirectory = $this->fileSystem->realpath(
      $scheme . "://"
    );
    $filePath = $fileDirectory . '/' . $parts[1];
    $fileName = $file->getFilename();

    // File doesn't exist
    // This may occur if the download path is used outside of a formatter
    // and the file path is wrong or file is gone.
    if (!file_exists($filePath)) {
      throw new NotFoundHttpException();
    }

    $headers = [
      'Content-Type' => $mimeType,
      'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
      'Content-Length' => $file->getSize(),
      'Content-Transfer-Encoding' => 'binary',
      'Pragma' => 'no-cache',
      'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
      'Expires' => '0',
      'Accept-Ranges' => 'bytes',
    ];

    // \Drupal\Core\EventSubscriber\FinishResponseSubscriber::onRespond()
    // sets response as not cacheable if the Cache-Control header is not
    // already modified. We pass in FALSE for non-private schemes for the
    // $public parameter to make sure we don't change the headers.
    return new BinaryFileResponse($uri, 200, $headers, $scheme !== 'private');
  }

}
