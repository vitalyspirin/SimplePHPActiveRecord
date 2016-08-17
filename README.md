# SimplePHPActiveRecord

Extension of PHP ActiveRecord (phpactiverecord.org) with automatically 
generated validators.

## Installation
```
composer require vitalyspirin/simplephpactiverecord
```

## Quick Start
```php
class T1 extends \vitalyspirin\simplephpactiverecord\SimpleActiveRecord
{
    public static $validates_presence_of = [];
    public static $validates_size_of = [];
    public static $validates_numericality_of = [];
    public static $validates_uniqueness_of = [];
    public static $validates_inclusion_of = [];
    public static $validates_format_of = [];
}
```

There is no need to hardcode validators since they will be added automatically by 
class constructor based on table schema. However in current version relations 
(based on foreign keys) will not be added. 

Static properties (validators) have to be added to every child model extending SimpleActiveRecord
class because in PHP it's impossible to create static properties dynamically.

Instance of such class is created in a usual way:

```php
$t1 = new T1();
```

If table schema changed then validators will be adjusted automatically.


## Examples

Let's say we have the following SQL schema:
```sql
CREATE TABLE person
(
  person_id         INT PRIMARY KEY AUTO_INCREMENT,
  person_firstname  VARCHAR(35) NOT NULL,
  person_lastname   VARCHAR(35) NOT NULL,
  person_gender     ENUM('male', 'female'),
  person_dob        DATE NULL,
  person_salary     DECIMAL UNSIGNED
);
```

then if we run the following code:
```php
class Person extends \vitalyspirin\simplephpactiverecord\SimpleActiveRecord
{
    static $table_name = 'person';
    
    public static $validates_presence_of = [];
    public static $validates_size_of = [];
    public static $validates_numericality_of = [];
    public static $validates_uniqueness_of = [];
    public static $validates_inclusion_of = [];
    public static $validates_format_of = [];
}

$person = new Person();

echo "validates_presence_of:";
var_dump($person::$validates_presence_of);

echo "validates_size_of:";
var_dump($person::$validates_size_of);

echo "validates_numericality_of:";
var_dump($person::$validates_numericality_of);

echo "validates_inclusion_of:";
var_dump($person::$validates_inclusion_of);
```

we will get the following output:
```
validates_presence_of:array(2) {
  [0] =>
  array(1) {
    [0] =>
    string(16) "person_firstname"
  }
  [1] =>
  array(1) {
    [0] =>
    string(15) "person_lastname"
  }
}
validates_size_of:array(2) {
  [0] =>
  array(2) {
    [0] =>
    string(16) "person_firstname"
    'maximum' =>
    int(35)
  }
  [1] =>
  array(2) {
    [0] =>
    string(15) "person_lastname"
    'maximum' =>
    int(35)
  }
}
validates_numericality_of:array(1) {
  [0] =>
  array(3) {
    [0] =>
    string(13) "person_salary"
    'greater_than_or_equal_to' =>
    int(0)
    'allow_null' =>
    bool(true)
  }
}
validates_inclusion_of:array(1) {
  [0] =>
  array(3) {
    [0] =>
    string(13) "person_gender"
    'in' =>
    array(2) {
      [0] =>
      string(4) "male"
      [1] =>
      string(6) "female"
    }
    'allow_null' =>
    bool(true)
  }
}
```


You can also see tests in [SimpleActiveRecordTest.php](tests/unit/SimpleActiveRecordTest.php) for simple examples.
