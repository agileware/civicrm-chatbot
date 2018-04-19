<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /buildkit/build/chatbot/sites/all/modules/civicrm/tools/extensions/civicrm-chatbot/xml/schema/CRM/Chat/ChatAction.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:5aa8d39b3dc031eb8816cdf78bb87e67)
 */

/**
 * Database access object for the ChatAction entity.
 */
class CRM_Chat_DAO_ChatAction extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_chat_action';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique ChatAction ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * FK to ChatQuestion
   *
   * @var int unsigned
   */
  public $question_id;

  /**
   * @var string
   */
  public $type;

  /**
   * Serialized representation of check object
   *
   * @var text
   */
  public $check_object;

  /**
   * @var text
   */
  public $action_data;

  /**
   * Weight (useful for questions)
   *
   * @var int unsigned
   */
  public $weight;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_chat_action';
    parent::__construct();
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'question_id', 'civicrm_chat_question', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Unique ChatAction ID',
          'required' => TRUE,
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
        ],
        'question_id' => [
          'name' => 'question_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to ChatQuestion',
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
          'FKClassName' => 'CRM_Chat_DAO_ChatQuestion',
        ],
        'type' => [
          'name' => 'type',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Type'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
        ],
        'check_object' => [
          'name' => 'check_object',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Check Object'),
          'description' => 'Serialized representation of check object',
          'required' => TRUE,
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
        ],
        'action_data' => [
          'name' => 'action_data',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Action Data'),
          'required' => TRUE,
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
        ],
        'weight' => [
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Weight'),
          'description' => 'Weight (useful for questions)',
          'required' => FALSE,
          'table_name' => 'civicrm_chat_action',
          'entity' => 'ChatAction',
          'bao' => 'CRM_Chat_DAO_ChatAction',
          'localizable' => 0,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'chat_action', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'chat_action', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'index_type' => [
        'name' => 'index_type',
        'field' => [
          0 => 'type',
        ],
        'localizable' => FALSE,
        'sig' => 'civicrm_chat_action::0::type',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}