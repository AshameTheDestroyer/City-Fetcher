<?php
require("./database.php");

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$updatedCityName = filter_input(INPUT_POST, "updated-city-name", FILTER_SANITIZE_STRING);
$updatedCountryCode = filter_input(INPUT_POST, "updated-country-code", FILTER_SANITIZE_STRING);
$updatedDistrict = filter_input(INPUT_POST, "updated-district", FILTER_SANITIZE_STRING);
$updatedPopulation = filter_input(INPUT_POST, "updated-population", FILTER_SANITIZE_STRING);
try {
    if ($id != null) {
        $query = "UPDATE city SET
        Name = :cityName,
        CountryCode = :countryCode,
        District = :district,
        Population = :population
        WHERE ID = :id";
        $statement = $database->prepare($query);

        $statement->bindValue(":id", $id);
        $statement->bindValue(":cityName", $updatedCityName);
        $statement->bindValue(":countryCode", $updatedCountryCode);
        $statement->bindValue(":district", $updatedDistrict);
        $statement->bindValue(":population", $updatedPopulation);

        $success = $statement->execute();
        $statement->closeCursor();
    }
} catch (PDOException $e) {
    echo $e . "<br />";
}

$hasUpdated = true;

include("./index.php");
?>