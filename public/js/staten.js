$(document).ready(function () {

    $(function () {
        $('[data-toggle="offcanvas"]').on('click', function () {
            $('.offcanvas-collapse').toggleClass('open')
        })


    })


    $('.lienAConfirmer').click(function (e) {
        //Annule l'action par défaut qui est la redirection
        e.preventDefault();
           datamessage = $(this).attr('datamessage');
        //Demande une confirmation
        if (window.confirm(datamessage)) {

            //Si la confirmation est donnée, on redirige
            var url = $(this).attr('href');

            window.location.href = url;

        }
        ;

    });
    
    
    $('table.highchart').highchartTable();
    
});