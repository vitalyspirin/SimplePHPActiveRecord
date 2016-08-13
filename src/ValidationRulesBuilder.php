<?php

namespace vitalyspirin\simplephpactiverecord;

class ValidationRulesBuilder extends TableSchema
{
    const DATABASE_IS_NOT_SUPPORTED = 'Database is not supported';
    public static $supportedDatabaseList = [
        'mysql' => 'vitalyspirin\simplephpactiverecord\MySqlTableSchemaParser'
    ];
    protected $tableSchemaParserClass;


    public function __construct($tableName, $dsn, $pdo)
    {
        if (! $this->isDatabaseSupported($dsn)) {
            throw new Exception(DATABASE_IS_NOT_SUPPORTED);
        }


        if (isset(MySqlTableSchemaParser::$describeTable[$tableName])) {
            $tableSchemaRowList = MySqlTableSchemaParser::$describeTable[$tableName];
        } else {
            $pdoAttributeATTR_CASE = $pdo->getAttribute(\PDO::ATTR_CASE);
            $pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
            $pdoStatement = $pdo->query('DESCRIBE ' . $tableName);
            $tableSchemaRowList = $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
            MySqlTableSchemaParser::$describeTable[$tableName] = $tableSchemaRowList;

            $pdoStatement = $pdo->query('SHOW CREATE TABLE ' . $tableName);
            $tableSchemaStr = $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
            MySqlTableSchemaParser::$showCreateTable[$tableName] =
                $tableSchemaStr[0]['Create Table'];

            $pdo->setAttribute(\PDO::ATTR_CASE, $pdoAttributeATTR_CASE);
        }

        $tableSchemaParser = new $this->tableSchemaParserClass($this, $tableName,
            $tableSchemaRowList, true);


        parent::__construct();
    }


    protected function isDatabaseSupported($dns)
    {
        $result = false;

        foreach (self::$supportedDatabaseList as $supportedDatabase => $tableSchemaClass) {
            if (substr($dns, 0, strlen($supportedDatabase)) == $supportedDatabase) {
                $this->tableSchemaParserClass = $tableSchemaClass;

                $result = true;
                break;
            }
        }

        return $result;
    }


    public function buildRequiredRules(&$validates_presence_of)
    {
        foreach ($this->requiredColumnList as $requiredColumn) {
            $validates_presence_of[] = [$requiredColumn];
        }
    }


    public function buildStringRules(&$ruleList)
    {
        foreach ($this->stringColumnList as $stringLength => $columnNameList) {
            if ($stringLength != TableSchema::DEFAULT_LEGNTH_STRINGS) {
                foreach ($columnNameList as $columnName) {
                    $ruleList[] = [$columnName, 'maximum' => $stringLength];
                }
            }
        }
    }


    public function buildUniqueRules(&$ruleList)
    {
        foreach ($this->uniqueColumnList as $columnInOneConstraintList) {
            if (count($columnInOneConstraintList) > 1) {
                $ruleList[] = [$columnInOneConstraintList];
            } else {
                $ruleList[] = $columnInOneConstraintList;
            }
        }
    }


    public function buildRangeRules(&$ruleList)
    {
        foreach ($this->rangeColumnList as $valueListStr => $columnNameList) {
            preg_match_all("/'(.*?)'/", $valueListStr, $matches);

            foreach ($columnNameList as $columnName) {
                $ruleList[] = [ $columnName,
                    'in' => $matches[1],
                    'allow_null' => true
                ];
            }
        }
    }


    public function buildTimeRules(&$ruleList)
    {
        foreach ($this->timeColumnList as $timeColumn) {
            $ruleList[] = [$timeColumn, 'with' => TableSchema::TIME_PATTERN];
        }
    }


    public function buildIntegerWithRangeRules(&$ruleList)
    {
        foreach ($this->integerWithRangeColumnList as $integerType => $valueList) {
            if (isset($valueList[0])) {
                foreach ($valueList[0] as $value) {
                    $ruleList[] = [$value,
                        'greater_than_or_equal_to' => $valueList['min'],
                        'less_than_or_equal_to' => $valueList['max'],
                        'only_integer' => true,
                        'allow_null' => true
                    ];
                }
            }
        }
    }


    public function buildNumberWithRangeRules(&$ruleList)
    {
        foreach ($this->numberWithRangeColumnList as $numberType => $valueList) {
            if (isset($valueList[0])) {
                foreach ($valueList[0] as $value) {
                    if (isset($valueList['max'])) {
                        $ruleList[] = [$value,
                            'greater_than_or_equal_to' => $valueList['min'],
                            'less_than_or_equal_to' => $valueList['max'],
                            'allow_null' => true
                        ];
                    } elseif (isset($valueList['min'])) {
                        $ruleList[] = [$value,
                            'greater_than_or_equal_to' => $valueList['min'],
                            'allow_null' => true
                        ];
                    } else {
                        $ruleList[] = [$value,
                            'allow_null' => true
                        ];
                    }
                }
            }
        }
    }
}
