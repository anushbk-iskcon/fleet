
function getemployee() {
    "use strict";
    var positionid = $('#department').val();
    var datasring = "positionid=" + positionid;
    $.ajax({
        type: "POST",
        url: baseurl + "maintenance/maintenance/getemplist/" + positionid,
        data: datasring,
        success: function(data) {
            $('#mtable').html(data);
            $("#demo").gs_multiselect();

        }
    });
}
(function($) {
    "use strict";
    var tableBootstrap4Style = {
        initialize: function() {
            this.bootstrap4Styling();
            this.bootstrap4Modal();
            this.print();
        },
        bootstrap4Styling: function() {
            $('.bootstrap4-styling').DataTable();
        },
        bootstrap4Modal: function() {
            $('.bootstrap4-modal').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
        },
        print: function() {
            var authinfotable = $('#authinfo').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: baseurl +
                        "maintenance/maintenance/approvalauthoritysearch", // json datasource
                    type: "post", // type of method  ,GET/POST/DELETE

                    "data": function(data) {
                        data.req_typesr = $('#req_typesr').val();
                        data.req_phasesr = $('#req_phasesr').val();

                    },
                    error: function() {
                        $("#employee_grid_processing").css("display", "none");
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                },
                lengthChange: false,
            });
            new $.fn.dataTable.Buttons(authinfotable, {
                buttons: [{
                        extend: 'copy',
                        className: 'btn-success'
                    },
                    {
                        extend: 'excel',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-success'
                    },
                    {
                        extend: 'print',
                        className: 'btn-success'
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-success'
                    }
                ],
            });
            authinfotable.buttons().container().appendTo('#authinfo_wrapper .col-md-6:eq(0)');
            $('#btn-filter').click(function() {
                authinfotable.ajax.reload();
            });
            $('#btn-reset').click(function() { //button reset event click
                $('#req_typesr').val('').trigger('change');
                $('#req_phasesr').val('').trigger('change');
                authinfotable.ajax.reload(); //just reload table
            });

        }

    };

    // Initialize
    $(document).ready(function() {
        "use strict"; // Start of use strict

        tableBootstrap4Style.initialize();

    });

}(jQuery));
$(document).ready(function() {
    "use strict";
    //reinitialize js
    $("#demo").gs_multiselect();
    $(".basic-single").select2();
    $('.timepicker').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: false,
        "locale": {
            "format": "hh:mm A"
        }
    });
    $('.datetimepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        "drops": "up",
        locale: {
            format: 'YYYY-MM-DD'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });
    $('.datetimepickerwd').daterangepicker({
        singleDatePicker: true,
        "timePicker": true,
        showDropdowns: true,
        "timePicker24Hour": true,
        minYear: 1901,
        "drops": "up",
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        },
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });
    //icheck radio,checkbok,toggle
    $('.form-check-input').bootstrapToggle();
    $('.skin-minimal .i-check input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal',
        increaseArea: '20%'
    });

    $('.skin-square .i-check input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });


    $('.skin-flat .i-check input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });

    $('.skin-line .i-check input').each(function() {
        var self = $(this),
            label = self.next(),
            label_text = label.text();

        label.remove();
        self.iCheck({
            checkboxClass: 'icheckbox_line-blue',
            radioClass: 'iradio_line-blue',
            insert: '<div class="icheck_line-icon"></div>' + label_text
        });
    });

});