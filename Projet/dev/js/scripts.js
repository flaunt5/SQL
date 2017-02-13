function createResponse(html) {
    var target = $("#result");
    if(target.html().length > 0 ) {
        target.fadeOut('1200', 'swing', function () {
            $(this).empty();
            $(this).append(html);
            $(this).fadeIn('800');
        });
    } else {
        target.append(html);
        $("#result_contain").slideDown('800', function () {
            target.fadeTo('1200', 1);
        });
    }
}
$(function() {
    $.material.init();
    $("#result_contain").hide();
    $("#result").fadeTo('1', 0);
});

$("#form").validate({
    rules : {
        prix : {
            required : true,
            range : [1, 100]
        },
        distance : {
            required : true,
            range : [1, 100]
        },
        etoiles : {
            required : true,
            range : [1, 100]
        },
        prix_max : {
            required: true
        },
        prix_min : {
            required : true
        },
        distance_max : {
            required: true
        },
        distance_min : {
            required : true
        },
        nbet_max: {
            required : true
        },
        nbet_min : {
            required : true
        }
    }
});
$("#form").on("submit", function (e) {
    e.preventDefault();

    var url = $("#form").attr('action'),
        method = $("#form").attr('method'),
        prix = $("#prix").val(),
        distance = $("#distance").val(),
        etoiles =  $("#etoiles").val(),
        prix_radio = $("[name=prix_radio]:checked").val(),
        distance_radio = $("[name=distance_radio]:checked").val(),
        etoiles_radio = $("[name=nbet_radio]:checked").val();

    $.ajax({
        url : url,
        type : method,
        headers : { 'Access-Control-Allow-Origin' : '*'},
        data : {
            prix : prix ,
            distance : distance,
            etoiles :  etoiles,
            prix_radio : prix_radio,
            distance_radio : distance_radio,
            etoiles_radio : etoiles_radio
        },
        dataType: "html"
    }).done( function (response) {
        createResponse(response);
    });
});

