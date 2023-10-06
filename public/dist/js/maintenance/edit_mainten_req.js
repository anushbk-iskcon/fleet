var count = 2, limits = 500;

$(document).ready(function () {
    $(".basic-single").select2();

    $('.new-datepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: 2000,
        "drops": "up",
        locale: {
            format: 'DD-MMM-YYYY'
        },
    }, function (start, end, label) {
        var years = moment().diff(start, 'years');
    });
    $('.new-datepicker').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });

    $('.new-datepicker').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    $('.form-check-input').bootstrapToggle();

    $("#editMaintenRequisitionForm").validate({
        rules: {
            requested_by: 'required',
            vehicle_name: 'required',
            mainten_type: 'required',
            mainten_service_name: 'required',
            service_date: 'required',
            remarks: {
                maxlength: 200
            },
            charge: {
                required: true,
                number: true
            },
            priority: 'required'
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            if ($(element).parent('td').length == 1) // For Unit Price, Qty, which are inside td elements
                $(element).closest('td').append(error);
            else
                $(element).closest('div[class*=col-sm-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();
            form.submit();
        }
    });

});

function deleteRow(t) {
    let itemId = $(t).find('input[name*="item_id"]').val();
    console.log(itemId);
    if (itemId != undefined || itemId != '') {
        if (confirm("Are you sure you want to delete this item?")) {
            var a = $("#purchaseTable > tbody > tr").length;
            if (1 == a) alert("Minimum 1 item required.");
            else {
                var e = t.parentNode.parentNode;
                e.parentNode.removeChild(e),
                    calculateSum();

                var current = 0;
                $("#purchaseTable > tbody > tr td input.product_name").each(function () {
                    current++;
                    $(this).attr('id', 'product_name_' + current);
                    $(this).attr('onkeypress', 'getexpenceitem(' + current + ');')
                });
                var it = 0;
                $("#purchaseTable > tbody > tr td input.pitem").each(function () {
                    it++;
                    $(this).attr('id', 'itemname' + it);
                    $(this).attr('onkeypress', 'getpitem(' + it + ');')
                });
                var common_avail_qnt = 0;
                $("#purchaseTable > tbody > tr td input.pqty").each(function () {
                    common_avail_qnt++;
                    $(this).attr('class', 'form-control text-right pqty store_cal_' + common_avail_qnt);
                    $(this).attr('id', 'cartoon_' + common_avail_qnt);
                    $(this).attr('onkeyup', 'calculate_store(' + common_avail_qnt + ');');
                    $(this).attr('onchange', 'calculate_store(' + common_avail_qnt + ');');
                });
                var common_qnt = 0;
                $("#purchaseTable > tbody > tr td input.product_rate").each(function () {
                    common_qnt++;
                    $(this).attr('class', 'form-control product_rate text-right product_rate_' + common_qnt);
                    $(this).attr('id', 'product_rate_' + common_qnt);
                    $(this).attr('onkeyup', 'calculate_store(' + common_qnt + ');');
                    $(this).attr('onchange', 'calculate_store(' + common_qnt + ');');
                });
                var common_total_price = 0;
                $("#purchaseTable > tbody > tr td input.total_price").each(function () {
                    common_total_price++;
                    $(this).attr('id', 'total_price_' + common_total_price);
                });
            }
        }
    }
}

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
            '<td class="span3 supplier" style="position:relative">' +
            '<input type="hidden" name="item_id[]" value="">' +
            '<input type="text" name="product_name[]" required class="form-control product_name productSelection" onkeypress="getexpenceitem(' +
            count + ');" placeholder="Item Type Name" id="product_name_' + count + '" tabindex="' + tab1 +
            '" autocomplete="off" > <input type="hidden" class="autocomplete_hidden_value product_id_' + count +
            '" name="product_id[]" id="SchoolHiddenId"/>  <input type="hidden" class="sl" value="' + count +
            '">  </td><td class="wt" style="position:relative;"><input type="text" id="itemname_' + count +
            '" class="form-control text-right pitem" name="pitem[]" onkeypress="getpitem(' + count +
            ')"></td><td class="text-right"><input type="number" name="product_quantity[]" tabindex="' + tab2 +
            '" required  id="cartoon_' + count + '" class="form-control pqty text-right store_cal_' + count +
            '" onkeyup="calculate_store(' + count + ');" onchange="calculate_store(' + count +
            ');" placeholder="0.00" value="" min="0"/>  </td><td class="test text-right"><input type="number" name="product_rate[]" onkeyup="calculate_store(' +
            count + ');" onchange="calculate_store(' + count + ');" required id="product_rate_' + count +
            '" class="form-control product_rate product_rate_' + count +
            ' text-right" placeholder="0.00" value="" min="0" tabindex="' + tab3 +
            '"/></td><td class="text-right"><input class="form-control total_price text-right total_price_' + count +
            '" type="text" name="total_price[]" id="total_price_' + count +
            '" value="0.00" readonly="readonly" /> </td><td> <input type="hidden" id="total_discount_1" class="" /><input type="hidden" id="all_discount_1" class="total_discount" /><button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" onclick="deleteRow(this)" tabindex="8">Delete</button></td>';
        document.getElementById(divName).appendChild(newdiv);
        document.getElementById(tabin).focus();
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
        document.getElementById("update_purchase").setAttribute("tabindex", tab6);

        count++;

    }
}

// Calculate store Item
function calculate_store(sl) {
    var gr_tot = 0;
    var item_ctn_qty = $("#cartoon_" + sl).val();
    var vendor_rate = $("#product_rate_" + sl).val();

    var total_price = item_ctn_qty * vendor_rate;
    $("#total_price_" + sl).val(total_price.toFixed(2));


    // Total Price
    $(".total_price").each(function () {
        isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
    });

    $("#grandTotal").val(gr_tot.toFixed(2, 2));
}

// Calculate Sum
function calculateSum() {
    var t = 0,
        a = 0,
        e = 0,
        o = 0,
        p = 0;

    //Total Tax
    $(".total_tax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (a += parseFloat(this.value))
    }),
        $("#total_tax_ammount").val(a.toFixed(2, 2)),

        //Total Discount
        $(".total_discount").each(function () {
            isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
        }),

        $("#total_discount_ammount").val(p.toFixed(2, 2)),

        //Total Price
        $(".total_price").each(function () {
            isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
        }),

        o = a.toFixed(2, 2),
        e = t.toFixed(2, 2);
    f = p.toFixed(2, 2);

    var test = +o + +e + -f;
    $("#grandTotal").val(test.toFixed(2, 2))
}

function getexpenceitem(i) {
}

function getpitem(i) { }