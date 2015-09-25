$(window).load(function() {
    $('img').imgPreload();
    // Animate loader off screen
    $(".se-pre-con").delay(1500).fadeOut("slow");
    //$(".se-pre-con").fadeOut("slow");
});

$(function() {
    
    $.stellar();
    $(".fittext").fitText();
    
    if (!Modernizr.cssanimations) { } else {
        $(".story-container, .story-image-container, .dot-container, .hr-container, .footer-container ").children().addClass("hide");
    }
    
    $(".story-container, .story-image-container, .dot-container, .hr-container, .footer-container ").waypoint(function(b) {
        if (b == "down") {
            if ($(this).children().data("delay") !== undefined) {
                var a = $(this).children().data("delay");
            } else {
                var a = 0;
            }
            $(this).children().removeClass("hide").removeClass("animated fadeOut delay-" + a);
            $(this).children().removeClass("hide").addClass("animated fadeIn delay-" + a);
        } else {
            $(this).children().removeClass("hide").removeClass("animated fadeIn delay-" + a);
            $(this).children().removeClass("hide").addClass("animated fadeOut delay-" + a);
        }
    }, {
        offset: "70%"
    });

    $(".color-change").waypoint(function(b) {
        var c = {
            backgroundColor: $(this).data("colorup")
        };
        var a = {
            backgroundColor: $(this).data("colordown")
        };
        if (b == "down") {
            $("body").animate(a, 525);
        } else {
            $("body").animate(c, 525);
        }
    }, {
        offset: "70%"
    });
    $("#start").waypoint(function(a) {
        if (a == "down") {
            $("#story-icons, #sub-title").fadeTo("500ms", 0);
        } else {
            $("#story-icons, #sub-title").fadeTo("500ms", 1);
        }
    }, {
        offset: "60%"
    });
});

$( document ).ready(function() {
    $("#email-form").submit(function(e){
        e.preventDefault();
        var data = {
            "email" : $("#email").val()
        };
        $.ajax({
            data:  data,
            url:   'subscribe.php',
            type:  'POST',
            beforeSend: function () {
                $("#boton-email").html("Procesando...");
            },
            success:  function (response) {
                $("#boton-email").html("¡Avísenme!");
                if(response == "success")
                    $("#resultado").html("<div class=\"alert alert-success email\" role=\"alert\">Correo agregado.</div>");
                else if (response == "0")
                    $("#resultado").html("<div class=\"alert alert-danger email\" role=\"alert\">Algo salió mal.</div>");
                else if (response == "1")
                    $("#resultado").html("<div class=\"alert alert-danger email\" role=\"alert\">No, así no :D</div>");
                else if (response == "2")
                    $("#resultado").html("<div class=\"alert alert-warning email\" role=\"alert\">Email ya registrado.</div>");
            }
        });
    });
});