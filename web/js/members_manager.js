
    //Message de succès
    if ($('#success-for-toast').length > 0 ){
        Materialize.toast('Action effectuée !', 4000, 'toast-success');
    }

    if ($('#error-for-toast').length > 0 ){
        Materialize.toast('Erreur : l\'action n\'a pas été effectuée ', 4000,'toast-error');
    }

    //Initialisation du tableau
    var table = $('#tabledata').DataTable({
        "ajax": $('#tabledata').data('path'),
        "language" : {
            "loadingRecords": '<div class="progress amber accent-4 " id="loader"> <div class="indeterminate  amber lighten-5"></div> </div>',
            "search": "Rechercher",
            "lengthMenu": "Nombre de résultats par page _MENU_ ",
            "zeroRecords": "Aucun résultat",
            "info": "Page _PAGE_ sur _PAGES_",
            "paginate": {
                "previous": "Précedent",
                "next": "Suivant"
            }
        },
        "columns":[
            {"data":"dateRegistration",
             "render": function (data) {
              return  new Date(data.date).toLocaleDateString();
            }},
            {"data":"pseudo"},
            {"data":"account"},
            {"data":"username"},
            {"data":"id",
             "render": function (data) {
              return '<button class="btn details waves-effect waves-light amber accent-4" id="'+ data +'" onClick="formModal('+data+')" > + </button>'
            }},
            {"data":"member",
                "visible":false
            },
            {"data":"validMail",
             "visible":false
            },
            {"data":"justificatif",
             "visible" : false,
             "render": function (data) {
                if(data == null){ return 'null'}else{return '1'}
            }}
        ],
        responsive:true,
        "ordering" : false,
        "lengthMenu": [[5, 10, 20], [5, 10, 20]],
        "initComplete" : function (settings,json) {

                btnValidated.click();
                $('#tabledata_filter input').attr('style','border: solid 1px black; background-color :white;');

            },
        "dom" : 't<"bottom"fp>'

        });


    //Actions dans modal de détails de membre
    function formModal(id) {
            var detailsBtn = $('.details');
            detailsBtn.prop('disabled',true);
            var idUser = id;
            //Charge la vue avec la modal et le formulaire
            $.ajax({
                type: "GET",
                url: $('#modal-member').data('path'),
                data: '&id='+ idUser
            }).done(function(response) {
                $('#modal-member').replaceWith(response);
                detailsMember($('#modal-member'));
                //Gère le soumission du formulaire
                $('#form_m').submit(function (e) {
                    e.preventDefault();
                    detailsBtn.prop('disabled',true);
                    $('#loader').show();
                    $.ajax({
                        type: 'POST',
                        url: $('#modal-member').data('path'),
                        data: $(this).serialize()+ '&id='+ idUser,
                        complete:(function() {
                            //Recharge la page après soumission
                            location.reload();
                        })
                    })
                });
                //Bouton de suppression du membre
                $('#delete-member').click(function () {
                    //Modal de confirmation de suppression
                    confirmationModal($('#modal-delete'));
                    $('#accept-del').click(function () {
                        $.ajax({
                            type: 'POST',
                            url: $('#delete-member').data('path'),
                            data: '&id='+ idUser,
                            complete:(function() {
                                location.reload();
                            })
                        })
                    })
                });
                //Bouton de demande de nouveau justificatif
                $('#ask-for-another').click(function () {
                    //Modal de confirmation de demande
                    confirmationModal($('#modal-ask'));
                    $('#accept-ajc').click(function () {
                        $.ajax({
                            type: 'POST',
                            url: $('#ask-for-another').data('path'),
                            data: '&id='+ idUser,
                            complete:(function() {
                                location.reload();
                            })
                        })
                    })
                });

            });

        //Modal de détails
        function detailsMember(modal) {
            modal.modal({
                    dismissible: true, // Modal can be dismissed by clicking outside of the modal
                    opacity: .7, // Opacity of modal background
                    inDuration: 400, // Transition in duration
                    outDuration: 400, // Transition out duration
                    startingTop: '4%', // Starting top style attribute
                    endingTop: '10%', // Ending top style attribute7
                    ready: function () {
                        $('#loader').hide();
                    },
                    complete: function() {  detailsBtn.prop('disabled',false);} // Callback for Modal close
                }
            ).modal('open');
        }

        //Modal de confirmation
        function confirmationModal(modal) {
            modal.modal({
                    dismissible: true, // Modal can be dismissed by clicking outside of the modal
                    opacity: .7, // Opacity of modal background
                    inDuration: 400, // Transition in duration
                    outDuration: 400, // Transition out duration
                    startingTop: '4%', // Starting top style attribute
                    endingTop: '8%', // Ending top style attribute7
                    ready: function () {
                    },
                    complete: function() {} // Callback for Modal close
                }
            ).modal('open');
        }

    }


    //Boutons de filtres
    var btnValidated = $("#btn-validated");
    var btnNoMail = $("#btn-nomail");
    var btnMember = $("#btn-member");
    var btnWaiting = $("#btn-waiting");
    var arrayBtn = [btnValidated,btnMember,btnNoMail,btnWaiting];
    var unputFilter = $('#tabledata_filter');
    var tableLength = $('#tabledata_length');



    tableLength.remove();

    //Actions de filres des boutons
    btnValidated.click(function () {
        buttonFilter($(this),arrayBtn);
        table.column(6).search('true').draw();

    });

    btnNoMail.click(function () {
        buttonFilter($(this),arrayBtn);
        table.column(6).search('false').draw();

    });

    btnMember.click(function () {
        buttonFilter($(this),arrayBtn);
        table.column(5).search('true').draw();
    });

    btnWaiting.click(function () {
        buttonFilter($(this),arrayBtn);
        table.column(7).search(1)
             .column(2).search('Particulier')
             .draw();
    });


    function buttonFilter(a,tab) {
        table.columns().search('');
        tab.forEach(function (e) {
            e.removeClass('active-filter')
                .addClass('blue-grey darken-4');
        });
        a.removeClass('blue-grey darken-4')
            .addClass('active-filter');
    }




















