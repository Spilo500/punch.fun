<?php $title = 'CDEM.fun' ?>
<div class="gameContainer" style="height: 80vh; width:90%;background-color:#fff;border-radius:3em;box-shadow:rgba(0,0,0,0.3) 0 0.6em 0">

</div>

<!--  Pages specials  -->
<script src="public/js/rank.js"></script>
<script src="public/js/rankMinigame.js"></script>
<!--<script src="public/js/endScreen.js"></script> -->
<script src="public/js/waiting.js"></script>

<!--  Mini Jeux  -->
<script src="public/js/taupe.js"></script>
<script src="public/js/spammer.js"></script>
<script src="public/js/clicker.js"></script>
<script src="public/js/calculation.js"></script>

<!--  Manager de partie  -->
<script src="public/js/gameManager.js"></script>

<script type="text/javascript">
    document.getElementById("connect").innerHTML = "<a> Code : " + "<?= $data['code'] ?>" + "</a>";
    document.getElementById("connect").classList.remove("connectHover");
    gameManager = new GameManager();

    //Cherche ou définis le mini-jeu
    var reqPlayer = new XMLHttpRequest();
    reqPlayer.onreadystatechange = function() {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            var players = JSON.parse(reqPlayer.responseText);
            var exist = false;

            for (var i = 0; i < players.length; i++) {
                if (players[i]["username"] + players[i]["idPlayer"] == "<?= $_SESSION["username"] ?>" + "<?= $_SESSION['idPlayer'] ?>") {
                    if (players[i]["isHost"] == 1) {
                        //création du mini-jeu
                        exist = true;
                        reqMG = new XMLHttpRequest();
                        reqMG.onreadystatechange = function() {
                            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                                var minigame = JSON.parse(reqMG.responseText);

                                reqNum = new XMLHttpRequest();
                                reqNum.onreadystatechange = function() {
                                    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                                        var numMG = reqNum.responseText;

                                        reqPlayMG = new XMLHttpRequest();
                                        reqPlayMG.onreadystatechange = function() {
                                            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                                                console.log(minigame);
                                                gameManager.startGame(minigame['name']);
                                            }
                                        }

                                        reqPlayMG.open("POST", "play-minigame/<?= $data['code'] ?>/" + minigame['idMinigame'] + "/" + numMG);
                                        reqPlayMG.send();
                                    }
                                }
                                reqNum.open("GET", "up-minigame/<?= $data['code'] ?>/" + minigame['idMinigame']);
                                reqNum.send();
                            }
                        }

                        reqMG.open("GET", "get-minigame");
                        reqMG.send();
                    }
                }
            }

            if (!exist) {
                reqGetNum = new XMLHttpRequest();
                reqGetNum.onreadystatechange = function() {
                    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                        console.log(reqGetNum.responseText);
                        var minigame = JSON.parse(reqGetNum.responseText);
                        if (minigame['name'] == 404) {
                            reqGetNum.open("GET", "current-minigame/<?= $data['code'] ?>");
                            reqGetNum.send();
                        } else {
                            gameManager.startGame(minigame['name']);
                        }
                    }
                }

                reqGetNum.open("GET", "current-minigame/<?= $data['code'] ?>");
                reqGetNum.send();
            }

        }
    }

    reqPlayer.open("GET", "get-players/<?= $data['code'] ?>");
    reqPlayer.send();
</script>
<?php $css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />" ?>
<?php $js = "<script src=\"public/js/PartySettings.js\"></script>" ?>