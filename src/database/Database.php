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
   */
  public function __construct() {
    
  }


  /**
   * Database destructor.
   */
  public function __destruct() {
    $this->disconnect();
  }

  /**
   * Connect to the database.
   */
  public function connect() {
    if (!$this->dbConnectionExists()) {
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
   *
   * @param $query
   * @return bool|\mysqli_result
   */
  public function execute($query) {
    if (!$this->dbConnectionExists()) {
      $this->connect();
    }
    return mysqli_query($this->dbh, $query);
  }

  /**
   * Get the last insert id.
   * @return mixed
   */
  public function lastInsertId() {
    return $this->dbh->insert_id;
  }

  /**
   * Escape a string for database usage.
   * @param $string
   * @return string
   */
  public function escapeString($string) {
    if (!$this->dbConnectionExists()) {
      $this->connect();
    }
    return mysqli_real_escape_string($this->dbh, $string);
  }

}