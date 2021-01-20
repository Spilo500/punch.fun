<?php $title = "Mot de passe oublié ?" ?>

<div class="connectBlocks">
  <div class="connectblock">
    <div class="connectForm">
      <h1>Mot de passe oublié ?</h1>
      <h2>Nous allons vous envoyer un email afin de réinitialiser votre mot de passe.</h2>
      <div class="inputBlocks">
        <div class="inputBlock">
          <h2>Email</h2>
          <input type="text" name="email" id="emailIns" class="element" placeholder="Votre Email" maxlength="255" />
        </div>
      </div>
    </div>

    <button class="button" type="button" name="buttonIns">
      <p>ENVOYER</p>
    </button>
  </div>
</div>

<?php $css = "<link href=\"public/css/connexion.css?v=<?php echo time(); ?>\" rel=\"stylesheet\" />" ?>
