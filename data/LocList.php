<?php
set_time_limit(0);
$pdo = new PDO('mysql:dbname=test;host=127.0.0.1', 'root', '');
$pdo->exec('SET NAMES UTF8');

$xmlElement = simplexml_load_file('LocList.xml');

foreach($xmlElement->CountryRegion as $CountryRegion) {
    $countryAttr = $CountryRegion->attributes();
    $countryName = $countryAttr['Name'];
    $countryId = insertLoc($countryName, null, 'country');
    
    foreach($CountryRegion->State as $State) {
        $stateAttr = $State->attributes();
        $stateName = $stateAttr['Name'];
        if (!empty($stateName)) {
            $stateId = insertLoc($stateName, $countryId, 'state');
        } else {
            $stateId = $countryId;
        }
        
        foreach($State->City as $City) {
            $cityAttr = $City->attributes();
            $cityName = $cityAttr['Name'];
            if (!empty($cityName)) {
                $cityId = insertLoc($cityName, $stateId, 'city');
            } else {
                $cityId = $stateId;
            }
            
            foreach($City->Region as $Region) {
                $regionAttr = $Region->attributes();
                $regionName = $regionAttr['Name'];
                if (!empty($regionName)) {
                    insertLoc($regionName, $cityId, 'region');
                }
            }
        }
    }
}

function insertLoc($name, $pid, $type)
{
    global $pdo;
    $name = $pdo->quote($name);
    $type = $pdo->quote($type);
    $pid = $pid === null ? 'NULL' : $pdo->quote($pid);
    
    $pdo->exec("INSERT INTO t_location (name, parent_id, type) VALUES ({$name}, {$pid}, {$type})");
    return $pdo->lastInsertId();
}