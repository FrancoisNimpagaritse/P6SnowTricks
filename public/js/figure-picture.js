$('#add-picture').click(function(){
    //Calculer le numéro du futur champ à créer
    const index = +$('#widgets-counter').val();
    
    //Récupérer le prototype/le code html d'une entrée
    const tmpl = $('#figure_pictures').data('prototype').replace(/__name__/g, index);

    //Injecter ce doe html dans la div add_images
    $('#figure_pictures').append(tmpl);

    $('#widgets-counter').val(index + 1);
    //On gère le bouton supprimer
    handleDeleteButtons();            
});

function handleDeleteButtons()
{
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter()
{
    const count = +$('#figure_pictures div.form-group').length;
     $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();
