<section class="content">

    <h1>Ajouter une reservation </h1>
    <?php $this->include('error.tpl') ?>
    <div>
        <?php $form->render() ?>

        <a onclick="window.history.go(-1); return false;">
            <button class="btn btn-primary-outline">
                Retour
            </button>
        </a>
    </div>

</section>

<script>

    $("#date").change(function(e){

        e.preventDefault();
        $.ajax({
            url : 'add', // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP.
            data_type: 'json',
            data : {
                date_d : $('input#date').val(),
            },
            success : function(){
            },
            error: function() {alert('Erreur de communication avec le serveur');},
        });

        var select = $('#hour').val()

        console.log(select);


    });

</script>