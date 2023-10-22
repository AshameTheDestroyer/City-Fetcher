<?php
require("./database.php");

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if ($id != null) {
    $query = "DELETE FROM city WHERE ID = :id";
    $statement = $database->prepare($query);

    $statement->bindValue(":id", $id);

    $success = $statement->execute();
    $statement->closeCursor();
}

$hasDeleted = true;

include("index.php");
?>