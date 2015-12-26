## Launching tests

To launch tests you need to add library from phpactiverecord.org into 
/php-activerecord directory. So the directory structure has to look like this:

![folderStructure.png](/tests/docs/folderStructure.png "folder structure")

Then you need to specify database parameters in /tests/setup/config.php. 
Test database that will be automatically created is 'simpleactiverecord'. 

After that you can change working directory to /tests (where file phpunit.xml 
with white list code coverage configuration is located) and launch tests using 
terminal command:
```
$ phpunit  unit/SimpleActiveRecordTest.php
```
The output should be like this:
```
PHPUnit 4.8.21 by Sebastian Bergmann and contributors.

....

Time: 773 ms, Memory: 6.75Mb

OK (4 tests, 7 assertions)
```

## Code Coverage

![codeCoverage.png](/tests/docs/codeCoverage.png "code coverage screenshot")


## Class diagram

![UML.png](/tests/docs/uml.png "UML diagram")
