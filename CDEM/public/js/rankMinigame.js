class RankMinigame {
    constructor() {
      this.body = document.querySelector('body');
      this.back = document.createElement("div");
      this.rankBox = document.createElement("div");
      this.title = document.createElement("h1");
      this.line = document.createElement("div");
  
  
      this.configuration();
      this.addToHtml();
      this.showAllPlayers();
    }
  
    showRank(){
      this.back.style.display = 'flex';
    }
    hideRank(){
      this.back.style.display = 'none';
    }
    configuration(){
      this.back.style.height = '100vh';
      this.back.style.width = '100vw';
      this.back.style.position = 'absolute';
      this.back.style.top = '0';
      this.back.style.left = '0';
      this.back.style.backgroundColor = 'rgba(0,0,0,0.8)';
      this.back.style.display = 'flex';
      this.back.style.justifyContent = 'center';
      this.back.style.alignItems = 'center';
  
      this.rankBox.style.width = '80%';
      this.rankBox.style.display = 'flex';
      this.rankBox.style.justifyContent = 'center';
      this.rankBox.style.alignItems = 'center';
      this.rankBox.style.flexDirection = 'column';
  
      this.title.innerHTML = 'Attribution des points';
      this.title.style.color = '#ffffff';
      this.title.style.fontFamily = 'Montserrat, "segoe UI"';
      this.title.style.fontWeight = 'bold';
      this.title.style.fontSize = '3.5em';
  
      this.line.style.height = '0.5em';
      this.line.style.width = '100%';
      this.line.style.backgroundColor = '#ffffff';
      this.line.style.borderRadius = '100em';
      this.line.style.marginBottom = '3em';
  
  
    }
    addToHtml(){
      this.body.appendChild(this.back);
      this.back.appendChild(this.rankBox);
      this.rankBox.appendChild(this.title);
      this.rankBox.appendChild(this.line);
    }
    showAllPlayers(){
      for (var i = 0; i < 10; i++) {
        let scoreContainer = document.createElement("div");
        let position = document.createElement("p");
        let username = document.createElement("p");
        let score = document.createElement("p");
  
        switch (i) {
          case 0:
            score.innerHTML = '+ 5';
            position.innerHTML = (String(i + 1) + " st");
            break;
          case 1:
            score.innerHTML = '+ 3';
            position.innerHTML = (String(i + 1) + " nd");
            break;
          case 2:
            score.innerHTML = '+ 1';
            position.innerHTML = (String(i + 1) + " rd");
            break;
          default:
            score.innerHTML = '+ 0';
            position.innerHTML = (String(i + 1) + " th");
  
        }
  
        scoreContainer.style.width = '100%';
        scoreContainer.style.display = 'flex';
        scoreContainer.style.alignItems = 'center';
        scoreContainer.style.justifyContent = 'center';
        score.style.margin = '1em 0';
  
        username.innerHTML = 'Marodo';
        username.style.color = '#ffffff';
        username.style.fontFamily = 'Montserrat, "segoe UI"';
        username.style.fontWeight = 'bold';
        username.style.fontSize = '3em';
        username.style.margin = '0 3em';
        position.style.textAlign = 'center';
  
        score.style.color = '#ffffff';
        score.style.fontFamily = 'Montserrat, "segoe UI"';
        score.style.fontWeight = 'bold';
        score.style.fontSize = '3em';
        score.style.margin = '0 0';
        score.style.width = '3em';
  
        position.style.color = '#ffffff';
        position.style.fontFamily = 'Montserrat, "segoe UI"';
        position.style.fontWeight = 'bold';
        position.style.fontSize = '3em';
        position.style.margin = '0 0';
        position.style.width = '3em';
        position.style.textAlign = 'left';
  
  
        this.rankBox.appendChild(scoreContainer);
        scoreContainer.appendChild(position);
        scoreContainer.appendChild(username);
        scoreContainer.appendChild(score);
      }
    }
  }