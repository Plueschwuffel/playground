<?php
/**
 * @file
 * Settings.
 */

namespace Playground\settings;


/**
 * Class Settings
 * @package Playground\settings
 */
class Settings {

  public $protocol = 'http://';
  public $domain = 'playground.dev';

  public $database_credentials = array(
    'host' => 'localhost',
    'db_name' => 'playground',
    'db_user' => 'playground',
    'db_pass' => 'playground',
  );

}