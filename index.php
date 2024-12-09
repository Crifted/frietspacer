<?php
// Dit bestand is de hoofdpagina van het FrietShip Battle-spel.
// Het haalt de spel-logica op uit het bestand 'frietjeoorlog.php'.
include_once 'frietjeoorlog.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta-tags voor compatibiliteit en responsief design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrietShip Battle</title>

    <!-- Interne CSS -->
    <style>
        /* Algemene stijl voor de pagina */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background: radial-gradient(circle at top, #141e30, #243b55); /* Ruimte-thema */
            color: #ffffff;
            min-height: 100vh;
            overflow: hidden; /* Verwijder scrollen voor strak design */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Geanimeerde achtergrond */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 200%;
            background: url('https://www.transparenttextures.com/patterns/black-paper.png') repeat;
            animation: scrollBg 20s linear infinite;
        }

        @keyframes scrollBg {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        /* Stijl voor de titel */
        h1 {
            font-size: 4rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #ffd700;
            background: linear-gradient(to right, #ffd700, #ffffff);
            background-size: 200%;
            -webkit-background-clip: text;
            color: transparent;
            animation: shine 5s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes shine {
            0% { background-position: 0%; }
            100% { background-position: 200%; }
        }

        /* Stijl voor de statusbox */
        .status {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.8);
            text-align: left;
        }

        /* Progress bars met dynamische kleuren */
        .progress-bar {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            height: 25px;
            margin: 10px 0;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-inner {
            height: 100%;
            width: 50%; /* Dynamisch met PHP */
            background: linear-gradient(to right, #76c7c0, #4caf50);
            border-radius: 8px;
            animation: fillBar 1s ease-in-out;
            transition: width 0.5s ease-in-out, background-color 0.5s ease;
        }

        .progress-bar-inner.low {
            background: linear-gradient(to right, #ff4b5c, #ff7e5f);
        }

        .progress-bar-inner.medium {
            background: linear-gradient(to right, #ffc107, #ffecb3);
        }

        @keyframes fillBar {
            from { width: 0; }
            to { width: var(--width); }
        }

        /* Knoppenstijl */
        button {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 30px;
            margin: 10px;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        /* Hover-effect knoppen */
        button:hover {
            transform: scale(1.1) rotate(-2deg);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        button:active {
            transform: scale(0.9);
        }

        /* Game Over stijl */
        .game-over-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: #ff4b5c;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .game-over-overlay h2 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .game-over-overlay p {
            font-size: 1.5rem;
        }

        /* Responsieve stijl */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }

            button {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            .status {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <h1>FrietShip Battle</h1>

    <!-- Dynamisch statusoverzicht -->
    <div class="status">
        <h2>Status van de Schepen</h2>

        <!-- Frietje Oorlog Status -->
        <p><strong><?= $ship1->name ?>:</strong></p>
        <div class="progress-bar">
            <div class="progress-bar-inner <?= $ship1->hitPoints < 30 ? 'low' : ($ship1->hitPoints < 70 ? 'medium' : '') ?>" 
                 style="width: <?= $ship1->hitPoints ?>%;"></div>
        </div>
        <p>Ammo:</p>
        <div class="progress-bar">
            <div class="progress-bar-inner <?= $ship1->ammo < 30 ? 'low' : ($ship1->ammo < 70 ? 'medium' : '') ?>" 
                 style="width: <?= $ship1->ammo ?>%;"></div>
        </div>

        <!-- Frietje Zonder Status -->
        <p><strong><?= $ship2->name ?>:</strong></p>
        <div class="progress-bar">
            <div class="progress-bar-inner <?= $ship2->hitPoints < 30 ? 'low' : ($ship2->hitPoints < 70 ? 'medium' : '') ?>" 
                 style="width: <?= $ship2->hitPoints ?>%;"></div>
        </div>
        <p>Ammo:</p>
        <div class="progress-bar">
            <div class="progress-bar-inner <?= $ship2->ammo < 30 ? 'low' : ($ship2->ammo < 70 ? 'medium' : '') ?>" 
                 style="width: <?= $ship2->ammo ?>%;"></div>
        </div>
    </div>

    <!-- Actieknoppen -->
    <form method="post">
        <button type="submit" name="action" value="ship1_shoot">Frietje Oorlog Schiet</button>
        <button type="submit" name="action" value="ship2_shoot">Frietje Zonder Schiet</button>
        <br>
        <button type="submit" name="action" value="ship1_reload">Frietje Oorlog Herlaadt</button>
        <button type="submit" name="action" value="ship2_reload">Frietje Zonder Herlaadt</button>
        <br>
        <button type="submit" name="action" value="reset">Reset Spel</button>
    </form>

    <!-- Game Over -->
    <?php if (!$ship1->isAlive || !$ship2->isAlive): ?>
        <div class="game-over-overlay">
            <h2>Game Over!</h2>
            <p><?= !$ship1->isAlive ? $ship1->name . " is vernietigd!" : $ship2->name . " is vernietigd!" ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
