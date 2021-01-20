class Clicker{

    constructor(){
      this.time = 0;
      this.body = document.querySelector(".gameContainer");
      this.container = document.createElement("div");
      this.progressBar = document.createElement("progress");
      this.keyContainer = document.createElement("div");
      this.h1 = document.createElement("h1");
      this.touches = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
      this.touche = this.touches[4];
      this.cpt = 1;
  
      this.description();
      let that = this;
      setTimeout(function(){
        that.configuration();
        that.addToHtml();
        that.awaitKeyPressed();
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
  
      this.h1.innerHTML = "Appuyez sur la touche de<br>votre clavier correspondante";
      this.h1.style.color = "#777bff";
      this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
      this.h1.style.textTransform = "uppercase";
      this.h1.style.textAlign = "center";
      this.h1.style.fontSize = "2em";
  
      this.body.appendChild(this.container);
      this.container.appendChild(this.h1);
    }
  
    configuration(){
      this.container.remove();
      this.h1.remove();
  
      this.container.style.height = "100%";
      this.container.style.width = "100%";
      this.container.style.display = "flex";
      this.container.style.justifyContent = "center";
      this.container.style.alignItems = "center";
      this.container.style.flexDirection = "column";
  
      this.progressBar.max = 20;
      this.progressBar.value = 0;
      this.progressBar.style.height = "5em";
      this.progressBar.style.width = "70%";
  
  
      this.keyContainer.style.height = "10em";
      this.keyContainer.style.width = "10em";
      this.keyContainer.style.display = "flex";
      this.keyContainer.style.justifyContent = "center";
      this.keyContainer.style.alignItems = "center";
      this.keyContainer.style.backgroundColor = "#e74c3c";
      this.keyContainer.style.borderRadius = "2em";
      this.keyContainer.style.marginBottom = "2em";
  
      this.h1.style.color = "#ffffff";
      this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
      this.h1.innerHTML = "e"
      this.h1.style.textTransform = "uppercase";
      this.h1.style.fontSize = "4em";
    }
  
    addToHtml(){
      this.body.appendChild(this.container);
      this.container.appendChild(this.keyContainer);
      this.keyContainer.appendChild(this.h1);
      this.container.appendChild(this.progressBar);
    }
  
    getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    }
  
    awaitKeyPressed(){
      let that = this;
      document.addEventListener('keydown', function pressKey(e){
          console.log(e);
          if (e.key == that.touche) {
            that.progressBar.value += 1;
            that.touche = that.touches[that.getRandomInt(that.touches.length)];
            that.h1.innerHTML = that.touche;
  
            if (that.progressBar.value == that.progressBar.max){
              document.removeEventListener("keydown", pressKey);
              that.finish();
            }
          }
          else {
            that.progressBar.value -= 1;
            that.touche = that.touches[that.getRandomInt(that.touches.length)];
            that.h1.innerHTML = that.touche;
          }
      });
    }
    finish(){
      gameManager.endGame();
    }
  }