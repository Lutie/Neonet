$(document).ready(function () {

    $('#staging_staging_type').change(function () {
        optionsSelected = $("option:selected", this);
        optionsStates = []; // by ID, see form StagingType to learn about them
        optionsSelected.each(function() {
            optionsStates.push(this.value.toString());
        });
        $('.staging-block').each(function() {
            requirements = $(this).data('requirements');
            toggle = true;
            for (i = 0; i < requirements.length; i++) {
                if (!optionsStates.includes(requirements[i])) toggle = false;
            }
            toggle ? $(this).slideDown() : $(this).slideUp()
        });
    });
    
    $('.staging-block').each(function() {
        $(this).slideUp()
    });

    // Permet d'inclure une pop up de validation dans certains liens (comme ceux de suppression par exemple)
    $('.confirmation-required').click(function () {
        var text = $(this).data('text');
        return window.confirm("Êtes vous certain de vouloir procéder à cette action ? \n" + text);
    });

    // Permet d'activer DataTable pour les tables séléctionnées
    var dataTable = $('#bill-list, #user-list, #service-list, #item-list');
    dataTable.DataTable({
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['sorter-false']
        }, {
            'bSearchable': false,
            'aTargets': ['filter-false']
        }],
        "language": {
            "decimal": "",
            "emptyTable": "Pas de données à afficher...",
            "info": "Affichage de _START_ à _END_ sur _TOTAL_ résultats",
            "infoEmpty": "Pas de résultats à afficher...",
            "infoFiltered": "(filtrer jusqu'à _MAX_ résultats)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Afficher _MENU_ résultats",
            "loadingRecords": "Chargement...",
            "processing": "En cours de recherche...",
            "search": "Recherche :",
            "zeroRecords": "Pas d'enregistrements correspondants",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activer pour une organisation ascendante des collones",
                "sortDescending": ": activer pour une organisation descendante des collones"
            }
        }
    });

    // control visibility of items and sub services
    var changeForm = function() {

        // if a service is checked we show all his items
        $('.service-checkbox').each(function() {
            if (this.checked) {
                $('.' + this.name).slideDown();
            } else {
                $('.' + this.name).slideUp();
            }
        });

        // we look after all sub services and we show them if the service whom they are dependents are checked
        $('.replace-me').each(function() {
            var service_id = 'service_' + $(this).data('replace');
            var div = document.getElementById(service_id);
            if (div.checked) {
                $(this).slideDown();
            } else {
                $(this).slideUp();
            }
        });

        // we change the look of the PDF button if the option is check or not
        var pdfLabel = $('#pdfLabel');
        if(document.getElementById('withPdf')) {
        if(document.getElementById('withPdf').value === 'withPdf') {
            pdfLabel.addClass( "btn-success");
            pdfLabel.removeClass( "btn-warning");
            document.getElementsByClassName("withNoPdfIco")[0].hidden = true;
            document.getElementsByClassName("withPdfIco")[0].hidden = false;
            document.getElementsByClassName("withNoPdfText")[0].hidden = true;
        } else {
            pdfLabel.addClass( "btn-warning");
            pdfLabel.removeClass( "btn-success");
            document.getElementsByClassName("withNoPdfIco")[0].hidden = false;
            document.getElementsByClassName("withPdfIco")[0].hidden = true;
            document.getElementsByClassName("withNoPdfText")[0].hidden = false;
        }}
    }

    // we active or desactive submit depending on mandatories parameters
    var assertForm = function(){
        // title must have 4 or more characters
        if(document.getElementById('title')) {
        var txt = $('#title').val().length;
        if(txt >= 4) {
            $('#bill-submit').prop('disabled', false);
            $('#title-hint').hide();
            $('#title').removeClass("is-invalid");
        } else {
            $('#bill-submit').prop('disabled', true);
            $('#title-hint').show();
            $('#title').addClass("is-invalid");
        }}
    }

    // this function recalculate all value in the sheet
    var recalc = function(){
        var total = 0;
        $('.items').each(function() {
            var quantity_item = this.value;
            var price_item = parseInt($('#' + this.name + '_price').text());
            var total_item = $('#' + this.name + '_total');
            total_item.text(quantity_item * price_item);
            var service_id = 'service_' + $(this).data('service');
            var service_item = document.getElementById(service_id);
            if(service_item.checked) total += parseInt(total_item.text());
        });
        $('#bill_total').val(total);
    }

    // each time a service is checked or unchecked we change visibility and relcalculate all values
    $('.service-checkbox').change(function() {
        changeForm();
        recalc();
    });

    // each time a service is checked or unchecked we change visibility and relcalculate all values
    $('#title').change(function() {
        assertForm();
    });

    // each time an item is modified we recalculate all values
    $('.items').change(function() {
        recalc();
    });

    // once : we replace all services dependents on another one just after those services
    $('.replace-me').each(function() {
        var div = $('.label_' + $(this).data('replace'));
        $(this).after(div);
    });

    //
    $('[data-toggle="tooltip"]').tooltip();

    $('#pdfLabel').click(function() {
        if(document.getElementById("withPdf").value === 'noPdf') {
            document.getElementById("withPdf").value = 'withPdf';
        } else {
            document.getElementById("withPdf").value = 'noPdf';
        }
        changeForm();
    });

    // once : recalculate the values, usefull if the bill is loaded from datas
    recalc();

    // once : change visibility of services, usefull is the bill is loaded from datas
    changeForm();

    //
    assertForm();
});