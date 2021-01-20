let input = document.getElementById('pseudo');
let create = document.getElementById('createB');
let join = document.getElementById('joinB');

create.href = "delete-username";
join.href = "delete-username";

function isCharSet() {

    if (input.value.trim() != "") {
        create.href = 'create-game/' + document.getElementById('pseudo').value;
        join.href = 'join-game/' + document.getElementById('pseudo').value;
    } else {
        create.href = "delete-username";
        join.href = "delete-username";
    }
}

window.addEventListener("load", function () {
    isCharSet();
});