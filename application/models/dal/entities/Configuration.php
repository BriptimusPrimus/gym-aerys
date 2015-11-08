<?php
/**
 * class Configuration
 *
 */
class Configuration{


   /*** Attributes: ***/

  /**
   *
   * @access public
   */
  public $typedb = 'mysql';

  /**
   *
   * @access public
   */
  public $db_file = '';

  /**
   *
   * @access public
   */
  public $server = 'localhost';

  /**
   *
   * @access public
   */
  //public $user = 'gymadmin';
  public $user = 'root';

  /**
   *
   * @access public
   */
  //public $password = 'm0rgulis';
  public $password = '';

  /**
   *
   * @access public
   */
  public $database = 'gymdb';

  /**
   *
   * @access public
   */
  public $port = 3306;

  /**
   *
   * @access public
   */
  public $tablePrefix = '';

} // end of Configuration