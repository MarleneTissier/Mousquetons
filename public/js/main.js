//j'utilise la console, et j'affiche
//console.log('test');

//travail pour la galerie ;
// ajout d'image dinamyque :

var $collectionHolder;
// configurer un lien "ajouter une image"
var $addImageButton = $('<button type="button" class="add_tag_link">Ajouter une image</button>');
var $newLinkLi = $('<li></li>').append($addImageButton);

$(document).ready(function() {
    // Obtenir l'ul qui contient la collection de balises
    $collectionHolder = $('ul.generationImage');

    // ajouter un lien de suppression à tous les éléments du formulaire existant
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // ajouter l'ancre "Ajouter une image" aux balises li et aux balises ul
    $collectionHolder.append($newLinkLi);

    // compter les entrées de formulaire actuelles que nous avons et les utilisez comme nouvelle entrée
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addImageButton.on('click', function(e) {
        // ajouter un nouveau formulaire de balise
        addTagForm($collectionHolder, $newLinkLi);
    });
});


//pour supprimer un élément de la liste
function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button">Supprimer image</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // supprimer l élement
        $tagFormLi.remove();
    });
}


//mise en place des fonctions ajout / supprimer
function addTagForm($collectionHolder, $newLinkLi) {
    // Obtenez le prototype de données créé avant
    var prototype = $collectionHolder.data('prototype');

    // créer un nouvel index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    // augmenter l'index de +1 avec l'élément suivant
    $collectionHolder.data('index', index + 1);

    // Afficher le formulaire dans la page avec un li, aillant le lien "Ajouter une balise"
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}


// Js pour le retour en haut de page
var btn = $('#up');

$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});

$("#up").click(function(){
    $("html, body").animate({scrollTop: 0},500);
});


//le menu burger
$(".menu-burger").click(function() {
    $(this).toggleClass("menu-burger-expension");
});

//la pop up de suppression de profil
//ouvrir popup
$('.suppr').on('click', function(event){
    event.preventDefault();
    $('.validation').addClass('validation_up');
    $('.validation_up').removeClass('validation');
});

//fermer popup
$('.validation').on('click', function(event){
    if( $(event.target).is('.button_noDelet')) {
        event.preventDefault();
        $('.validation_up').addClass('validation');
        $('.validation').removeClass('validation_up');
    }
});
