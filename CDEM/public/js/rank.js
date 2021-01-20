class Rank {
    constructor() {
      this.body = document.querySelector('body');
      this.back = document.createElement("div");
      this.rankBox = document.createElement("div");
      this.title = document.createElement("h1");
      this.line = document.createElement("div");
  
  
      this.configuration();
      this.addToHtml();
      this.showAllPlayers();
      this.hideRank();
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
  
      this.title.innerHTML = 'Classement';
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
        let progress = document.createElement("progress");
        let playerStats = document.createElement("div");
        let username = document.createElement("p");
        let score = document.createElement("p");
  
        scoreContainer.style.width = '100%';
        scoreContainer.style.display = 'flex';
        scoreContainer.style.alignItems = 'center';
        score.style.margin = '1em 0';
  
        progress.style.height = '3em';
        progress.style.width = '70%';
        progress.style.decoration = 'none';
        progress.max = '100';
        progress.value = '50';
  
        playerStats.style.width = '30%';
        playerStats.style.display = 'flex';
        playerStats.style.alignItems = 'center';
        playerStats.style.justifyContent = 'space-between';
        playerStats.style.marginLeft = '5em';
  
        username.innerHTML = 'Marodo';
        username.style.color = '#ffffff';
        username.style.fontFamily = 'Montserrat, "segoe UI"';
        username.style.fontWeight = 'bold';
        username.style.fontSize = '3em';
        username.style.margin = '0 0';
  
        score.innerHTML = '100';
        score.style.color = '#ffffff';
        score.style.fontFamily = 'Montserrat, "segoe UI"';
        score.style.fontWeight = 'bold';
        score.style.fontSize = '3em';
        score.style.margin = '0 0';
  
  
        this.rankBox.appendChild(scoreContainer);
        scoreContainer.appendChild(progress);
        scoreContainer.appendChild(playerStats);
        playerStats.appendChild(username);
        playerStats.appendChild(score);
      }
    }
  }