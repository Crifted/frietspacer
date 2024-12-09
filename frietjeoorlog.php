<?php
// Dit bestand beheert de interacties tussen twee FrietShips in het spel.
// Acties zoals schieten, herladen en resetten worden hier verwerkt.

/
include_once 'frietjeship.php';

// Start een sessie om de status van de schepen tussen pagina-verversingen te behouden.
session_start();

// Controleer of de schepen al in de sessie zijn aangemaakt.
// Als ze nog niet bestaan, maak dan twee nieuwe FrietShips.
if (!isset($_SESSION['ship1']) || !isset($_SESSION['ship2'])) {
    $_SESSION['ship1'] = new FrietShip("Frietje Oorlog"); // Eerste schip: Frietje Oorlog.
    $_SESSION['ship2'] = new FrietShip("Frietje Zonder"); // Tweede schip: Frietje Zonder.
}

// Haal de schepen op uit de sessie, zodat we ze kunnen gebruiken of bijwerken.
$ship1 = $_SESSION['ship1']; // Ship 1: Frietje Oorlog.
$ship2 = $_SESSION['ship2']; // Ship 2: Frietje Zonder.

// Controleer of de gebruiker een actie heeft uitgevoerd (bijvoorbeeld schieten of herladen).
if (isset($_POST['action'])) { // Controleer of er een actie is verzonden via het formulier.
    switch ($_POST['action']) { // Kijk welke actie is geselecteerd.
        case 'ship1_shoot': // Als Frietje Oorlog schiet:
            $damage = $ship1->shoot(); // Bereken de schade veroorzaakt door de schot.
            $ship2->takeDamage($damage); // Breng de schade toe aan Frietje Zonder.
            break;

        case 'ship2_shoot': // Als Frietje Zonder schiet:
            $damage = $ship2->shoot(); // Bereken de schade veroorzaakt door de schot.
            $ship1->takeDamage($damage); // Breng de schade toe aan Frietje Oorlog.
            break;

        case 'ship1_reload': // Als Frietje Oorlog munitie herlaadt:
            $ship1->reload(); // Voeg munitie toe aan Frietje Oorlog.
            break;

        case 'ship2_reload': // Als Frietje Zonder munitie herlaadt:
            $ship2->reload(); // Voeg munitie toe aan Frietje Zonder.
            break;

        case 'reset': // Als het spel wordt gereset:
            $ship1->reset(); // Reset Frietje Oorlog naar de beginstatus.
            $ship2->reset(); // Reset Frietje Zonder naar de beginstatus.
            break;
    }
}

// Werk de bijgewerkte status van de schepen weer op in de sessie.
// Dit zorgt ervoor dat de veranderingen worden opgeslagen en beschikbaar blijven.
$_SESSION['ship1'] = $ship1; // Sla de nieuwe status van Frietje Oorlog op.
$_SESSION['ship2'] = $ship2; // Sla de nieuwe status van Frietje Zonder op.
?>
