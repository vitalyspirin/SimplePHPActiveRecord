<?php

require_once 'ValidationRulesBuilder.php';


class SimpleActiveRecord extends ActiveRecord\Model
{
    protected static $ruleList = [];
    
    protected $validationRulesBuilder;
    protected static $dsn;
    
        
    public static $table_name;
    public static $validates_presence_of = [];
    public static $validates_size_of = [];
    public static $validates_numericality_of = [];
    public static $validates_uniqueness_of = [];
    public static $validates_inclusion_of = [];
    public static $validates_format_of = [];

    
    public function __construct($attributes = array(), 
        $guard_attributes = true, 
        $instantiating_via_find = false, 
        $new_record = true)
    {
        
        $className = (new \ReflectionClass($this))->getShortName();
        self::$table_name = strtolower($className);

        if (self::$connection == null)
        {
            $cfg = ActiveRecord\Config::instance();
            self::$dsn = $cfg->get_default_connection_string();
        }
        $pdo = $this->connection()->connection;


        $this->validationRulesBuilder = 
            new ValidationRulesBuilder(self::$table_name, self::$dsn, $pdo);

        if ( !isset(self::$ruleList[self::$table_name]) )
        {
            $this->buildRules();
            $this->populateRules();
        } else
        {
            ; // for code coverage analysis
        }


        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    }


    protected function buildRules()
    {
        $ruleList = [];
        
        $ruleList['validates_presence_of'] = [];
        $this->validationRulesBuilder->buildRequiredRules($ruleList['validates_presence_of']);
        
        $ruleList['validates_size_of'] = [];
        $this->validationRulesBuilder->buildStringRules($ruleList['validates_size_of']);
        
        $ruleList['validates_numericality_of'] = [];
        $this->validationRulesBuilder->buildIntegerWithRangeRules($ruleList['validates_numericality_of']);
        $this->validationRulesBuilder->buildNumberWithRangeRules($ruleList['validates_numericality_of']);
        
        $ruleList['validates_uniqueness_of'] = [];
        $this->validationRulesBuilder->buildUniqueRules($ruleList['validates_uniqueness_of']);

        $ruleList['validates_inclusion_of'] = [];
        $this->validationRulesBuilder->buildRangeRules($ruleList['validates_inclusion_of']);

        $ruleList['validates_format_of'] = [];
        $this->validationRulesBuilder->buildTimeRules($ruleList['validates_format_of']);
        

        self::$ruleList[self::$table_name] = $ruleList;
    }
    
    
    protected function populateRules()
    {
        self::$validates_presence_of = self::$ruleList[self::$table_name]
            ['validates_presence_of'];

        self::$validates_size_of = self::$ruleList[self::$table_name]
            ['validates_size_of'];

        self::$validates_numericality_of = self::$ruleList[self::$table_name]
            ['validates_numericality_of'];
            
        self::$validates_uniqueness_of = self::$ruleList[self::$table_name]
            ['validates_uniqueness_of'];
            
        self::$validates_inclusion_of = self::$ruleList[self::$table_name]
            ['validates_inclusion_of'];

        self::$validates_format_of = self::$ruleList[self::$table_name]
            ['validates_format_of'];
    }
    
   
}
