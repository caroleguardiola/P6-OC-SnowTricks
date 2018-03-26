"use strict";

//Rage Template
//Designerd by: http://bootstrapthemes.co

jQuery(document).ready(function ($) {

//for Preloader

    $(window).load(function () {
        $("#loading").fadeOut(500);
    });


    /*---------------------------------------------*
     * Mobile menu
     ---------------------------------------------*/
    $("#navbar-menu").find("a[href*='#']:not([href='#'])").click(function () {
        if (location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html,body").animate({
                    scrollTop: (target.offset().top - 80)
                }, 1000);
                if ($(".navbar-toggle").css("display") !== "none") {
                    $(this).parents(".container").find(".navbar-toggle").trigger("click");
                }
                return false;
            }
        }
    });
   

// Animation home and titles
$( document ).ready(function () {
    $(".animation").fadeIn(4000);
  });


// magnificPopup

$(".image-magnific-popup").magnificPopup({
        type: "image",
        gallery: {
            enabled: true
        }
    });

function extendMagnificIframe(){

    var $start = 0;
    var $iframe = {
        markup: "<div class='mfp-iframe-scaler'>" +
                "<div class='mfp-close'></div>" +
                "<iframe class='mfp-iframe' frameborder='0' allowfullscreen></iframe>" +
                "</div>" +
                "<div class='mfp-bottom-bar'>" +
                "<div class='mfp-title'></div>" +
                "</div>",
        patterns: {
            youtube: {
                index: "youtu", 
                id: function(url) {   

                    var m = url.match( /^.*(?:youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/ );
                    if ( !m || !m[1] ) return null;

                        if(url.indexOf("t=") != - 1){

                            var $split = url.split("t=");
                            var hms = $split[1].replace("h",":").replace("m",":").replace("s","");
                            var a = hms.split(":");

                            if (a.length == 1){

                                $start = a[0]; 

                            } else if (a.length == 2){

                                $start = (+a[0]) * 60 + (+a[1]); 

                            } else if (a.length == 3){
                               $start = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

                            }
                        }                                   

                        var suffix = "?autoplay=1";

                        if( $start > 0 ){

                            suffix = "?start=" + $start + "&autoplay=1";
                        }

                    return m[1] + suffix;
                },
                src: "//www.youtube.com/embed/%id%"
            },
            vimeo: {
                index: "vimeo.com/", 
                id: function(url) {        
                    var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
                    if ( !m || !m[5] ) return null;
                    return m[5];
                },
                src: "//player.vimeo.com/video/%id%?autoplay=1"
            }
        }
    };

     return $iframe;     

}

$(".video-magnific-popup").magnificPopup({
    type: "iframe",
    iframe: extendMagnificIframe()
});

    


//---------------------------------------------
// Scroll Up and Down
//---------------------------------------------

    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $(".scrollup").fadeIn("slow");
        } else {
            $(".scrollup").fadeOut("slow");
        }
    });
    $(".scrollup").click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });


    $("a[href^='#']").on("click", function(event) {

    var target = $(this.getAttribute("href"));

    if( target.length ) {
        event.preventDefault();
        $("html, body").stop().animate({
            scrollTop: target.offset().top
        }, 1000);
    }

});

});

//Loading

$( document ).ready(function () {
    $(".trick_load").slice(0, 15).show();
    var trickslength = $(".trick_load").length;
    var trickslengthhidden= $(".trick_load:hidden").length;
      if((trickslength-trickslengthhidden) >=15) {
        $(".scrollup").removeClass("hidden")
      }
     
    if (trickslengthhidden !== 0) {
      $("#load").show();
    }  

    $("#load").on("click", function (e) {
      e.preventDefault();
      $(".trick_load:hidden").slice(0, 5).slideDown();
      var trickslength = $(".trick_load").length;
      var trickslengthhidden= $(".trick_load:hidden").length;
      if((trickslength-trickslengthhidden) >=15) {
        $(".scrollup").removeClass("hidden")
      }
      if (trickslengthhidden === 0) {
        $("#load").fadeOut("slow");
      }
    });
  });


//---------------------------------------------
// Forms
//---------------------------------------------

  //Images

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $("div#tricksbundle_trick_images");

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(":input").length;

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
      // Création du lien
      var $deleteLink = $("<a href='#' class='btn-form'><i class='fa fa-trash-o' aria-hidden='true'></i></a>");

      // Ajout du lien
      $prototype.append($deleteLink);

      // Ajout du listener sur le clic du lien pour effectivement supprimer l'image
      $deleteLink.click(function(e) {
        $prototype.remove();

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
    }

    function addFileReturn($prototype) {
      // Création du lien
      var $filereturn = $("<p class='file-return'></p>");

      // Ajout du lien
      $prototype.append($filereturn);
    }

    // La fonction qui ajoute un formulaire ImageType
    function addImage($container) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr("data-prototype")
        .replace(/__name__label__/g, "Image n°" + (index+1))
        .replace(/__name__/g,        index)
      ;

      // On crée un objet jquery qui contient ce template
      var $prototype = $(template);

      // On ajoute au prototype un lien pour pouvoir supprimer l'image
      addDeleteLink($prototype);

      addFileReturn($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
    }

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $("#add_image").click(function(e) {
      addImage($container);

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'un nouveau trick par exemple).
    /*if (index == 0) {
      addImage($container);
    }*/

  });


//Videos

$(document).ready(function() {
    var $container = $("div#tricksbundle_trick_videos");

    var index = $container.find(":input").length;

    function addDeleteLink($prototype) {
      var $deleteLink = $("<a href='#' class='btn-form'><i class='fa fa-trash-o' aria-hidden='true'></i></a>");

      $prototype.append($deleteLink);

      $deleteLink.click(function(e) {
        $prototype.remove();

        e.preventDefault(); 
        return false;
      });
    }

    function addVideo($container) {
      var template = $container.attr("data-prototype")
        .replace(/__name__label__/g, "Video n°" + (index+1))
        .replace(/__name__/g,        index)
      ;

      var $prototype = $(template);

      addDeleteLink($prototype);

      $container.append($prototype);

      index++;
    }    

    $("#add_video").click(function(e) {
      addVideo($container);

      e.preventDefault(); 
      return false;
    });

    /* if (index == 0) {
      addVideo($container);
    } */

  });


//File return

$("#tricksbundle_trick_images").on("change", "input[type='file']", function(){
        var fileName = this.value.replace(/\\/g, "/").replace(/.*\//, "");
        $(this).siblings(".file-return").text(fileName);
        $(this).parent().parent().parent().children(".file-return").text(fileName);
        $(this).parent().parent().children(".file-return").text(fileName);
    });


$("#tricksbundle_trick_thumbnail").on("change", "input[type='file']", function(){
        var fileName = this.value.replace(/\\/g, "/").replace(/.*\//, "");
        $(this).siblings(".file-return").text(fileName);
        $(this).parent().parent().parent().children(".file-return").text(fileName);
    });

$(".input-file-container").on("change", "input[type='file']", function(){
        var fileName = this.value.replace(/\\/g, "/").replace(/.*\//, "");
        $(this).siblings(".file-return").text(fileName);
    });

$("#user_photo").on("change", "input[type='file']", function(){
        var fileName = this.value.replace(/\\/g, "/").replace(/.*\//, "");
        $(this).siblings(".file-return").text(fileName);
        $(this).parent().parent().parent().parent().children(".file-return").text(fileName);
    });
