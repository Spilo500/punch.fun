class Spammer{

  constructor() {
    this.loop;
    this.body = document.querySelector(".gameContainer");
    this.container = document.createElement("div");
    this.h1 = document.createElement("h1");
    this.progressBar = document.createElement("progress");
    this.clickContainer = document.createElement("button");
    this.size = 10;
    this.diminue = true;

    this.description();
    let that = this;
    setTimeout(function(){
      that.configuration();
      that.addToHtml();
      that.move();
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

    this.h1.innerHTML = "Appuyez sur le carré rouge<br>aussi vite que possible";
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

    this.progressBar.max = 80;
    this.progressBar.value = 0;
    this.progressBar.style.height = "5em";
    this.progressBar.style.width = "70%";

    this.h1.style.color = "#000000";
    this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.h1.innerHTML = "Clique clique clique !!!"
    this.h1.style.textTransform = "uppercase";
    this.h1.style.paddingBottom = "1em";

    this.clickContainer.style.height = "10em";
    this.clickContainer.style.width = "10em";
    this.clickContainer.style.border = "none";
    this.clickContainer.style.borderRadius = "1em";
    this.clickContainer.style.backgroundColor = "#f44";
    this.clickContainer.style.margin = "0em";
    this.clickContainer.setAttribute("onClick", "gameManager.miniGame.clicked()");
    this.clickContainer.setAttribute("draggable", "false");
    this.clickContainer.style.outline = "none";
  }

  addToHtml(){
    this.body.appendChild(this.container);
    this.container.appendChild(this.h1);
    this.container.appendChild(this.progressBar);
    this.container.appendChild(this.clickContainer);
  }

  playAudio(src, volume){
    let audio = new Audio();
    audio.src = src;
    volume = parseInt(volume) / 50;
    audio.volume = String(volume);
    audio.play();
  }

  clicked(){
    this.progressBar.value += 1;
    this.playAudio("public/audio/point.wav", "2");
    if (this.progressBar.value==this.progressBar.max) {
      this.finish();
    }
  }

  changeSize(){
    if (this.diminue) {
      if (this.size > 2) {
        this.size -= 0.1;
        this.clickContainer.style.height = ("calc(" + this.clickContainer.style.height + " - 0.1em)");
        this.clickContainer.style.width = ("calc(" + this.clickContainer.style.width + " - 0.1em)");
        this.clickContainer.style.margin = ("calc(" + this.clickContainer.style.margin + " + 0.05em)");
      }
      else {
        this.diminue = false;
      }
    }else {
        if (this.size < 10) {
          this.size += 0.1;
          this.clickContainer.style.height = ("calc(" + this.clickContainer.style.height + " + 0.1em)");
          this.clickContainer.style.width = ("calc(" + this.clickContainer.style.width + " + 0.1em)");
          this.clickContainer.style.margin = ("calc(" + this.clickContainer.style.margin + " - 0.05em)");
        }
        else {
          this.diminue = true;
        }
    }
  }

  move(){
    let that = this;
    this.loop = setInterval(function(){
      that.changeSize();
    }, 100);
  }

  finish(){
    clearInterval(this.loop);
    gameManager.endGame();
  }
}