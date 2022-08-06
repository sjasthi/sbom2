# bom
    Software BOM

# Login Credentials:
    Users:
    ics325@metrostate.edu
    ics499@metrostate.edu

# Installing dependencies for xlsx support.
- https://phpspreadsheet.readthedocs.io/en/latest/
- https://getcomposer.org/download/

Roughly the instructions are the following commands (please confirm details for your platform in the linked pages):
## Setup Composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
## Setup phpspreadsheet
```
php composer.phar require phpoffice/phpspreadsheet
```

# CSV Import - Monitoring Digest
When specifying monitoring digest values in a CSV you *MUST* use a semi colon to seperate the values, the semi-colon delimiter will later be converted to a common for the database insert, an example of a valid entry for the monitoring digest field:
```75 critical; 90 major; 65 minor```
Let me emphasize again that the format of this field is quit strict.