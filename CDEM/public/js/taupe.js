class Taupe{

  constructor() {
    this.loop;
    this.isRunning = true;
    this.taupeActive = new Map();
    this.body = document.querySelector(".gameContainer");
    this.container = document.createElement("div");
    this.h1 = document.createElement("h1");
    this.progressBar = document.createElement("progress");
    this.taupeContainer = document.createElement("div");

    this.description();
    let that = this;
    setTimeout(function(){
      that.configuration();
      that.addToHtml();
      that.createTaupe();

      that.allumerTaupe();
      that.allumerTaupe();
    }, 5000);
  }

  description(){
    this.container = document.createElement("div");
    this.h1 = document.createElement("h1");

    this.container.style.height = "100%";
    this.container.style.width = "100%";
    this.container.style.display = "flex";
    this.container.style.justifyContent = "center";
    this.container.style.alignItems = "center";

    this.h1.innerHTML = "Chassez les vilaines taupes !<br>Cliquez sur les boutons rouges<br>avant qu'ils ne disparaissent";
    this.h1.style.color = "#777bff";
    this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.h1.style.textTransform = "uppercase";
    this.h1.style.textAlign = "center";

    this.body.appendChild(this.container);
    this.container.appendChild(this.h1);
  }

  configuration(){
    this.container.style.height = "100%";
    this.container.style.width = "100%";
    this.container.style.display = "flex";
    this.container.style.justifyContent = "center";
    this.container.style.alignItems = "center";
    this.container.style.flexDirection = "column";

    this.progressBar.max = 40;
    this.progressBar.value = 0;
    this.progressBar.style.height = "5em";
    this.progressBar.style.width = "70%";

    this.h1.style.color = "#000000";
    this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.h1.innerHTML = "Le jeu de la taupe !"
    this.h1.style.textTransform = "uppercase";
    this.h1.style.paddingBottom = "1em";

    this.taupeContainer.style.height = "100%";
    this.taupeContainer.style.width = "100%";
    this.taupeContainer.style.display = "flex";
    this.taupeContainer.style.justifyContent = "center";
    this.taupeContainer.style.alignItems = "center";
    this.taupeContainer.style.flexDirection = "row";
    this.taupeContainer.style.flexWrap = "wrap";
  }

  addToHtml(){
    this.body.appendChild(this.container);
    this.container.appendChild(this.h1);
    this.container.appendChild(this.progressBar);
    this.container.appendChild(this.taupeContainer);
  }

  createTaupe(){
    for (var i = 0; i < 9; i++) {
      let taupe = document.createElement("button");

      taupe.setAttribute("id", "taupe-"+i);
      taupe.style.height = "10em";
      taupe.style.width = "20%";
      taupe.style.backgroundColor = "#f44";
      taupe.style.opacity = "0.2";
      taupe.style.border = "none";
      taupe.style.borderRadius = "1em";
      taupe.style.transition = "ease-in-out 100ms";
      taupe.setAttribute("onmousedown", "gameManager.miniGame.clicked(this)");
      taupe.style.margin = "0 4em";
      taupe.setAttribute("draggable", "false");
      taupe.style.outline = "none";

      this.taupeContainer.appendChild(taupe);
      this.taupeActive.set(taupe.getAttribute("id"), false);
    }
  }

  getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
  }

  eteindreTaupe(button){
    this.taupeActive.set(button.getAttribute("id"), false);
    button.style.opacity = "0.2";
    this.allumerTaupe();
  }

  allumerTaupe(){
    let nbTaupe
    do {
      nbTaupe = this.getRandomInt(9);
    } while (this.taupeActive.get("taupe-" + nbTaupe));
    let button = document.getElementById("taupe-"+nbTaupe);
    this.taupeActive.set(button.getAttribute("id"), true);
    button.style.opacity = "1";
    button.style.backgroundColor = "#f44";
    this.lifeTime(button);
  }

  lifeTime(button){
    let that = this;
    this.loop = setTimeout(() => {
      if (that.taupeActive.get(button.getAttribute("id")) && this.isRunning) {
        that.eteindreTaupe(button)
    }}, 700);
  }

  playAudio(src, volume){
    let audio = new Audio();
    audio.src = src;
    volume = parseInt(volume) / 100;
    audio.volume = String(volume);
    audio.play();
  }

  clicked(button){
    if (this.taupeActive.get(button.getAttribute("id"))) {
      this.progressBar.value += 1;
      button.style.backgroundColor = "#55efc4";
      this.eteindreTaupe(button);
      this.playAudio("public/audio/point.wav", "20");
      if (this.progressBar.value == this.progressBar.max) {
        this.finish();
      }
    }
  }

  finish(){
    this.isRunning = false;
    clearTimeout(this.loop);
    gameManager.endGame();
  }
}