<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\site_location\SiteLocationService;

/**
 * Provides a 'DisplaySiteLocationTimeBlock' block.
 *
 * @Block(
 *  id = "display_site_location_time_block",
 *  admin_label = @Translation("Display site location time block"),
 * )
 */
class DisplaySiteLocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $current_datetime;
  protected $state;

   /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\assignment\SiteLocationService $current_datetime;
   * @param Drupal\Core\State\StateInterface $state;
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, SiteLocationService $current_datetime, StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->current_datetime = $current_datetime;
    $this->state = $state;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('get_site_location'),
      $container->get('state')
    );
  }
  

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'site_location',
      '#country' => $this->state->get('country'),
      '#city' => $this->state->get('city'),
      '#time' => !empty($this->state->get('country')) && $this->state->get('city')? $this->current_datetime->getCurrentTimeByTimeZone():'',
      '#cache' => [
        'tags' => ['site_location_timezone_tag'],
      ],
    ];
  }

}
