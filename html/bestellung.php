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

<br/>

<div class="center">
    <?php

    //Formularüberprüfung, ob alles ausgefüllt wurde
    check($_POST);

    //Falls Expressversand gewählt wurde fallen Zusatzkosten an
    //Variablen werden am Anfang gesetzt, weil man sie später braucht
    if (isset($_POST["expressversand"])) {
        $zusatzkosten = 5;
        $expressversand = true;
        $tage = 1;
    } else {
        $zusatzkosten = 0;
        $expressversand = false;
        $tage = 3;
    }

    echo "<h2>Bestellbestätigung:</h2>";

    echo "<h4>Hallo Herr/Frau " . $_POST["nachname"] . ", ihre Bestellung war erfolgreich!</h4>";
    echo "Zusammenfassung ihrer Bestellung:<br/><br/>";

    //Schleife über die Produkte, je Produkt wird eine Tabelle generiert
    foreach ($_POST["produkte"] as $schluessel => $wert) {
        generatetable($_POST["farbe"], $wert, $expressversand);
        echo "<br/>";
    }

    //Falls eine Mitteilung hinterlassen wurde Ausgabe eines Erfolgstextes
    if (!empty($_POST["nachricht"])) {
        echo "<br/>Wir haben ihre Mitteilung/ihren Wunsch erhalten.";
    }

    echo "<br/><br/>";
    //Berechnung des Gesamtpreises
    //Für jedes Produkt wird der Preis bestimt, der dann zum Gesamtpreis addiert wird
    //zum Schluss kommen noch evtl. Zusatzkosten mit dazu
    $gesamtpreis = 0;
    foreach ($_POST["produkte"] as $schluessel => $wert) {
        $gesamtpreis += calculateproductprice($wert);
    }
    $gesamtpreis += $zusatzkosten;
    echo "Ihr Gesamtpreis beträgt: " . $gesamtpreis . "€";


    echo "<p>Bitte überweisen sie das Geld auf unser Bankkonto:</p>";
    echo "<p>IBAN: DE02500105170137075030</p>";
    echo "<p>BIC: INGDDEFF</p>";
    //Überprüfung auf $tage, damit der Satz die korrekte Mehrzahl von "Tag" hat
    if ($tage == 1){
        echo "<p>Nach Zahlungseingang wird es aufgrund ihrer gewählten Versandart ca. " . $tage .
            " Tag brauchen bis das Paket in " . $_POST["ort"] . " ankommt.</p>";
    }
    else{
        echo "<p>Nach Zahlungseingang wird es aufgrund ihrer gewählten Versandart ca. " . $tage .
            " Tage brauchen bis das Paket in " . $_POST["ort"] . " ankommt.</p>";
    }

    //Überprüft ob alles Ausgefüllt wurde und ob ein Produkt ausgewählt wurde
    function check($form)
    {
        //Wenn kein Produkt ausgewählt wurde
        if (empty($form["produkte"])) {
            echo "<h4>Bitte wählen sie ein Produkt aus, welches sie bestellen wollen und überprüfen sie das Formular.</h4>";
            echo "<a href=\"bestellung.html\">Zurück</a>";
            exit;
        } else {
            //Wenn etwas anderes fehlt Fehlermeldung zeigen, Überprüft ob die Strings im Formular die Länge 0 haben
            if (strlen($form["nachname"]) == 0 || strlen($form["email"]) == 0 || strlen($form["vorname"]) == 0 ||
                strlen($form["straßenr"]) == 0 || strlen($form["email"]) == 0 || strlen($form["plz"]) == 0 ||
                strlen($form["ort"]) == 0) {
                echo "<h4>Bitte überprüfen sie das Formular auf fehlende Angaben.</h4>";
                echo "<a href=\"bestellung.html\">Zurück</a>";
                exit;
            }
        }
    }

    function generatetable($farbe, $produkt, $expressversand)
    {
        //Tabelle erstellen
        echo "<div class=\"tabelle\"><table border='1'>";
        //Produkt ausgeben
        echo "<tr><td><b>Produkt:</b></td>";
        echo "<td>" . $produkt . "</td></tr>";

        //Farbe ausgeben
        echo "<tr><td><b>Farbe:</b></td>";
        echo "<td>" . $farbe . "</td></tr>";

        //Abfrage nach Expressversand, je nach Checkbox-Status wird eine andere Antwort geliefert
        if ($expressversand) {
            echo "<tr><td><b>Expressversand:</b></td>";
            echo "<td>ja</td></tr>";
        } else {
            echo "<tr><td><b>Expressversand:</b></td>";
            echo "<td>nein</td></tr>";
        }
        //Tabelle beenden
        echo "</table></div>";

    }

    //bekommt das Produkt und gibt den Preis zurück
    function calculateproductprice($produkt)
    {
        $preis = 0;
        switch ($produkt) {
            case "Galaxy S9 64GB":
                $preis += 500;
                break;
            case "Galaxy S9 128GB":
                $preis += 600;
                break;
            case "Galaxy Note 9 64GB":
            case "Galaxy S9 512GB":
                $preis += 700;
                break;
            case "Galaxy Note 9 128GB":
                $preis += 800;
                break;
            case "Galaxy Note 9 512GB":
                $preis += 900;
                break;
        }
        return $preis;
    }

    ?>
</div>

</body>
</html>