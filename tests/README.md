## Launching tests

To launch tests you need to specify database parameters in /tests/setup/config.php. 
Test database that will be automatically created is 'simpleactiverecord'. 

After that you can launch tests using terminal command:
```
$ composer test
```
The output should be like this:
```
> vendor/bin/phpunit --configuration tests --coverage-html tests/codecoverage tests/unit/
PHPUnit 4.8.27 by Sebastian Bergmann and contributors.

........

Time: 6.07 seconds, Memory: 11.25MB

OK (8 tests, 11 assertions)

Generating code coverage report in HTML format ... done
```

## Code Coverage

![codeCoverage.png](/tests/docs/codeCoverage.png "code coverage screenshot")


## Class diagram

![UML.png](/tests/docs/uml.png "UML diagram")
