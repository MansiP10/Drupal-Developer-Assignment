<?php

namespace Drupal\site_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheTagsInvalidator;
use Drupal\Core\Entity\EntityTypeManager;
/**
 * Class SiteLocationFormSetting.
 */
class SiteLocationFormSetting extends ConfigFormBase {

  protected $cacheTagsInvalidator;
  protected $entityTypeManager;
  protected $state;

  /**
   * Class constructor.
   */
  public function __construct(CacheTagsInvalidator $cacheTagsInvalidator,EntityTypeManager $entityTypeManager,StateInterface $state) {

    $this->cacheTagsInvalidator = $cacheTagsInvalidator;
  	$this->entityTypeManager = $entityTypeManager;
    $this->state = $state;
  }

  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('cache_tags.invalidator'),
      $container->get('entity_type.manager'),
      $container->get('state'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'site_location.sitelocationformsetting',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_location_form_setting';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
     // Getting different timezones from vocab timezone.
     $vid = 'timezone';
     $timezone_terms =$this->entityTypeManager->getStorage('taxonomy_term')->loadTree($vid);
     foreach ($timezone_terms as $term) {
       $timezones[$term->name] = $term->name;
     } 

    // Country textfield.
    $form['country'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Country'), 
      '#required' => TRUE, 
      '#default_value' => $this->state->get('country'),  
    ];  

    // City textfield.
    $form['city'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('City'), 
      '#required' => TRUE, 
      '#default_value' => $this->state->get('city'),  
    ];  

    // Timezone field.
    $form['timezone'] = [  
    '#type' => 'select',  
    '#title' => $this->t('Timezone'), 
    '#options' => $timezones,
    '#required' => TRUE, 
    '#default_value' => $this->state->get('timezone'),  
    ];
   
   return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $country = $form_state->getValue('country');
  	$city = $form_state->getValue('city');
  	$timezone = $form_state->getValue('timezone');

  	$this->state->set('country', $country);
  	$this->state->set('city', $city);
  	$this->state->set('timezone', $timezone);

     // Invalidated 'site_location_timezone_tag' cache tag. 
     $this->cacheTagsInvalidator->invalidateTags(['site_location_timezone_tag']);  

  }

}
