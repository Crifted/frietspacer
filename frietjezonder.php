<?php
// Dit bestand beheert de logica specifiek voor het schip "Frietje Zonder".
// Acties zoals schieten, herladen en speciale aanvallen worden hier verwerkt.


include_once 'frietjeship.php';

// Start een sessie om de status van het spel en de schepen te behouden tussen pagina-verversingen.
session_start();

// Controleer of de schepen al bestaan in de sessie.
// Als de schepen nog niet zijn aangemaakt, maak ze hier aan.
if (!isset($_SESSION['ship1']) || !isset($_SESSION['ship2'])) {
    $_SESSION['ship1'] = new FrietShip("Frietje Oorlog"); // Creëer het eerste schip: Frietje Oorlog.
    $_SESSION['ship2'] = new FrietShip("Frietje Zonder"); // Creëer het tweede schip: Frietje Zonder.
}

// Haal de schepen uit de sessie zodat we ze kunnen bewerken of gebruiken.
$ship1 = $_SESSION['ship1']; // Het eerste schip: Frietje Oorlog.
$ship2 = $_SESSION['ship2']; // Het tweede schip: Frietje Zonder.

// Controleer of de gebruiker een actie heeft uitgevoerd die specifiek is voor Frietje Zonder.
if (isset($_POST['action'])) { // Controleer of er een actie in het formulier is verstuurd.
    switch ($_POST['action']) { // Kijk welke actie is geselecteerd.
        case 'ship2_shoot': // Als Frietje Zonder schiet op Frietje Oorlog:
            $damage = $ship2->shoot(); // Bereken de schade veroorzaakt door het schot.
            $ship1->takeDamage($damage); // Breng de schade toe aan Frietje Oorlog.
            break;

        case 'ship2_reload': // Als Frietje Zonder zijn munitie herlaadt:
            $ship2->reload(); // Voeg munitie toe aan Frietje Zonder.
            break;

        case 'ship2_special': // Als Frietje Zonder een speciale aanval uitvoert:
            if ($ship2->ammo >= 20) { // Controleer of er genoeg munitie is voor de speciale aanval.
                $damage = $ship2->shoot(30); // Een speciale aanval doet meer schade (30 i.p.v. 10).
                $ship1->takeDamage($damage); // Breng de extra schade toe aan Frietje Oorlog.
                echo "{$ship2->name} heeft een speciale aanval uitgevoerd en 30 schade gedaan!<br>";
            } else {
                echo "{$ship2->name} heeft niet genoeg munitie voor een speciale aanval!<br>";
            }
            break;

        case 'reset': // Als het spel wordt gereset:
            $ship1->reset(); // Reset Frietje Oorlog naar de beginstatus.
            $ship2->reset(); // Reset Frietje Zonder naar de beginstatus.
            break;
    }
}

// Werk de nieuwe status van de schepen bij in de sessie.
// Dit zorgt ervoor dat de veranderingen behouden blijven bij het herladen van de pagina.
$_SESSION['ship1'] = $ship1; // Sla de bijgewerkte status van Frietje Oorlog op.
$_SESSION['ship2'] = $ship2; // Sla de bijgewerkte status van Frietje Zonder op.
?>
