<?php
// Dit is de class voor een FrietShip (ruimte-schip in de vorm van friet).
// Elk FrietShip heeft gezondheidspunten (hitPoints), munitie (ammo), een naam en een status (levend of vernietigd).

class FrietShip
{
    public string $name;   // De naam van het FrietShip (bijvoorbeeld: "Frietje Oorlog").
    public int $ammo;      // Hoeveel munitie het FrietShip heeft.
    public int $hitPoints; // De gezondheidspunten (HP) van het FrietShip.
    public bool $isAlive;  // Status: leeft het schip nog? (true = leeft, false = vernietigd).

    // Constructor: deze functie wordt uitgevoerd zodra een nieuw FrietShip wordt aangemaakt.
    public function __construct($name = "FrietShip", $ammo = 100, $hitPoints = 100)
    {
        $this->name = $name;           // Wijs een naam toe aan het FrietShip.
        $this->ammo = $ammo;           // Stel het aantal munitie in (standaard is 100).
        $this->hitPoints = $hitPoints; // Stel de gezondheidspunten in (standaard is 100).
        $this->isAlive = true;         // Het schip is standaard "levend" als het wordt aangemaakt.
    }

    // Functie: shoot (schieten)
    // Het schip schiet, wat 10 munitie kost en schade toebrengt aan de tegenstander.
    public function shoot($damage = 10): int
    {
        if ($this->ammo >= 10) { // Controleer of het schip genoeg munitie heeft om te schieten (minimaal 10 nodig).
            $this->ammo -= 10;   // Verminder de munitie met 10.
            return $damage;      // Retourneer de schade die is veroorzaakt (standaard 10).
        }
        // Als er niet genoeg munitie is, toon een melding en retourneer 0 schade.
        echo "{$this->name} heeft geen munitie meer!<br>";
        return 0;
    }

    // Functie: takeDamage (schade oplopen)
    // Deze functie vermindert de gezondheidspunten van het schip als het wordt geraakt.
    public function takeDamage($damage): void
    {
        $this->hitPoints -= $damage; // Verminder de gezondheidspunten met de ontvangen schade.
        if ($this->hitPoints <= 0) { // Als de gezondheidspunten op of onder 0 komen:
            $this->isAlive = false;  // Zet de status van het schip op "vernietigd".
            $this->hitPoints = 0;    // Zorg dat de gezondheid niet onder 0 gaat.
        }
    }

    // Functie: reload (munitie herladen)
    // Deze functie voegt 20 munitie toe aan het schip.
    public function reload(): void
    {
        $this->ammo += 20; // Voeg 20 munitie toe.
        if ($this->ammo > 100) { // Controleer of de munitie de maximale waarde (100) overschrijdt.
            $this->ammo = 100; // Zorg dat de munitie niet hoger dan 100 kan zijn.
        }
    }

    // Functie: reset
    // Deze functie zet het schip terug naar de beginstatus (volledige gezondheid en munitie).
    public function reset(): void
    {
        $this->ammo = 100;      // Zet de munitie terug naar 100.
        $this->hitPoints = 100; // Zet de gezondheidspunten terug naar 100.
        $this->isAlive = true;  // Markeer het schip weer als "levend".
    }
}
?>
