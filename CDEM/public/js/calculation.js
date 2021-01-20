class Calculation{

  constructor() {
    this.canCheck = true;
    this.loop;
    this.nombre1;
    this.nombre2;
    this.nombre3;
    this.symbol = ["+", "-"];
    this.result;
    this.body = document.querySelector(".gameContainer");
    this.container = document.createElement("div");
    this.h1 = document.createElement("h1");
    this.progressBar = document.createElement("progress");
    this.input = document.createElement("input");
    this.confirm = document.createElement("button");

    this.description();
    let that = this;
    setTimeout(function(){
      that.configuration();
      that.addToHtml();
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

    this.h1.innerHTML = "Rentrez le résultat pour chaque calcul,<br>faites chauffer vos méninges !";
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

    this.progressBar.max = 5;
    this.progressBar.value = 0;
    this.progressBar.style.height = "5em";
    this.progressBar.style.width = "70%";
    this.progressBar.style.marginBottom = "2em";

    this.h1.style.color = "#000000";
    this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.h1.style.textTransform = "uppercase";
    this.h1.innerHTML = this.generateEquation();

    this.input.style.height = "2em";
    this.input.setAttribute("type", "number");
    this.input.style.width = "10em";
    this.input.style.border = "solid #777bff 0.4em";
    this.input.style.borderRadius = "10em";
    this.input.style.backgroundColor = "#fff";
    this.input.style.color = "#000";
    this.input.style.fontSize = "2em";
    this.input.style.textAlign = "center";
    this.input.style.marginBottom = "1em";
    this.input.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.input.style.textTransform = "uppercase";

    this.confirm.style.color = "#ffffff";
    this.confirm.style.fontSize = "2em";
    this.confirm.style.fontFamily = "Montserrat, 'Segoe ui'";
    this.confirm.style.textTransform = "uppercase";
    this.confirm.innerHTML = "Valider";
    this.confirm.style.padding = "0.5em 1em";
    this.confirm.style.border = "none";
    this.confirm.style.borderRadius = "10em";
    this.confirm.style.backgroundColor = "#2ecc71";
    this.confirm.style.margin = "0em";
    this.confirm.setAttribute("onClick", "gameManager.miniGame.clicked()");
    this.confirm.setAttribute("draggable", "false");
    this.confirm.style.outline = "none";
  }
  addToHtml(){
    this.body.appendChild(this.container);
    this.container.appendChild(this.h1);
    this.container.appendChild(this.progressBar);
    this.container.appendChild(this.input);
    this.container.appendChild(this.confirm);
  }

  getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
  }

  generateEquation(){
    let symbole1 = this.getRandomInt(2);
    let symbole2 = this.getRandomInt(2);
    this.nombre1 = this.getRandomInt(99);
    this.nombre2 = this.getRandomInt(99);
    this.nombre3 = this.getRandomInt(99);
    let equation;

    switch (this.symbol[symbole1]) {
      case "+":
        this.result = (this.nombre1 + this.nombre2);
        equation = (this.nombre1 + " + " + this.nombre2);
        break;
      case "-":
        this.result = (this.nombre1 - this.nombre2);
        equation = (this.nombre1 + " - " + this.nombre2);
        break;
    }
    switch (this.symbol[symbole2]) {
      case "+":
        this.result += this.nombre3;
        equation += (" + " + this.nombre3);
        break;
      case "-":
      this.result -= this.nombre3;
      equation += (" - " + this.nombre3);
        break;
    }
    console.log(this.result);
    return equation;
  }

  checkResult(){
    if (this.canCheck) {
      if(this.input.value == this.result){
        this.progressBar.value += 1;
        this.h1.innerHTML = this.generateEquation();
        if (this.progressBar.value == this.progressBar.max) {
          this.finish()
        }
      }
      else {
        this.malus();
      }
    }
  }

  malus(){
    this.canCheck = false;
    this.h1.innerHTML = "Concentre toi bon sang !!";
    let that = this;
    setTimeout(function(){
      that.canCheck = true;
      that.h1.innerHTML = that.generateEquation();
    }, 2000);
  }

  clicked(){
    this.checkResult();
    this.input.value = "";
  }

  finish(){
    gameManager.endGame();
  }
}