function updateMultiplication() {
    $.ajax({
        method: "GET",
        url: "http://multiplygame.as/server.php",
        data: {'update': 1},
        cache: false,
        dataType: 'json'
    }).done(function (response) {

        let a = response.a;
        let b = response.b;

        $("#facteur-a").text(a);
        $("#facteur-b").text(b);
    });
}

function majTentatives() {
    let pseudo = $("#user").val();
    $.ajax({
        method: "GET",
        url: "http://multiplygame.as/server.php",
        data: {'all': 1, 'pseudo': pseudo},
        dataType: 'json'
    }).done(function (data) {
        $('#tentatives-body').empty();
        data.forEach(function (ligne) {
            $("#tentatives-body").append(
                `<tr>`
                + `<td>${ligne.id}</td>`
                + `<td>${ligne.operation}</td>`
                + `<td>${ligne.reponse}</td>`
                + '<td>' + (Number(ligne.statut) === 1 ? 'OUI' : 'NON') + '</td>'
                + '</tr>');
        });
    });
}

function tentative() {
    let reponse = $("#tentative").val();
    let pseudo = $("#user").val();

    let saisieValide = (reponse !== null) && (reponse.trim() !== '') && Number.isInteger(reponse * 1);

    if (!saisieValide) {
        $("#msgTentative").empty();
        $("#msgTentative").append(
            "Saisie invalide, un entier est attendu"
        );
        $("#tentative").val('');
    } else {
        $("#msgTentative").empty();
        let a = $("#facteur-a").text();
        let b = $("#facteur-b").text();
        let statut = Number(reponse) === (a * b);

        let donnee = {
            tentative: 1,
            operation: `${a} x ${b}`,
            reponse: reponse,
            statut: statut,
            pseudo: pseudo
        };

        $.ajax({
            method: "POST",
            url: "http://multiplygame.as/server.php",
            data: donnee
        }).done(function (response) {
            if (statut) {
                $('.message-resulat').empty().append('Le resultat est correct : FELICITATION');
                $('#msgReponse')
                    .removeClass()
                    .addClass("alert alert-success");
            } else {
                $('.message-resulat').empty().append('Oups, le resultat est incorrect : REESSAYER');
                $('#msgReponse')
                    .removeClass()
                    .addClass("alert alert-danger");
            }
            $("#tentative").val('');
        });
    }
}

$(document).ready(function () {

    updateMultiplication();

    $(".tentative-form").on('submit', function (event) {
        event.preventDefault();
    });

    $("#submit-tentative").on('click', function () {
        tentative();
        updateMultiplication();
        majTentatives();
    });
});

