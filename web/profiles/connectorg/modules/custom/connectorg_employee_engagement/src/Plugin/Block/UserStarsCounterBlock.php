<?php

namespace Drupal\connectorg_employee_engagement\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\image\Entity\ImageStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'User stars counter' Block.
 *
 * @Block(
 *   id = "user_stars_counter",
 *   admin_label = @Translation("User stars counter"),
 *   category = @Translation("User stars counter"),
 * )
 */
class UserStarsCounterBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new BlockContentBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Block\BlockManagerInterface $block_manager
   *   The Plugin Block Manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account for which view access should be checked.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The URL generator.
   * @param \Drupal\block_content\BlockContentUuidLookup $uuid_lookup
   *   The block content UUID lookup service.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match, AccountInterface $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_route_match'),
      $container->get('current_user'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#description' => $this->t('Some descriptive text to show above the stars counter.'),
      '#default_value' => isset($config['description']) ? $config['description'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['description'] = $values['description'];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = $this->routeMatch->getParameter('user');
    if (empty($user)) {
      $user = $this->account;
    }

    $counters = $this->getCounters($user);
    $items = [];
    foreach ($this->getStarTypes() as $star_type) {
      $icon = $this->getStarTypeIcon($star_type);
      // @todo implement template.
      $item = [
        '#type' => 'inline_template',
        '#template' => '<div class="star-counter" title="{{ star_type_name }}"><div class="circle-wrapper"><div class="circle" style="background-image: url({{ icon }})"></div><div class="counter-value">{{ counter }}</div></div></div>',
        '#context' => [
          'icon' => $icon,
          'counter' => isset($counters[$star_type->id()]) ? $counters[$star_type->id()] : 0,
          'star_type_name' => $star_type->label(),
        ],
      ];

      $items[$star_type->id()] = $item;
    }

    $render['list'] = [
      '#theme' => 'item_list',
      '#items' => $items,
    ];

    $config = $this->getConfiguration();
    if (!empty($config['description'])) {
      $render['description'] = [
        '#type' => 'inline_template',
        '#template' => '<div class="star-counter-description">{{ description }}</div>',
        '#context' => [
          'description' => $config['description'],
        ],
      ];
    }

    return $render;
  }

  // @todo move to StarService.
  protected function getStarTypes() {
    return $this->entityTypeManager->getStorage('taxonomy_term')
      ->loadByProperties([
        'vid' => 'star_types',
        'status' => '1',
      ]);
  }

  // @todo move to StarService.
  protected function getCounters($user) {
    /**
     *
     * select t2.field_type_target_id as type_id, count(1) as counter from star_entity__field_employee t1
     * left join star_entity__field_type t2 on t1.entity_id = t2.entity_id
     * where t1.field_employee_target_id = 2
     * group by t2.field_type_target_id
     */
    $query = \Drupal::database()->select('star_entity__field_employee', 't1');
    $query->addField('t2', 'field_type_target_id', 'star_type_id');
    $query->addExpression('count(1)', 'counter');
    $query->leftJoin('star_entity__field_type', 't2', 't1.entity_id = t2.entity_id');
    $query->condition('t1.field_employee_target_id', $user->id(), '=');
    $query->groupBy('t2.field_type_target_id');
    return $query->execute()->fetchAllKeyed();
  }

  protected function getStarTypeIcon($star_type) {
    $type_icon = NULL;
    if (!$star_type->get('field_image')->isEmpty()) {
      $type_icon = $star_type->get('field_image')->entity->getFileUri();
      $type_icon = ImageStyle::load('thumbnail')->buildUrl($type_icon);
    }
    return $type_icon;
  }

  public function getCacheContexts() {
    return ['url'];
  }

}
