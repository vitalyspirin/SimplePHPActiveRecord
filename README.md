# SimplePHPActiveRecord

Extension of PHP ActiveRecord with automatically generated validators.

## Quick Start and Examples
```php
class T1 extends SimpleActiveRecord
{
    
}
```

There is no need to hardcode validators since they will be added automatically by 
class constructor based on table schema. However in current version relations 
(based on foreign keys) will not be added.

Instance of such class is created in a usual way:

```php
$t1 = new T1();
```

If table schema changed then validators will be adjusted automatically.

You can also see tests in [SimpleActiveRecordTest.php](tests/unit/SimpleActiveRecordTest.php) for simple examples.
