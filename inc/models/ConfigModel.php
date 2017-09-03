<?php
class ConfigModel {

    public static function getConfig() {
        $configDataSeriall = file_get_contents(ROOT . '/config/config.php');
        $configData = array();
        if (!empty($configDataSeriall)) {
            $configData = unserialize($configDataSeriall);
        }
        return $configData;
    }

    public static function saveConfig($configData) {
        if (!empty($configData)) {
            file_put_contents(ROOT . '/config/config.php',serialize($configData));
        }
    }

}