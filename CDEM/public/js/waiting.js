class Waiting {
    constructor() {
      this.body = document.querySelector(".gameContainer");
      this.container = document.createElement("div");
      this.h1 = document.createElement("h1");
      this.loading = document.createElement("img");
  
      this.configuration();
    }
  
    configuration(){
      this.container.style.height = "100%";
      this.container.style.width = "100%";
      this.container.style.display = "flex";
      this.container.style.justifyContent = "center";
      this.container.style.alignItems = "center";
      this.container.style.flexDirection = "column";
  
      this.h1.style.color = "#000000";
      this.h1.style.fontFamily = "Montserrat, 'Segoe ui'";
      this.h1.innerHTML = "T'es trop rapide pour eux,<br>sûr tu vas finir premier."
      this.h1.style.textTransform = "uppercase";
      this.h1.style.paddingBottom = "1em";
      this.h1.style.textAlign = "center";
  
      this.loading.setAttribute("src", "public/pictures/loading.gif");
      this.loading.style.height = "20em";
      this.loading.style.width = "auto";
      this.loading.setAttribute("draggable", "false");
    }
  
    startWaiting(){
      this.body.appendChild(this.container);
      this.container.appendChild(this.h1);
      this.container.appendChild(this.loading);
    }
  }