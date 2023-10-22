<?php
include("./inputField.php");

$cityName = filter_input(INPUT_GET, "city-name", FILTER_SANITIZE_STRING);

$newCityName = filter_input(INPUT_POST, "new-city-name", FILTER_SANITIZE_STRING);
$countryCode = filter_input(INPUT_POST, "country-code", FILTER_SANITIZE_STRING);
$district = filter_input(INPUT_POST, "district", FILTER_SANITIZE_STRING);
$population = filter_input(INPUT_POST, "population", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="A simple website to fetch cities and try my database skills." />
    <meta name="robots" content="index, follow" />

    <link rel="stylesheet" href="./css/minified/style.min.css" />

    <title>City Fetcher</title>
</head>

<body>
    <h1>City Fetcher</h1>
    <hr>

    <?php
    if ($hasDeleted) {
        echo "<p>Record has been deleted.</p>";
    } else if ($hasUpdated) {
        echo "<p>Record has been updated.</p>";
    }
    ?>

    <main>
        <?php if ($cityName == null && $newCityName == null): ?>
            <section>
                <h2>Read Data</h2>
                <form action="./" method="GET">
                    <?php inputField("City Name", "city-name") ?>
                    <button>Submit</button>
                </form>
            </section>

            <section>
                <h2>Create Data</h2>
                <form action="./" method="POST">
                    <?php inputField("New City Name", "new-city-name") ?>
                    <?php inputField("Country Code", "country-code", null, null, "text", true, 3) ?>
                    <?php inputField("District", "district") ?>
                    <?php inputField("Population", "population") ?>
                    <button>Submit</button>
                </form>
            </section>
        <?php else:
            require("./database.php");

            if ($newCityName != null) {
                $query = "INSERT INTO city
                    (name, countryCode, district, population) VALUES
                    (:newCityName, :countryCode, :district, :population)";
                $statement = $database->prepare($query);

                $statement->bindValue(":newCityName", $newCityName);
                $statement->bindValue(":countryCode", $countryCode);
                $statement->bindValue(":district", $district);
                $statement->bindValue(":population", $population);

                $statement->execute();
                $statement->closeCursor();
            }

            if ($cityName != null || $newCityName != null) {
                $query = "SELECT * FROM city WHERE Name = :cityName ORDER BY Population DESC";
                $statement = $database->prepare($query);

                $statement->bindValue(":cityName", $cityName ?? $newCityName);

                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
            }
            ?>

            <?php if ($results != null): ?>
                <section>
                    <h2>Update / Delete Data</h2>
                    <?php foreach ($results as $result): ?>
                        <form action="updateRecord.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $result["ID"] ?>" />
                            <?php inputField("City Name", "city-name-" . $result["ID"], "updated-city-name", $result["Name"]) ?>
                            <?php inputField("Country Code", "country-code-" . $result["ID"], "updated-country-code", $result["CountryCode"], "text", true, 3) ?>
                            <?php inputField("District", "district-" . $result["ID"], "updated-district", $result["District"]) ?>
                            <?php inputField("Population", "population-" . $result["ID"], "updated-population", $result["Population"]) ?>
                            <button>Update</button>
                        </form>
                        <form action="deleteRecord.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $result["ID"] ?>" />
                            <button style="background-color: crimson;">Delete</button>
                        </form>
                    <?php endforeach ?>
                </section>
            <?php else: ?>
                <p>Sorry, no results.</p>
            <?php endif ?>

            <button type="button">
                <a href="./">Go Back</a>
            </button>
        <?php endif ?>
    </main>
</body>

</html>