<?php

error_reporting(-1);
ini_set('display_errors', 1);


use vitalyspirin\simplephpactiverecord\SimpleActiveRecord;

require_once __DIR__ . '/../setup/T1.php';
require_once __DIR__ . '/../setup/T2.php';
require_once __DIR__ . '/../setup/Data.php';



/**
 * @covers SimpleActiveRecord
 * @covers ValidationRulesBuilder
 * @covers TableSchema
 * @covers MySQLTableSchemaParser
 */
class SimpleActiveRecordTest extends PHPUnit_Framework_TestCase
{

    protected static $col_id; // col_id of successfully saved record
    
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        include __DIR__ . '/../setup/config.php';
        
        $pdo = new PDO("mysql:host={$db['host']};", $db['user'], $db['password']);
        $result = $pdo->exec("SET @@sql_mode = 'TRADITIONAL'");

        $sqlStr = file_get_contents(__DIR__ . "/../setup/mysql.sql");
        $result = $pdo->exec($sqlStr);

        $cfg = ActiveRecord\Config::instance();
        $cfg->set_model_directory(__DIR__ . '/../setup');
        $cfg->set_connections(
            array('development' =>
                "mysql://{$db['user']}:{$db['password']}@{$db['host']}/{$db['database']}"
            )
        );

        parent::__construct($name, $data, $dataName);
    }
    

    public function testSaveEmptyRecord()
    {
        $t1 = new T1();
        $result = $t1->save();

        $errorColumnList = array_keys($t1->errors->get_raw_errors());
        $columnList = array_keys(Data::$dataForNotNullColumnsArray);
        $extraErrorColumn = array_diff($errorColumnList, $columnList);
        $this->assertCount(0, $extraErrorColumn);
        
        $missingErrorColumn = array_diff($columnList, $errorColumnList);
        $this->assertCount(0, $missingErrorColumn);
    }
    

    public function testSaveLongStrings()
    {
        $t1 = new T1();
        $t1->set_attributes(Data::$dataForNotNullColumnsArray);
        $result = $t1->save();

        $errorColumnList = array_keys($t1->errors->get_raw_errors());
        $columnList = array_keys(Data::$dataStrictSQLValidForNotNullColumnsArray);
        $extraErrorColumn = array_diff($errorColumnList, $columnList);
        $this->assertCount(0, $extraErrorColumn);
        
        $missingErrorColumn = array_diff($columnList, $errorColumnList);
        $this->assertCount(0, $missingErrorColumn);
    }


    public function testDecimal()
    {
        $t1 = new T1();
        $t1->set_attributes(Data::$dataForNotNullColumnsArray);
        $t1->set_attributes(Data::$dataStrictSQLValidForNotNullColumnsArray);
        $t1->col_decimal3 = -1;

        $result = $t1->save();
        $this->assertCount(1, $t1->errors->get_raw_errors());

    }


    public function testSuccessfulSaveInStrictSQLMode()
    {
        $t1 = new T1();
        $t1->set_attributes(Data::$dataForNotNullColumnsArray);
        $t1->set_attributes(Data::$dataStrictSQLValidForNotNullColumnsArray);
        
        // for further test of unique validator
        $t1->col_int1 = 1;
        $t1->col_integer1 = 2;
        $t1->col_integer3 = 3;
        $result = $t1->save();

        $result = $t1->save();

        $this->assertNull($t1->errors->get_raw_errors());
        
        self::$col_id = $t1->col_id;
    }


    /**
     * need prior saving of row to test unique values
     * @depends testSuccessfulSaveInStrictSQLMode
     */
    public function testForUnique()
    {
        $t1 = new T1();
        $t1->set_attributes(Data::$dataForNotNullColumnsArray);
        $t1->set_attributes(Data::$dataStrictSQLValidForNotNullColumnsArray);
        $t1->col_int1 = 1;
        $result = $t1->save();

        $this->assertTrue( array_key_exists('col_int1', $t1->errors->get_raw_errors()) );

        $t1->col_integer1 = 2;
        $t1->col_integer3 = 3;
        $result = $t1->save();

        $result = array_key_exists('col_integer1_and_col_integer3', 
            $t1->errors->get_raw_errors());
        $this->assertTrue($result);

    }


    public function testForTableWithOneColumn()
    {
        $t2 = new t2\T2();

        $this->assertTrue(true);
    }


    public function testPassingAttributesToConstructor()
    {
        $t1 = new T1(['col_int1'=>456]);
        $this->assertEquals($t1->col_int1, 456);
    }
    
    
    public function testTableNameWithNamespace()
    {
        $t2 = new t2\T2();
        $this->assertEquals(t2\T2::$table_name, 't2');
    }
    
    
}
