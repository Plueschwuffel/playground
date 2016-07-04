<?php
/**
 * @file
 * database
 */

namespace Playground\database;

use Playground\settings\Settings;

class Database {

  // Database connection handler.
  private $dbh;

  /**
   * Database constructor.
   * @param $dbInstance
   */
  public function __construct() {
    
  }

  /**
   * Connect to the database.
   */
  public function connect() {

    // Get the settings.
    $settings = new Settings();

    $this->dbh = mysqli_connect(
      $settings->database_credentials['host'],
      $settings->database_credentials['db_user'],
      $settings->database_credentials['db_pass'],
      $settings->database_credentials['db_name']
    );

    // Check connection
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  }

  /**
   * Disconnect from database.
   */
  public function disconnect() {
    mysqli_close($this->dbh);
  }


  /**
   * Check if a database connection already exists.
   * @return bool
   */
  private function dbConnectionExists() {
    if (!empty($this->dbh)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Execute a query.
   * @param $query
   */
  public function execute($query) {
    if (!$this->dbConnectionExists) {
      $this->connect();
    }
    return mysqli_query($this->dbh, $query);
  }

  /**
   * Escape a string for database usage.
   * @param $string
   */
  public function escapeString($string) {
    return $this->dbh->mysqli_real_escape_string($string);
  }


  public function __shutdown() {
    if ($this->dbConnectionExists()) {
      $this->disconnect();
    }
  }

}