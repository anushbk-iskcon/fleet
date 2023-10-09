/* Begin jQuery document.ready block */
$(document).ready(function () {
    let logInfoTable = $("#logInfoTable").DataTable();

    // To enable datepicker on the filter date
    $("#filterDate").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        autoApply: false,
        locale: {
            format: 'DD-MMM-YYYY'
        }
    });
    $("#filterDate").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });
    $("#filterDate").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});
/* End jQuery document.ready block */

/* To populate the log entries table on filtering or updating data */
function loadTable(table) {
}

/* Shwon form to Edit a specific information log */
function editInfo() {
    
}