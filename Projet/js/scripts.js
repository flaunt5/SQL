/**
 * Created by root on 10/02/17.
 */

$(function() {
    $("#formSubmit").on("click", function (e) {
        e.preventDefault();
        var data = {
            prix : $("#prix").val() ,
            distance : $("#distance").val(),
            etoiles :  $("#etoiles").val(),
            prix_radio : $("[name=prix_radio]:checked").val(),
            distance_radio : $("[name=distance_radio]:checked").val(),
            etoiles_radio : $("[name=nbet_radio]:checked").val()
        }
        console.log(data);
        $.ajax({
                url : "formthing.php",
                method : "POST",
                data : data,
                dataType: "html"
            }).done( function (response) {
                console.log(response);
        });
    });
});