<?php $title = 'Salle d\'attente' ?>
<div class="myContainer">
    <form id="myForm" action="game" method="post" class="formCreate">
        <input type="hidden" name="code" value="<?= $data['code'] ?>"></input>
        <div id="partyBlock">
            <h1>En attente de joueurs...</h1>
            <h2 id="nbPlayerText"></h2>
            <div id="waitContainer">

            </div>
        </div>

        <div class="buttons">
            <button class="button" type="button" name="button" onclick="window.location.href='/CDEM';">
                <p>Retour</p>
            </button>
            <button class="button" type="submit" name="button">
                <p id="actionGame"></p>
            </button>
        </div>
    </form>
</div>
<?php
$css = "<link href=\"public/css/game.css\" rel=\"stylesheet\" />";
?>


<script>
    var myData = function() {};
    myData.init = function() {
        // dans le $data du contrôleurs sont passées 3 index :
        // - maxUsers : Nombre d'utilisateurs maximum attendus
        // - code : code de la session
        // - users : le tableau des utilisateurs actuellement connectés

        this.nbMaxPlayers = <?= $data['nbMaxPlayers'] ?>; //Nombre maximum de joueurs
        this.get();
    };
    myData.get = function() {

        var reqPlayer = new XMLHttpRequest();
        reqPlayer.onreadystatechange = function() {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                var tempData = JSON.parse(reqPlayer.responseText);
                // Vérifier qu'il n'y a pas de users qui ont disparus dans myData.users
                // -- si c'est le cas, les supprimer de myData.users ET supprimer les éléments du DOM qui les concernents
                // Remplacer myData.users par tempData

                for (var i = 0; i < myData.nbUsers; i++) {
                    var id = myData.users[i]["username"] + myData.users[i]["idPlayer"];
                    var exist = false;
                    for (var j = 0; j < tempData.length; j++) {
                        if (tempData[j]["username"] + tempData[j]["idPlayer"] == id && myData.users[i]["isHost"] == tempData[j]["isHost"]) {
                            exist = true;
                        }
                    }
                    if (!exist) {
                        document.getElementById(id).remove();
                    }
                }

                myData.users = tempData;
                myData.nbUsers = myData.users.length;
                // lancer myData.draw
                myData.draw();
                if (parseInt(myData.nbUsers) <= parseInt(myData.nbMaxPlayers)) {
                    var reqStarted = new XMLHttpRequest();
                    reqStarted.onreadystatechange = function() {
                        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                            var inProgress = reqStarted.responseText;
                            if (parseInt(inProgress) == 1) {
                                document.getElementById("myForm").submit();
                            } else {
                                setTimeout(myData.get(), 1000);
                            }
                        }
                    }

                    reqStarted.open("GET", "in-progress/<?= $data['code'] ?>");
                    reqStarted.send();
                }
            }
        };
        reqPlayer.open("GET", "get-players/<?= $data['code'] ?>");
        reqPlayer.send();

    };
    myData.draw = function() {
        // vérifier si l'élément du DOM existe déjà
        // si oui, on ne fait rien
        // si non, on crée le nouvel élément du DOM
        var Container = document.getElementById("waitContainer");
        var idPlayer = "<?= $_SESSION["idPlayer"] ?>";

        document.getElementById('nbPlayerText').textContent = this.nbUsers + "/" + this.nbMaxPlayers;

        for (var i = 0; i < this.nbUsers; i++) {
            var id = myData.users[i]["username"] + myData.users[i]["idPlayer"];
            if (!document.getElementById(id)) {
                var newDiv = document.createElement("div");
                newDiv.className = "element";

                if (myData.users[i]["isHost"] == 1) {
                    newDiv.classList.add("king");

                    newDiv.style.position = "relative";
                    var couronne = document.createElement("img");
                    couronne.classList.add("couronne");
                    couronne.setAttribute("src", "public/pictures/couronne.png");
                    newDiv.appendChild(couronne);
                }

                newDiv.id = id;

                var pic = document.createElement("p");
                pic.classList.add("cdem");
                pic.textContent = "CDEM.fun";
                var Pseudo = document.createElement("div");

                Pseudo.className = "vs";
                Pseudo.innerHTML = myData.users[i]["username"];
                newDiv.appendChild(pic);
                newDiv.appendChild(Pseudo);
                Container.appendChild(newDiv);
            }

            if (myData.users[i]["isHost"] == 1 && idPlayer == myData.users[i]["idPlayer"]) {
                document.getElementById("actionGame").innerHTML = "Lancer la partie";
                if (parseInt(myData.nbUsers) >= 3) {
                    document.getElementById("actionGame").parentElement.disabled = false;
                    document.getElementById("actionGame").parentElement.classList.remove("stopHover");
                } else {
                    document.getElementById("actionGame").parentElement.disabled = true;
                    document.getElementById("actionGame").parentElement.classList.add("stopHover");
                }
            }
        }
    };

    $(document).ready(function() {
        var actionGame = document.getElementById("actionGame");
        actionGame.innerHTML = "En attente de l'hôte";
        actionGame.parentElement.disabled = true;
        actionGame.parentElement.classList.add("stopHover");

        document.getElementById("connect").innerHTML = "<a> Code : " + "<?= $data['code'] ?>" + "</a>";
        document.getElementById("connect").classList.remove("connectHover");

        /*window.addEventListener('beforeunload', function(event) {
            if (myData.nbUsers <= 1) {
                var reqDelete = new XMLHttpRequest();
                reqDelete.open("POST", "delete-game/<?= $data['code'] ?>");
                reqDelete.send();
            } else {
                for (var i = 0; i < myData.nbUsers; i++) {
                    if (myData.users[i]["isHost"] == 1 && '<?= $_SESSION["idPlayer"] ?>' == myData.users[i]["idPlayer"]) {
                        var reqHost = new XMLHttpRequest();
                        reqHost.open("POST", "new-host/<?= $data['code'] ?>");
                        reqHost.send();
                        break;
                    }
                }
            }

            var reqLeave = new XMLHttpRequest();
            reqLeave.open("POST", "delete-player/<?= $_SESSION["idPlayer"] ?>/<?= $data['code'] ?>");
            reqLeave.send();
        });*/

        myData.init();
    });
</script>