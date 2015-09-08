# Yireo\_Moodle
This repository contains a setup to make database connections from
Magento to a Moodle database. To make use of this, edit your
`app/etc/local.xml` file and add a section `<moodle_setup>` to your
`<resources>`:

```xml
<config>
    <global>
        <resources>
            <moodle_setup>
                <connection>
                    <host><![CDATA[localhost]]></host>
                    <username><![CDATA[MOODLE]]></username>
                    <password><![CDATA[MOODLE]]></password>
                    <dbname><![CDATA[MOODLE]]></dbname>
                    <initStatements><![CDATA[SET NAMES utf8]]></initStatements>
                    <model><![CDATA[mysql4]]></model>
                    <type><![CDATA[pdo_mysql]]></type>
                    <pdoType><![CDATA[]]></pdoType>
                    <active>1</active>
                </connection>
            </moodle_setup>
            <moodle_write>
                <connection>
                    <use>moodle_setup</use>
                </connection>
            </moodle_write>
            <moodle_read>
                <connection>
                    <use>moodle_setup</use>
                </connection>
            </moodle_read>
        </resources>
    </global>
</config>
```

After this, you can use the Magento helper of this module to make database calls:
```php
$moodleDb = Mage::helper('moodle')->getMoodleDbConnection();
$moodleDb->fetchOne($query);
```

Note: This extension is not meant for end-users, but purely for developers.

## Other functionality
Fetch the Moodle user ID for a specific Magento customer - matched by email-address.
```php
/** @var Mage_Customer_Model_Customer @customer */
$moodleUserId = $moodleDb->getUseridByCustomer($customer);
```

## Status
Current status: Dumpware
