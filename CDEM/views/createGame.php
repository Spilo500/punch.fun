<?php $title = "Créer une partie" ?>
<div class="myContainer">
  <form class="formCreate" action="create-room" method="POST">

    <div id="partyBlock">
      <h1>Création d'une partie</h1>

      <div class="choices">
        <div class="choice">
          <button class="buttonChoice" type="button" id="Privé" onclick="buttonClicked('Privé', 'create');">
            <p>Privé</p>
          </button>
          <button class="buttonChoice " type="button" id="Public" onclick="buttonClicked('Public', 'create');">
            <p>Public</p>
          </button>
        </div>
        <input type="hidden" id="hiddenBool" name="boolParty"></input>
        <div class="code choice">
          <p>Joueurs</p>
          <div class="Scrollbar">
            <input type="range" name="Players" min="3" max="10" value="6" class="slider" id="ScrollPlayers" oninput="ScrollValue('ScrollPlayers','ValuePlayers')" autocomplete="off">
            <p id="ValuePlayers" class="scrollValue">6</p>
          </div>
        </div>

        <div class="code choice">
          <p>Score</p>
          <div class="Scrollbar">
            <input name="Score" type="range" min="50" step="25" max="200" value="100" class="slider" id="ScrollScore" oninput="ScrollValue('ScrollScore','ValueScore')" autocomplete="off">
            <p id="ValueScore" class="scrollValue">100</p>
          </div>
        </div>
      </div>

    </div>

    <div class="buttons">
      <button class="button" type="button" name="button" onclick="window.location.href='/CDEM';">
        <p>Retour</p>
      </button>
      <button class="button" type="submit" name="button">
        <p>Créer</p>
      </button>
    </div>

  </form>
</div>
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js = "<script src=\"public/js/PartySettings.js\"></script>" ?>