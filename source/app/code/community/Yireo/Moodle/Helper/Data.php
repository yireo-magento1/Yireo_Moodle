<?php
class Yireo_Moodle_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getMoodleDbConnection()
    {
        $resource = Mage::getSingleton('core/resource');
        $db = $resource->getConnection('moodle_setup');
        return $db;
    }

    public function getUseridByCustomer($customer)
    {
        $moodle = $this->getMoodleDbConnection();
        $query = 'SELECT `id` FROM `mdl_user` WHERE `email`='.$moodle->quote($customer->getEmail());
        $id = $moodle->fetchOne($query);

        if(empty($id)) {
            $query = 'INSERT INTO `mdl_user` SET `auth`="manual", `confirmed`="1", `policyagreed`="0", `mnethostid`="1",'
                . '`username`='.$moodle->quote($customer->getId()).', `idnumber`='.$moodle->quote($customer->getId()).','
                . '`email`='.$moodle->quote($customer->getEmail()).','
                . '`password`="'.md5($customer->getEmail().$customer->getFirstname()).'",'
                . '`firstname`='.$moodle->quote($customer->getFirstname()).', `lastname`='.$moodle->quote($customer->getLastname())
            ;
            $moodle->query($query);

            $query = 'SELECT `id` FROM `mdl_user` WHERE `email`='.$moodle->quote($customer->getEmail());
            $id = $moodle->fetchOne($query);
        }

        return $id;
    }

    public function arrayToSqlValues($array)
    {
        $moodle = $this->getMoodleDbConnection();
        $sql = array();
        foreach($array as $name => $value) {
            $sql[] = '`'.$name.'`='.$moodle->quote($value);
        }
        return implode(', ', $sql);
    }
}
