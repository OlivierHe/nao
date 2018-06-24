
$(document).ready(function() {
    $('.selectp').material_select();
    $('.select2-selection__arrow').remove();
});


function formatAllRepo (repo){
    if (repo.id ==='') return "<p>Nom de l'espèce</p>  ";
    if (repo.nomVern === '') repo.nomVern = "Pas de nom vernaculaire";
    var markup = "<span style='font-weight: bold'>" +repo.nomVern +"</span>"
        + " - "
        + "<span style='font-weight: lighter'>" + repo.nomRef+ "</span>";
    return markup;
}

function formatRepo (repo) {
    if (repo.loading) return  '<div class="progress"><div class="indeterminate light-blue accent-4 "></div></div>';
    return formatAllRepo(repo);
}

function formatRepoSelection (repo) {
    $('#obs_taxref').val(repo.id);
    return formatAllRepo(repo);
}


var search;

$(".js-data-example-ajax").select2({
    ajax: {
        url: $(".js-data-example-ajax").data('path'),
        dataType: 'json',
        delay: 600,
        data: function (params) {
            return {
                q: params.term, // search term
                page: 8
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;
            search = params.term;
            return {
                results: data,  // data.items
                pagination: {
                    more: (8 * 1) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo, // omitted for brevity, see the source of this page
    templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page
    placeholder: "test",
    allowClear: true,
    language: "fr"
});
