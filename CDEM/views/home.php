<?php $title = "CDEM.fun" ?>

<div id="container2">
  <input type="text" name="pseudo" id="pseudo" class="element" placeholder="PSEUDO" size="255" maxlength="15" value=<?php echo '"' . $username . '"' ?> onchange="javascript:isCharSet()"/>

  <div class="blocks">
    <a class="block create element" id="createB">
      <div class="plein">
        <p>Créer</p>
      </div>
      <div class="vide"></div>
    </a>

    <a class="block join element" id="joinB">
      <div class="plein">
        <p>Rejoindre</p>
      </div>
      <div class="vide"></div>
    </a>
  </div>
</div>

<?php $js = "<script src=\"public/js/home.js\"></script>" ?>
