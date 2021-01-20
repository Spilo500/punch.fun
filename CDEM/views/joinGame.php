<?php $title = "Rejoindre" ?>
<div class="myContainer">
  <form action="join-room" method="post" class="joinPage">
    <div id="partyBlock">

      <h1>Rejoindre une partie</h1>
      <h2 id="joinError"><?php if (isset($_SESSION['joinError']) and !empty($_SESSION['joinError'])) echo ($_SESSION['joinError']);
                          unset($_SESSION['joinError']); ?></h2>
      <div class="choices">
        <div class="choice">
          <button class="buttonChoice" type="button" id="Privé" onclick="buttonChange('private', 'join')">
            <p>Privé</p>
          </button>
          <button class="buttonChoice " type="button" id="Public" onclick="buttonChange('public', 'join')">
            <p>Public</p>
          </button>
        </div>
        <input type="hidden" id="hiddenBool" name="boolParty" value="Privé"></input>

        <div id="private" class="choice">
          <div class="code choice">
            <p>Code</p>
            <div class="inputBlock">
              <input type="text" name="code" id="codeJoin" size="6" placeholder="HXFEAS" maxlength="6" required />
            </div>
          </div>
        </div>

        <div id="public" class="hidden choice">
          <div class="code">
          </div>
          <div class="random">
            <a>Vous allez rejoindre une partie aléatoire</a>
          </div>
        </div>
      </div>

    </div>

    <div class="buttons">
      <button class="button" type="button" name="button" onclick="window.location.href='/CDEM';">
        <p>Retour</p>
      </button>
      <button class="button" type="submit" name="button">
        <p>Rejoindre</p>
      </button>
    </div>
  </form>
</div>
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js = "<script src=\"public/js/PartySettings.js\"></script>" ?>