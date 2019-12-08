<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="stylesheet.css" rel="stylesheet">
    <title>Bestellung</title>
</head>
<body>
<img class="BildCenter" src="media/samsunglogo.png" height="53" width="160" alt="Samsung Logo">
<div class="Menü">
    <ul>
        <li class="menutab"><a href="index.html">Startseite</a></li>
        <li class="menutab"><a href="kuehlschraenke/kuehlschraenke.html">Kühlschränke</a></li>
        <li class="menutab"><a href="smartphones/smartphones.html">Smartphones</a></li>
        <li class="menutab"><a href="impressum.html">Impressum</a></li>
        <li class="menutab"><a href="bestellung.html">Bestellung</a></li>
    </ul>
</div>

<br/><br/><br/>

<div class="center">
    <?php
    echo "<h2>Bestellbestätigung:</h2>";
    var_dump($_POST);
    //exit;

    echo "<br/><br/>";

    //Überprüfung ob mehr als ein Produkt ausgewählt wurde, !empty($_POST["produkte"]) braucht man wegen PHP Warnings
    if (!empty($_POST["produkte"]) && count($_POST["produkte"]) > 1) {
        echo "<h4>Bitte wählen sie nur ein Produkt aus der Liste aus.</h4>";
    } //Überprüfung ob kein Produkt ausgewählt wurde
    elseif (empty($_POST["produkte"])) {
        echo "<h4>Bitte wählen sie ein Produkt aus.</h4>";
    } //Wenn eins ausgewählt wurde weiter machen
    else {
        echo "<h4>Hallo Herr/Frau " . $_POST["nachname"] . ", ihre Bestellung war erfolgreich!</h4>";
        echo "Zusammenfassung ihrer Bestellung:<br/><br/>";

        //Tabelle
        echo "<div class=\"tabelle\"><table border='1'>";
        echo "<tr><td><b>Produkt:</b></td>";
        echo "<td>";
        //Foreach Schleife, da man anders den Produkte Array nicht ausgeben kann
        foreach($_POST["produkte"] as $schluessel => $wert) {
            echo $wert;
        }
        echo "</td></tr>";

        //Farbe ausgeben
        echo "<tr><td><b>Farbe:</b></td>";
        echo "<td>".$_POST["farbe"]."</td></tr>";

        //Abfrage nach Expressversand, je nach Checkbox-Status wird eine andere Antwort geliefert
        if (isset($_POST["expressversand"])){
            echo "<tr><td><b>Expressversand:</b></td>";
            echo "<td>ja</td></tr>";
        } else{
            echo "<tr><td><b>Expressversand:</b></td>";
            echo "<td>nein</td></tr>";
        }
        echo "</table></div>";

        if(!empty($_POST["nachricht"])){

        }


            //Todo: Ihre Bestellung kommt vorraussichtlich am $tag in $ort an.
            //Todo: Bankmitteilungen anzeigen
            //Todo: Preis berechnen anhand Versandart

    }

    ?>
</div>

</body>
</html>