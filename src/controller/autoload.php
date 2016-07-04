<?php
/**
 * @fil.
 * autoload
 */

/**
 * Autoload of classes.
 *
 * @param $class
 * @throws \Exception
 */
function __autoload($class) {
  $namespace = explode('\\', $class);
  if (isset($namespace[1]) && !empty($namespace[1]) && isset($namespace[2]) && !empty($namespace[2]))
  {
    require_once ('../src/' . $namespace[1] . '/' . $namespace[2] . '.php');
  }
  else {
    throw new Exception('Error during autoload of class ' . $class);
  }

}