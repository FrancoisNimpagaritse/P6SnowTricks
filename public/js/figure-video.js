$('#add-video').click(function(){
    //Calculer le numéro du futur champ à créer
    const index = +$('#widgets-video-counter').val();
    
    //Récupérer le prototype/le code html d'une entrée
    const tmpl = $('#figure_videos').data('prototype').replace(/__name__/g, index);

    //Injecter ce doe html dans la div add_images
    $('#figure_videos').append(tmpl);

    $('#widgets-video-counter').val(index + 1);
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
    const count = +$('#figure_videos div.form-group').length;
     $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();