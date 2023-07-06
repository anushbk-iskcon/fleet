
function getexpenceitem(id) {
    "use strict";
    $('#itemname_' + id).val('');
    $('#product_name_' + id).typeahead({
        highlight: true,
        minLength: 1,
        source: function(query, result) {
            $.ajax({
                url: baseurl + "maintenance/maintenance/getexpitem",
                data: 'query=' + query,
                dataType: "json",
                type: "POST",
                success: function(data) {
                    result($.map(data, function(item) {
                        return item;
                    }));
                }
            });
        }
    });
}

function getpitem(id) {
    "use strict";
    $('#itemname_' + id).typeahead({
        highlight: true,
        minLength: 1,
        source: function(query, result) {
            var cate = $('#product_name_' + id).val();
            if (cate == '') {
                $('#product_name_' + id).val('');
                alert('please Add Item Type Name');
                return false;
            }
            $.ajax({
                url: baseurl + "maintenance/maintenance/getitem",
                data: 'item=' + query + '&category=' + cate,
                dataType: "json",
                type: "POST",
                success: function(data) {
                    result($.map(data, function(item) {
                        return item;
                    }));
                }
            });
        }
    });
}

function deleteRow(t) {
    "use strict";
    var a = $("#purchaseTable > tbody > tr").length;
    if (1 == a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
            calculateSum();

        var current = 0;
        $("#purchaseTable > tbody > tr td input.product_name").each(function() {
            current++;
            $(this).attr('id', 'product_name_' + current);
            $(this).attr('onkeypress', 'getexpenceitem(' + current + ');')
        });
        var it = 0;
        $("#purchaseTable > tbody > tr td input.pitem").each(function() {
            it++;
            $(this).attr('id', 'itemname' + it);
            $(this).attr('onkeypress', 'getpitem(' + it + ');')
        });
        var common_avail_qnt = 0; ///////// today 04-2-2019 ei section
        $("#purchaseTable > tbody > tr td input.pqty").each(function() {
            common_avail_qnt++;
            $(this).attr('class', 'form-control text-right pqty store_cal_' + common_avail_qnt);
            $(this).attr('id', 'cartoon_' + common_avail_qnt);
            $(this).attr('onkeyup', 'calculate_store(' + common_avail_qnt + ');');
            $(this).attr('onchange', 'calculate_store(' + common_avail_qnt + ');');
        });
    }
}
var count = 2,
    limits = 500;
    "use strict";
function addmore(divName) {
    var row = $("#purchaseTable tbody tr").length;
    var count = row + 1;
    var limits = 500;
    if (count == limits) {
        alert("You have reached the limit of adding " + count + " inputs");
    } else {

        var newdiv = document.createElement('tr');
        var tabin = "product_name_" + count;
        tabindex = count * 4,
            newdiv = document.createElement("tr");
        tab1 = tabindex + 1;

        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tab5 + 1;
        tab7 = tab6 + 1;



        newdiv.innerHTML =
            '<td class="span3 supplier" style="position:relative"><input type="text" name="product_name[]" required class="form-control product_name productSelection" onkeypress="getexpenceitem(' +
            count + ');" placeholder="Category Name" id="product_name_' + count + '" tabindex="' + tab1 +
            '" autocomplete="off" > <input type="hidden" class="autocomplete_hidden_value product_id_' + count +
            '" name="product_id[]" id="SchoolHiddenId"/>  <input type="hidden" class="sl" value="' + count +
            '">  </td><td class="wt" style="position:relative;"><input type="text" id="itemname_' + count +
            '" tabindex="' + tab2 + '" class="form-control text-right pitem" name="pitem[]" onkeypress="getpitem(' +
            count + ')"></td><td class="text-right"><input type="number" name="product_quantity[]" tabindex="' + tab3 +
            '" required  id="cartoon_' + count + '" class="form-control pqty text-right store_cal_' + count +
            '" placeholder="0.00" value="" min="0"/>  </td><td> <input type="hidden" id="total_discount_1" class="" /><input type="hidden" id="all_discount_1" class="total_discount" /><button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button></td>';
        document.getElementById(divName).appendChild(newdiv);
        document.getElementById(tabin).focus();
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
        document.getElementById("add_purchase").setAttribute("tabindex", tab6);

        count++;
        
    }
}

$(document).ready(function() {
    "use strict";
    //reinitialize js
    $(".basic-single").select2();
    $('.timepicker').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: false,
        "locale": {
            "format": "hh:mm A"
        }
    });

    $('.newdatetimepicker').daterangepicker({
        
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        
        minYear: 1901,
        maxDate: '2100',
        "drops": "down",
        locale: {
            format: 'YYYY-MM-DD'
    
        },
    
        
        maxYear: parseInt(moment().format('YYYY'), 10)
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });
    $('.newdatetimepicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
    
        $('.newdatetimepicker').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
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
