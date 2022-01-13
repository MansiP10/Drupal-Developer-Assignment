<?php

namespace Drupal\site_location;

use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\State\StateInterface;

/**
 * Class SiteLocationService.
 */
class SiteLocationService {

  /**
   * Constructs a new SiteLocationService object.
   */
  protected $dateFormatter;
  protected $state;

  public function __construct(DateFormatter $dateFormatter, StateInterface $state) {
    $this->dateFormatter = $dateFormatter;
    $this->state = $state;
  }

  public function  getCurrentTimeByTimeZone(){

    // Get country, city and timezone values which is set in site location config form.
    $country = $this->state->get('country');
    $city = $this->state->get('city');
    $timezone = $this->state->get('timezone');  
    if($country && $city && $timezone){
      // Use dateFormatter service to get time by timezone.
      $current_datetime = $this->dateFormatter->format(time(), 'custom', 'jS M Y - h:i A', $timezone);
    }
    return $current_datetime;
 }
}
