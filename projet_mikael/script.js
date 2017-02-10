/**
 * Created by Michael on 17/01/2017.
 */

$(document).ready(function() {
    $("#formulaire").submit( function() {
        /*alert("submit");
        alert($('#poid_prix').val());
        alert($('#poid_distance').val());
        alert($('#poid_nbEt').val());
        alert($('#level_prix').val());
        alert($('#level_distance').val());
        alert($('#level_nbEt').val());*/
        var poid_prix = $('#poid_prix').val();
        var poid_distance = $('#poid_distance').val();
        var poid_nbEt = $('#poid_nbEt').val();
        var level_prix = $('#level_prix').val();
        var level_distance = $('#level_distance').val();
        var level_nbEt = $('#level_nbEt').val();

        $.post(
            'traitement.php',
            {
                poid_prix: poid_prix,
                poid_distance: poid_distance,
                poid_nbEt: poid_nbEt,
                level_prix: level_prix,
                level_distance: level_distance,
                level_nbEt: level_nbEt
            },
            function(data){
                if(data) {
                    console.log(data);
                    // reparser nos données au format JSON
                    var dataParse = JSON.parse(data);
                    displayTable(dataParse);
                } else {
                    alert("erreur traitement");
                }
            }
        );
    return false;
    });


    function displayTable(data) {
        if(data) {
            $(".content-results").append("<table id=\"table-results\" class=\"table table-hover\"></table>");

            $("#table-results").append("<thead></thead>");

            $('#table-results > thead:last-child').append('<tr><td>Id</td>' +
                '<td>Prix</td>' +
                '<td>Distance</td>' +
                '<td>NbEt</td>' +
                '<td>Score</td></tr>');

            $("#table-results").append("<tbody></tbody>");

            $.each(data , function( key, value ) {

                $('#table-results > tbody:last-child').append('<tr><td>' + value.id + '</td>' +
                    '<td>' + value.prix + '</td>' +
                    '<td>' + value.distance + '</td>' +
                    '<td>' + value.nbEt + '</td>' +
                    '<td>' + value.score + '</td></tr>');

            });

        } else {
            $(".content-results").append("<p>Désolé, aucun résultat ne correspond avec demande.</p>")
        }
    }
});


