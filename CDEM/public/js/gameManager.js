class GameManager {

  constructor() {
    this.games = ["Spammer", "Taupe"];
    this.miniGame;
    this.rank = new Rank();
    this.rankMinigame = new RankMinigame();
    this.waiting = new Waiting();
    this.rank.hideRank();
    this.rankMinigame.hideRank();
  }

  //Lance un minijeu
  startGame(game) {
    switch (game) {
      case "Spammer": this.miniGame = new Spammer(); break;
      case "Taupe": this.miniGame = new Taupe(); break;
      case "Calculation": this.miniGame = new Calculation(); break;
      case "Clicker": this.miniGame = new Clicker(); break;
    }
  }

  //Nettoie la zone de jeu
  clearContainer() {
    let container = document.querySelector(".gameContainer").childNodes;
    for (var i = 1; i < container.length; i++) {
      container[i].remove();
    }
  }

  //Termine un miniJeu la zone de jeu
  endGame() {
    this.clearContainer();
    this.waiting.startWaiting();
    //this.checkAllFinished();  //verifie que tous les joueurs ont FINIT le miniJeu
    this.rankMinigame.showRank();
    //this.rankMinigame.hideRank();
    //this.rank.showRank();
    //this.rank.hideRank();
    //this.relaunchGame();  //verifie que: aucun JOUEURS n'a atteint le SCOREMAX, si ce n'est pas le cas on lance le prochain MINIJEU, sinon on lance un écran de FIN.

    //this.startGame();
  }

  //Verifie que tous les joueurs ont finit
  checkAllFinished() {
    let bool;

    return bool;
  }
}