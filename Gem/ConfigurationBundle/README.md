# Gem/ConfigurationBundle
This bundle used to setting automatic configuration of system.
# Usage
1. Register a parameter into file /path/ConfigurationBundle/Resource/config/system.yml
    note: globals => this is a list parameter, that is corresponding value in "configuration_configs" parameter
    ```
    parameters:
        globals:
            - doctrine_mongo_connection.server
            - doctrine_mongo_connection.options
        configuration_configs:
            doctrine_mongo_connection:
                server: 'mongodb://localhost:27017'
                options:
                    username: admin
                    password: admin
                    db: admin
                default_database: test

    The value of 'doctrine_mongo_connection.server' parameter is 'mongodb://localhost:27017'
    The value of 'doctrine_mongo_connection.options' parameter is [username=> admin, password=> admin, db=> admin]
    ```
2. Get config
    ```
        $mongo_connection = \Gem\ConfigurationBundle\Lib\Configuration::getConfig('doctrine_mongo_connection');
        $mongo_default_database = \Gem\ConfigurationBundle\Lib\Configuration::getConfig('doctrine_mongo_connection.default_database');
    ```
# License
```
The MIT License (MIT)

Copyright (c) 2015 Duy Huynh

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
