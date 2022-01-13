# Drupal-Developer-Assignment
---------------------------

Installation of Module:
-------------
  1. Download site_location folder and run drush en site_location to install modlue.

Requirements:
------------
  1.For timezone select list value create texonomy with name 'timezone' and add following terms:
      America/Chicago
      America/New_York
      Asia/Tokyo
      Asia/Dubai
      Asia/Kolkata
      Europe/Amsterdam
      Europe/Oslo
      Europe/London

Configuration:
-------------
  1. Admin config form url: admin/config/site_location/sitelocationformsetting
  3. Fill value for Country, City and Timezone field and submit the form.
  4. Go to the Block Layout. i.e: Admin Menu >> structure >> block layout place block named 'Display site location time block'
  5. Click on the Save block button.

Uninstallation of Module:
--------------
  1. Normally Uninstall any Drupal module.
