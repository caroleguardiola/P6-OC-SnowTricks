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
    $('#navbar-menu').find('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: (target.offset().top - 80)
                }, 1000);
                if ($('.navbar-toggle').css('display') !== 'none') {
                    $(this).parents('.container').find(".navbar-toggle").trigger("click");
                }
                return false;
            }
        }
    });



    /*---------------------------------------------*
     * WOW
     ---------------------------------------------*/

    var wow = new WOW({
        mobile: false // trigger animations on mobile devices (default is true)
    });
    wow.init();

// magnificPopup

    $('.popup-img').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    $('.video-link').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        iframe: {
  markup: '<div class="mfp-iframe-scaler">'+
            '<div class="mfp-close"></div>'+
            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
          '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

  patterns: {
    youtube: {
      index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

      id: 'v=', // String that splits URL in a two parts, second part should be %id%
      // Or null - full URL will be returned
      // Or a function that should return %id%, for example:
      // id: function(url) { return 'parsed id'; }

      src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
    }
    // you may add here more sources

  },

  srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
}
 
    });


//---------------------------------------------
// Scroll Up and Down
//---------------------------------------------

    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('.scrollup').fadeIn('slow');
        } else {
            $('.scrollup').fadeOut('slow');
        }
    });
    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });


    $('a[href^="#"]').on('click', function(event) {

    var target = $(this.getAttribute('href'));

    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
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

    $("#load").on('click', function (e) {
      e.preventDefault();
      $(".trick_load:hidden").slice(0, 5).slideDown();
      var trickslength = $(".trick_load").length;
      var trickslengthhidden= $(".trick_load:hidden").length;
      if((trickslength-trickslengthhidden) >=15) {
        $(".scrollup").removeClass("hidden")
      }
      if (trickslengthhidden === 0) {
        $("#load").fadeOut('slow');
      }
    });
  });


//---------------------------------------------
// Forms
//---------------------------------------------

  //Images

$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#tricksbundle_trick_images');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
      // Création du lien
      var $deleteLink = $('<a href="#" class="btn-form"><i class="fa fa-trash-o" aria-hidden="true"></i></a>');

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
      var $filereturn = $('<p class="file-return"></p>');

      // Ajout du lien
      $prototype.append($filereturn);
    }

    // La fonction qui ajoute un formulaire ImageType
    function addImage($container) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Image n°' + (index+1))
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
    $('#add_image').click(function(e) {
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
    var $container = $('div#tricksbundle_trick_videos');

    var index = $container.find(':input').length;

    function addDeleteLink($prototype) {
      var $deleteLink = $('<a href="#" class="btn-form"><i class="fa fa-trash-o" aria-hidden="true"></i></a>');

      $prototype.append($deleteLink);

      $deleteLink.click(function(e) {
        $prototype.remove();

        e.preventDefault(); 
        return false;
      });
    }

    function addVideo($container) {
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Video n°' + (index+1))
        .replace(/__name__/g,        index)
      ;

      var $prototype = $(template);

      addDeleteLink($prototype);

      $container.append($prototype);

      index++;
    }    

    $('#add_video').click(function(e) {
      addVideo($container);

      e.preventDefault(); 
      return false;
    });

    /* if (index == 0) {
      addVideo($container);
    } */

  });


//File return

$('#tricksbundle_trick_images').on('change', 'input[type="file"]', function(){
    console.log($(this));
        var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');
        $(this).siblings(".file-return").text(file_name);
        $(this).parent().parent().parent().children(".file-return").text(file_name);
        $(this).parent().parent().children(".file-return").text(file_name);
    });


$('#tricksbundle_trick_thumbnail').on('change', 'input[type="file"]', function(){
    console.log($(this));
        var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');
        $(this).siblings(".file-return").text(file_name);
        $(this).parent().parent().parent().children(".file-return").text(file_name);
    });

$('.input-file-container').on('change', 'input[type="file"]', function(){
    console.log($(this));
        var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');
        $(this).siblings(".file-return").text(file_name);
    });

$('#user_photo').on('change', 'input[type="file"]', function(){
    console.log($(this));
        var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');
        $(this).siblings(".file-return").text(file_name);
        $(this).parent().parent().parent().parent().children(".file-return").text(file_name);
    });
