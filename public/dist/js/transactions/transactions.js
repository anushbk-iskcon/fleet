/* For validating File type by extension and file size */
//To validate input image is only JPG or PNG
$.validator.addMethod('validFileType', function (value, element, param) {
    let fileName = ''; let fileExtn = '';
    if (element.files[0]) { // If profile image is present
        fileName = element.files[0].name;
        fileExtn = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();
    }
    return (this.optional(element) || (fileExtn === 'jpg' || fileExtn === 'jpeg' || fileExtn === 'png' || fileExtn === 'pdf' || fileExtn === 'doc' || fileExtn === 'docx'));
}, "Please upload only images or PDFs or documents");

// For validating file size before upload
$.validator.addMethod('validFileSize', function (val, element, params) {
    let maxFileSize = 20 * 1024 * 1024; // 20 MB
    let fileSize = 0;
    if (element.files[0]) {
        fileSize = element.files[0].size;
    }
    return (this.optional(element) || fileSize <= maxFileSize);
}, "Maximum allowed file size is 20 MB");

$(document).ready(function () {
    let transactionTable = $("#transactionTable").DataTable({
        autoWidth: false,
        columnDefs: [
            { width: '50px', targets: 0 },
            { width: '90px', orderable: false, targets: 7 }
        ]
    });

    loadTable(transactionTable);

    // Enable Date-pickers in filter dates
    $("#filterTransactionDateFrom, #filterTransactionDateTo").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });
    $("#filterTransactionDateFrom, #filterTransactionDateTo").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MMM-YYYY'));
    });

    // On changing the Transaction Type in Add Form, display the relevant fields for that type
    $("#transactionType").change(function () {
        let additionalFields = '';
        let transType = $(this).val();
        if (transType == 1 || transType == 2 || transType == 6) {
            // Transaction Type 1 is for Puncture Charges,
            // Transaction Type 2 is for Parking Charges,
            // Transaction Type 6 is for Miscellaneous Bills
            additionalFields = `<div class="row">
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="billNumber" class="col-sm-5 col-form-label">Bill Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="bill_number" id="billNumber" class="form-control" placeholder="Bill number" maxlength="40">
                </div>
            </div>
            <div class="form-group row">
                <label for="billDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="bill_date" id="billDate" placeholder="Bill Date">
                </div>
            </div>
            <div class="form-group row">
                <label for="driverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="driver_name" id="driverName" class="form-control basic-single">
                            <option value="">Please Select</option>`;
            drivers.forEach((driver) => {
                additionalFields += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="devoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="devotee_name" id="devoteeName" maxlength="50" placeholder="Devotee name">
                </div>
            </div>
            <div class="form-group row">
                <label for="vehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle_type" class="form-control basic-single" id="vehicleType">
                        <option value="">Please select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle" class="form-control basic-single" id="transactionVehicle">
                        <option value="">Please select</option>`;
            // vehicles.forEach((vehicle) => {
            //     additionalFields += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            // });
            additionalFields += `</select>
                </div>
            </div>
            </div>

            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="transactionDescription" class="col-sm-5 col-form-label">Description</label>
                <div class="col-sm-7">
                    <textarea rows="3" name="description" class="form-control" id="transactionDescription" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="billAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="bill_amount" id="billAmount" placeholder="Bill Amount">
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="debit_to" class="form-control basic-single" id="transactionDebitTo">
                        <option value="">Please select</option>`;
            departments.forEach((department) => {
                additionalFields += `<option value="${department['deptCode']}">${department['deptName']}</option>`;
            });
            additionalFields += '<option value="TSF">Touchstone Foundation</option>';
            additionalFields += `</select>
                </div>
            <input type="hidden" name="debit_to_dept_name" id="debitToDeptName" value="">
            </div>
            <div class="form-group row">
                <label for="transactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
                <div class="col-sm-7 d-flex flex-wrap">
                    <input type="file" id="transactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
                </div>
            </div>
            </div>
            </div>`;

            $("#addFormAdditionalFields").empty().html(additionalFields);

            // Enable Date picker on Bill Date Field
            $("#billDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#billDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });

            $('.basic-single').select2();
            // On selecting dept in debit to whom, set name field to send to server
            $("#transactionDebitTo").change(function (e) {
                if ($(this).val() == '') {
                    $("#debitToDeptName").val('');
                } else {
                    let debitToDeptName = $(this).find(':selected').text();
                    $("#debitToDeptName").val(debitToDeptName);
                }
            });

            // On changing vehicle type, load vehciles of tht type into vehicle select box
            $("#vehicleType").change(function () {
                loadFilteredVehicles(this);
            });

        }

        else if (transType == 3) {
            // Transaction Type is for Toll Fees
            additionalFields = `<div class="row">
            <div class="col-md-12 col-lg-6">
                
            <div class="form-group row">
                <label for="vehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="vehicleType">
                    <option value="">Please select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionVehicle" class="col-sm-5 col-form-label">Vehicle Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle" class="form-control basic-single" id="transactionVehicle">
                        <option value="">Please select</option>`;

            // vehicles.forEach((vehicle) => {
            //     additionalFields += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            // });

            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="driverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                <select name="driver_name" id="driverName" class="form-control basic-single">
                    <option value="">Please Select</option>`;

            drivers.forEach((driver) => {
                additionalFields += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
            });

            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
                <label for="devoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="devotee_name" id="devoteeName" maxlength="50" placeholder="Devotee name">
                </div>
            </div>
            </div>

            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="billDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="bill_date" id="billDate" placeholder="Bill Date">
                </div>
            </div>
            <div class="form-group row">
                <label for="billAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="bill_amount" id="billAmount" placeholder="Bill Amount">
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="debit_to" class="form-control dropdown-select" id="transactionDebitTo">
                        <option value="">Please select</option>`;
            departments.forEach((department) => {
                additionalFields += `<option value="${department['deptCode']}">${department['deptName']}</option>`;
            });

            additionalFields += `</select>
                </div>
                <input type="hidden" name="debit_to_dept_name" id="debitToDeptName" value="">
            </div>
            <div class="form-group row">
                <label for="transactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
                <div class="col-sm-7 d-flex flex-wrap">
                    <input type="file" id="transactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
                </div>
            </div>
            </div>
            </div>`;

            $("#addFormAdditionalFields").empty().html(additionalFields);
            $("#billDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#billDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });

            $(".basic-single").select2();
            $('.dropdown-select').select2();


            // On selecting dept in debit to whom, set name field to send to server
            $("#transactionDebitTo").change(function (e) {
                if ($(this).val() == '') {
                    $("#debitToDeptName").val('');
                } else {
                    let debitToDeptName = $(this).find(':selected').text();
                    $("#debitToDeptName").val(debitToDeptName);
                }
            });

            // On changing vehicle type, load vehciles of tht type into vehicle select box
            $("#vehicleType").change(function () {
                loadFilteredVehicles(this);
            });

        }

        else if (transType == 4) {
            // Transaction Type is Hire Charges
            additionalFields = `<div class="row">
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="billNumber" class="col-sm-5 col-form-label">Bill Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="bill_number" id="billNumber" class="form-control" placeholder="Bill number" maxlength="40">
                </div>
            </div>
            <div class="form-group row">
                <label for="billDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                     <input type="text" class="form-control" name="bill_date" id="billDate" placeholder="Bill Date">
                </div>
            </div>
            <div class="form-group row">
                <label for="devoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="devotee_name" id="devoteeName" maxlength="50" placeholder="Devotee name">
                </div>
            </div>

            <div class="form-group row">
                <label for="vehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="vehicle_type" class="form-control basic-single" id="vehicleType">
                        <option value="">Please select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>

            <div class="form-group row">
            <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle </label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
            // vehicles.forEach((vehicle) => {
            //     additionalFields += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            // });
            additionalFields += `</select></div>
            </div>

            </div>

            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="transactionDescription" class="col-sm-5 col-form-label">Description</label>
                <div class="col-sm-7">
                    <textarea rows="2" name="description" class="form-control" id="transactionDescription" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="billAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="bill_amount" id="billAmount" placeholder="Bill Amount">
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="transactionDebitTo">
                    <option value="">Please select</option>`;
            departments.forEach((department) => {
                additionalFields += `<option value="${department['deptCode']}">${department['deptName']}</option>`;
            });
            additionalFields += `</select>
            </div>
            <input type="hidden" name="debit_to_dept_name" id="debitToDeptName" value="">
            </div>
            <div class="form-group row">
                <label for="transactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
                <div class="col-sm-7 d-flex flex-wrap">
                    <input type="file" id="transactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
                </div>
            </div>
            </div>
            </div>`;

            $("#addFormAdditionalFields").empty().html(additionalFields);

            $('.basic-single').select2();
            $("#billDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#billDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });

            // On selecting dept in debit to whom, set name field to send to server
            $("#transactionDebitTo").change(function (e) {
                if ($(this).val() == '') {
                    $("#debitToDeptName").val('');
                } else {
                    let debitToDeptName = $(this).find(':selected').text();
                    $("#debitToDeptName").val(debitToDeptName);
                }
            });

            // On changing vehicle type, load vehciles of tht type into vehicle select box
            $("#vehicleType").change(function () {
                loadFilteredVehicles(this);
            });

        }

        else if (transType == 5) {
            // Transaction Type is Tour Bata Expenses
            additionalFields = `<div class="row">
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="billDate" class="col-sm-5 col-form-label" id="billDateLabel">Date of Application <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                        <input type="text" class="form-control" name="bill_date" id="billDate" placeholder="Date of Application">
                </div>
            </div>
            <div class="form-group row">
                <label for="driverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <select name="driver_name" id="driverName" class="form-control basic-single">
                        <option value="">Please Select</option>`;
            drivers.forEach((driver) => {
                additionalFields += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>
            
        <div class="form-group row">
                <label for="vehicleType" class="col-sm-5 col-form-label">Type of vehicle </label>
                <div class="col-sm-7">
                    <select name="vehicle_type" class="form-control basic-single" id="vehicleType">
                        <option value="">Please select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });
            additionalFields += `</select>
                </div>
            </div>
            <div class="form-group row">
        <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle </label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
            vehicles.forEach((vehicle) => {
                additionalFields += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            });
            additionalFields += `</select></div>
        </div>

            <div class="form-group row">
                <label for="devoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="devotee_name" id="devoteeName" maxlength="50" placeholder="Devotee name">
                </div>
            </div>
            <div class="form-group row">
                <label for="journeyStartDate" class="col-sm-5 col-form-label">Start Date of journey <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="journeyStartDate" name="start_date_of_journey" autocomplete="off" placeholder="Journey Start Date">
                </div>
            </div>
            <div class="form-group row">
                <label for="journeyReturnDate" class="col-sm-5 col-form-label">Return Date of journey <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="journeyReturnDate" name="return_date_of_journey" autocomplete="off" placeholder="Journey Return Date">
                </div>
            </div>
            </div>
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="journeyNumberOfDays" class="col-sm-5 col-form-label">Number of days of journey <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" id="journeyNumberOfDays" name="journey_total_days" placeholder="No. of days">
                </div>
            </div>
            <div class="form-group row">
                <label for="ratePerDay" class="col-sm-5 col-form-label">Rate Per Day <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" id="ratePerDay" name="rate_per_day" placeholder="Daily rate" maxlength="10">
                </div>
            </div>
            <div class="form-group row">
                <label for="billAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="bill_amount" id="billAmount" placeholder="Bill Amount">
                </div>
            </div>
            <div class="form-group row">
                <label for="transactionDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="transactionDebitTo">
                    <option value="">Please select</option>`;
            departments.forEach((department) => {
                additionalFields += `<option value="${department['deptCode']}">${department['deptName']}</option>`;
            });
            additionalFields += `</select>
                </div>
                <input type="hidden" name="debit_to_dept_name" id="debitToDeptName" value="">
            </div>
            <div class="form-group row">
                <label for="transactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
                <div class="col-sm-7 d-flex flex-wrap">
                    <input type="file" id="transactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
                </div>
            </div>
            </div>
            </div>`;

            $("#addFormAdditionalFields").empty().html(additionalFields);

            $('.basic-single').select2();
            $("#journeyStartDate, #journeyReturnDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                drops: 'up'
            });
            $("#billDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#billDate, #journeyStartDate, #journeyReturnDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });

            // On selecting dept in debit to whom, set name field to send to server
            $("#transactionDebitTo").change(function (e) {
                if ($(this).val() == '') {
                    $("#debitToDeptName").val('');
                } else {
                    let debitToDeptName = $(this).find(':selected').text();
                    $("#debitToDeptName").val(debitToDeptName);
                }
            });

            // On changing vehicle type, load vehciles of tht type into vehicle select box
            $("#vehicleType").change(function () {
                loadFilteredVehicles(this);
            });

            // To automatically calculate Number of days of journey
            $("#journeyStartDate, #journeyReturnDate").on('apply.daterangepicker', function (ev, picker) {
                if ($("#journeyStartDate").val() && $("#journeyReturnDate").val()) {
                    let journeyStartDate = moment($("#journeyStartDate").val(), 'DD-MMM-YYYY');
                    let journeyReturnDate = moment($("#journeyReturnDate").val(), 'DD-MMM-YYYY');
                    let journeyNumOfDays = journeyReturnDate.diff(journeyStartDate, 'days') + 1;
                    $("#journeyNumberOfDays").val(journeyNumOfDays).change();
                } else {
                    $("#journeyNumberOfDays").val('').change();
                }
            });

            // To auto-calculate bill amount based on number of days and rate
            $("#ratePerDay, #journeyNumberOfDays").change(function () {
                if ($("#journeyNumberOfDays").val() && $("#ratePerDay").val()) {
                    let totalAmount = parseInt($("#journeyNumberOfDays").val()) * parseFloat($("#ratePerDay").val());
                    $("#billAmount").val(totalAmount).change();
                } else {
                    $("#billAmount").val('').change();
                }
            });

        }
        else if (transType == 7) {
            // Transaction type is for Emission Test charges
            additionalFields += `<div class="row">
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="billNumber" class="col-sm-5 col-form-label">Invoice Number <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="bill_number" id="billNumber" class="form-control" placeholder="Invoice Number" maxlength="40">
                </div>
            </div>
            <div class="form-group row">
                <label for="billDate" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="bill_date" class="form-control" id="billDate" placeholder="Date" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="driverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                <select name="driver_name" class="form-control basic-single" id="driverName">
                    <option value="">Please Select</option>`;
            drivers.forEach((driver) => {
                additionalFields += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
            });

            additionalFields += `</select>
            </div></div>
            <div class="form-group row">
                <label for="devoteeName" class="col-form-label col-sm-5">Devotee Name <i class="text-danger">*</i></label>
                <div class="col-sm-7">
                    <input type="text" name="devotee_name" class="form-control" id="devoteeName" maxlength="50" placeholder="Devotee Name">
                </div>
            </div>
            
            <div class="form-group row">
            <label for="vehicleType" class="col-sm-5 col-form-label">Type of Vehicle</label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="vehicleType">
                    <option value="">Please Select</option>`;
            vehicleTypes.forEach((vehicleType) => {
                additionalFields += `<option value="${vehicleType['VEHICLE_TYPE_ID']}">${vehicleType['VEHICLE_TYPE_NAME']}</option>`;
            });
            additionalFields += `</select>
            </div></div>
            <div class="form-group row">
            <label for="transactionVehicle" class="col-form-label col-sm-5">Vehicle </label>
            <div class="col-sm-7">
            <select name="vehicle" class="form-control basic-single" id="transactionVehicle">
            <option value="">Please Select</option>`;

            vehicles.forEach((vehicle) => {
                additionalFields += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            });
            additionalFields += `</select>
            </div></div>
            </div>
            <div class="col-md-12 col-lg-6">
            <div class="form-group row">
                <label for="transactionDescription" class="col-sm-5 col-form-label">Description</label>
            <div class="col-sm-7">
            <textarea rows="3" name="description" class="form-control" id="transactionDescription" placeholder="Description"></textarea>
            </div></div>
            <div class="form-group row">
            <label for="billAmount" class="col-sm-5 col-form-label">Amount <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" id="billAmount" placeholder="Bill Amount">
            </div></div>
            <div class="form-group row">
            <label for="transactionDebitTo" class="col-form-label col-sm-5">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
            <select name="debit_to" class="form-control basic-single" id="transactionDebitTo">
                <option value="">Please Select</option>`;
            departments.forEach((department) => {
                additionalFields += `<option value="${department['deptCode']}">${department['deptName']}</option>`;
            });
            additionalFields += `</select>
            </div>
            <input type="hidden" name="debit_to_dept_name" id="debitToDeptName" value="">
            </div>
            <div class="form-group row">
                <label for="transactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
                <div class="col-sm-7 d-flex flex-wrap">
                    <input type="file" id="transactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
                </div>
            </div>`;

            $("#addFormAdditionalFields").empty().html(additionalFields);

            $('.basic-single').select2();

            // to enable date picker on Bill Date
            $("#billDate").daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false
            });
            $("#billDate").on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MMM-YYYY'));
            });

            // On selecting dept in debit to whom, set name field to send to server
            $("#transactionDebitTo").change(function (e) {
                if ($(this).val() == '') {
                    $("#debitToDeptName").val('');
                } else {
                    let debitToDeptName = $(this).find(':selected').text();
                    $("#debitToDeptName").val(debitToDeptName);
                }
            });

            // On changing vehicle type, load vehciles of tht type into vehicle select box
            $("#vehicleType").change(function () {
                loadFilteredVehicles(this);
            });

        }

        else {
            $("#addFormAdditionalFields").empty();
        }
    });

    // On selecting dept in debit to whom, set name field to send to server
    $("#transactionDebitTo").change(function (e) {
        console.log($(this).val());
    });

    // On closing Add Form Modal, reset from and validations
    $("#add").on('hidden.bs.modal', function () {
        $("#addTransactionForm").trigger('reset');
        $("#addTransactionForm").data('validator').resetForm();
        $("#addTransactionForm .form-control").removeClass('error');
        $("#addFormAdditionalFields").empty();
    });

    $("#addTransactionForm").validate({
        rules: {
            transaction_type: 'required',
            bill_date: 'required',
            bill_number: {
                required: true,
                maxlength: 40
            },
            bill_amount: {
                number: true,
                required: true,
            },
            driver_name: 'required',
            devotee_name: 'required',
            vehicle: {
                required: function (element) {
                    if ($("#transactionType").val() == 1 || $("#transactionType").val() == 2 || $("#transactionType").val() == 3)
                        return true;
                }
            },
            vehicle_type: {
                required: function (element) {
                    if ($("#transactionType").val() == 1 || $("#transactionType").val() == 2 || $("#transactionType").val() == 3 || $("#transactionType").val() == 4)
                        return true;
                }
            },
            debit_to: 'required',
            devotee_name: 'required',
            description: {
                maxlength: 250
            },
            start_date_of_journey: {
                required: true,
            },
            return_date_of_journey: {
                required: true,
            },
            journey_total_days: {
                required: true
            },
            rate_per_day: {
                required: true,
            },
            invoice_upload: {
                validFileType: true,
                validFileSize: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let transactionDetails = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: transactionDetails,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        loadTable(transactionTable);
                        $("#add").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Error adding details. Please try again', '', { closeButton: true });
                }
            });
        }
    });

    // On submitting filter form, send AJAX request and filter
    $("#btn-filter").click(function (e) {
        e.preventDefault();
        loadTable(transactionTable);
    });

    $("#btn-reset").click(function (ev) {
        setTimeout(() => {
            loadTable(transactionTable);
            $('#filterForm .basic-single').val('').change();
        }, 10);
    });
});
//  End of $(document).ready()

function editInfo(transactionId) {
    $.ajax({
        url: getDetailsURL,
        type: 'post',
        data: {
            _token: csrfToken,
            transaction_id: transactionId
        },
        beforeSend: function () {
            $('.custom-loader').show();
        },
        dataType: 'json',
        success: function (res) {
            loadEditForm(res);
        },
        error: function () {
            console.log("Error getting details");
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}

/* To populate/refresh DataTable */
function loadTable(table) {
    $.ajax({
        url: listURL,
        type: 'post',
        data: $("#filterForm").serialize(),
        dataType: 'json',
        beforeSend: function () {
            $("#table-loader").show();
        },
        success: function (res) {
            table.clear();
            if (res.length >= 1) {
                $.each(res, function (i, data) {
                    let actionBtns = `<button class="btn btn-sm btn-info mr-1" onclick="editInfo(${data.TRANSACTION_ID})" title="Edit"><i class="ti-pencil"></i></button>`;

                    let transactionDate = moment(data.BILL_DATE).format('DD-MMM-YYYY');
                    let vehicleDetail = '';
                    if (data.VEHICLE_NAME)
                        vehicleDetail += (data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')');

                    table.row.add([
                        i + 1,
                        data.TRANS_TYPE,
                        transactionDate,
                        data.BILL_NUMBER,
                        vehicleDetail,
                        data.BILL_AMOUNT,
                        data.DEVOTEE_NAME,
                        actionBtns
                    ]);
                });
            }

            table.draw();
        },
        error: function (jqXHR, status, err) {
            toastr.error("Error fetching data. Please try again", '', { closeButton: true, timeOut: 0 });
        },
        complete: function () {
            $("#table-loader").hide();
        }
    });
}

// Load details to edit form
function loadEditForm(transactionDetails) {
    // console.log(transactionDetails);
    // transactionTypes.forEach((transactionType) => {
    //     console.log(transactionType);
    // });

    let transType = transactionDetails.TRANSACTION_TYPE;
    let formContent = '';

    let billDate = moment(transactionDetails.BILL_DATE).format('DD-MMM-YYYY');
    if (transType == 1 || transType == 2 || transType == 6) {
        // 1 = Puncture Charges, 2 = Parking Charges, 6 = Miscellaneous Charges
        formContent = `<input type="hidden" name="_token" value="${csrfToken}">`;
        formContent += `<input type="hidden" name="transaction_id" value="${transactionDetails.TRANSACTION_ID}">`;
        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="updateTransactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select name="transaction_type" id="updateTransactionType" class="form-control" disabled>
            <option value="">Please select</option>`;

        transactionTypes.forEach((transactionType) => {
            if (transactionType['TRANSACTION_TYPE_ID'] == transType)
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}" selected>${transactionType['TRANSACTION_TYPE']}</option>`;
            else
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}">${transactionType['TRANSACTION_TYPE']}</option>`;
        });
        formContent += `</select></div></div></div></div>`; // end first row

        formContent += `<div class="row"><div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editBillNumber" class="col-sm-5 col-form-label">Bill number <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" name="bill_number" id="editBillNumber" class="form-control" placeholder="Bill Number" value="${transactionDetails.BILL_NUMBER}">
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="bill_date" id="editBillDate" value="${billDate}" placeholder="Bill Date">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDriverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="driver_name" id="editDriverName" class="form-control basic-single">
                    <option value="">Please Select</option>`;
        drivers.forEach((driver) => {
            if (driver.DRIVER_ID == transactionDetails.DRIVER_ID)
                formContent += `<option value="${driver['DRIVER_ID']}" selected="selected">${driver['DRIVER_NAME']}</option>`;
            else
                formContent += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
            <label for="editDevoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="devotee_name" value="${transactionDetails.DEVOTEE_NAME}" id="editDevoteeName" maxlength="50" placeholder="Devotee name">
            </div>
        </div>
        
        <div class="form-group row">
            <label for="editVehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="editVehicleType"><option value="">Please select</option>`;
        vehicleTypes.forEach((vehicleType) => {
            if (vehicleType.VEHICLE_TYPE_ID == transactionDetails.VEHICLE_TYPE_ID)
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}" selected>${vehicleType.VEHICLE_TYPE_NAME}</option>`;
            else
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
        });
        formContent += `</select></div></div>
        
        <div class="form-group row">
            <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
        vehicles.forEach((vehicle) => {
            if (vehicle.VEHICLE_ID == transactionDetails.VEHICLE_ID)
                formContent += `<option value="${vehicle['VEHICLE_ID']}" selected>${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            else
                formContent += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
        });
        formContent += `</select></div>
        </div>

        </div>`; // End col-md-12 col-lg-6 half of form, begin new
        formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editTransactionDescription" class="col-sm-5 col-form-label">Description</label>
            <div class="col-sm-7">
                <textarea rows="3" name="description" class="form-control" id="editTransactionDescription" value="${transactionDetails.DESCRIPTION}" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" value="${transactionDetails.BILL_AMOUNT}" id="editBillAmount" placeholder="Bill Amount">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="editDebitTo"><option value="">Please select</option>`;
        departments.forEach((department) => {
            if (department.deptCode == transactionDetails.DEBIT_TO_DEPT)
                formContent += `<option value="${department.deptCode}" selected>${department.deptName}</option>`;
            else
                formContent += `<option value="${department.deptCode}">${department.deptName}</option>`;
        });
        formContent += `</select></div>
        <input type="hidden" name="debit_to_dept_name" id="editDebitToDeptName" value="${transactionDetails.DEPARTMENT_NAME}">
        </div>`;

        if (transactionDetails.INVOICE_DOCUMENT) {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <a href="${uploadedFilePath + '/' + transactionDetails.INVOICE_DOCUMENT}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file"></i>&nbsp;View File</a>
            </div></div>`;
        } else {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <div class="mt-2">No file uploaded</div>
            </div></div>`;
        }

        formContent += `<div class="form-group row">
        <label for="newTransactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
        <div class="col-sm-7 d-flex flex-wrap">
            <input type="file" id="newTransactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
        </div>
        </div>
        </div></div></div>`;

        formContent += `<div class="row">
        <div class="col-12 text-right">
        <button type="submit" class="btn btn-success">Update</button>
        </div>
        </div>`;

        $("#updateTransactionForm").empty().append(formContent);

        $("#editBillDate").daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });

        // On changing vehicle type, load vehciles of tht type into vehicle select box
        $("#editVehicleType").change(function () {
            loadFilteredVehicles(this);
        });
    }
    else if (transType == 3) {
        // 3 for Toll Fee
        formContent = `<input type="hidden" name="_token" value="${csrfToken}">`;
        formContent += `<input type="hidden" name="transaction_id" value="${transactionDetails.TRANSACTION_ID}">`;
        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="updateTransactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select name="transaction_type" id="updateTransactionType" class="form-control" disabled>
            <option value="">Please select</option>`;

        transactionTypes.forEach((transactionType) => {
            if (transactionType['TRANSACTION_TYPE_ID'] == transType)
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}" selected>${transactionType['TRANSACTION_TYPE']}</option>`;
            else
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}">${transactionType['TRANSACTION_TYPE']}</option>`;
        });
        formContent += `</select></div></div></div></div>`;

        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editVehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="editVehicleType"><option value="">Please select</option>`;
        vehicleTypes.forEach((vehicleType) => {
            if (vehicleType.VEHICLE_TYPE_ID == transactionDetails.VEHICLE_TYPE_ID)
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}" selected>${vehicleType.VEHICLE_TYPE_NAME}</option>`;
            else
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
        <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
        vehicles.forEach((vehicle) => {
            if (vehicle.VEHICLE_ID == transactionDetails.VEHICLE_ID)
                formContent += `<option value="${vehicle['VEHICLE_ID']}" selected>${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            else
                formContent += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
            <label for="editDriverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="driver_name" id="editDriverName" class="form-control basic-single">
                    <option value="">Please Select</option>`;
        drivers.forEach((driver) => {
            if (driver.DRIVER_ID == transactionDetails.DRIVER_ID)
                formContent += `<option value="${driver['DRIVER_ID']}" selected="selected">${driver['DRIVER_NAME']}</option>`;
            else
                formContent += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
            <label for="devoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="devotee_name" value="${transactionDetails.DEVOTEE_NAME}" id="devoteeName" maxlength="50" placeholder="Devotee name">
            </div>
        </div></div>`; // End First half of form, begin new

        formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editBillDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="bill_date" id="editBillDate" value="${billDate}" placeholder="Bill Date">
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" value="${transactionDetails.BILL_AMOUNT}" id="editBillAmount" placeholder="Bill Amount">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="editDebitTo"><option value="">Please select</option>`;
        departments.forEach((department) => {
            if (department.deptCode == transactionDetails.DEBIT_TO_DEPT)
                formContent += `<option value="${department.deptCode}" selected>${department.deptName}</option>`;
            else
                formContent += `<option value="${department.deptCode}">${department.deptName}</option>`;
        });
        formContent += `</select></div>
        <input type="hidden" name="debit_to_dept_name" id="editDebitToDeptName" value="${transactionDetails.DEPARTMENT_NAME}">
        </div>`;

        if (transactionDetails.INVOICE_DOCUMENT) {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
                <a href="${uploadedFilePath + '/' + transactionDetails.INVOICE_DOCUMENT}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file"></i>&nbsp; View File</a>
            </div>
            </div>`;
        } else {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <div class="mt-2">No file uploaded</div>
            </div></div>`;
        }

        formContent += `<div class="form-group row">
        <label for="newTransactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
        <div class="col-sm-7 d-flex flex-wrap">
            <input type="file" id="newTransactionInvoiceUpload" name="invoice_upload" accept="image/jpeg, image/png, .doc, .docx, .pdf">
        </div>
        </div>
        </div></div></div>`;

        formContent += `<div class="row">
        <div class="col-12 text-right">
        <button type="submit" class="btn btn-success">Update</button>
        </div>
        </div>`;

        $("#updateTransactionForm").empty().append(formContent);

        // Enable Date picker
        $("#editBillDate").daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });

        // On changing vehicle type, load vehciles of tht type into vehicle select box
        $("#editVehicleType").change(function () {
            loadFilteredVehicles(this);
        });

    }

    else if (transType == 4) {
        // 4 for Hire Charges
        // Add CSRF token and Transaction Type
        formContent = `<input type="hidden" name="_token" value="${csrfToken}">`;
        formContent += `<input type="hidden" name="transaction_id" value="${transactionDetails.TRANSACTION_ID}">`;
        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="updateTransactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select name="transaction_type" id="updateTransactionType" class="form-control" disabled>
            <option value="">Please select</option>`;

        transactionTypes.forEach((transactionType) => {
            if (transactionType['TRANSACTION_TYPE_ID'] == transType)
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}" selected>${transactionType['TRANSACTION_TYPE']}</option>`;
            else
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}">${transactionType['TRANSACTION_TYPE']}</option>`;
        });
        formContent += `</select></div></div></div></div>`;

        formContent += `<div class="row"><div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editBillNumber" class="col-sm-5 col-form-label">Bill number <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" name="bill_number" id="editBillNumber" class="form-control" placeholder="Bill Number" value="${transactionDetails.BILL_NUMBER}">
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillDate" class="col-sm-5 col-form-label" id="billDateLabel">Bill Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="bill_date" id="editBillDate" value="${billDate}" placeholder="Bill Date">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDevoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="devotee_name" value="${transactionDetails.DEVOTEE_NAME}" id="editDevoteeName" maxlength="50" placeholder="Devotee name">
            </div>
        </div>
       
        <div class="form-group row">
            <label for="editVehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="editVehicleType"><option value="">Please select</option>`;
        vehicleTypes.forEach((vehicleType) => {
            if (vehicleType.VEHICLE_TYPE_ID == transactionDetails.VEHICLE_TYPE_ID)
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}" selected>${vehicleType.VEHICLE_TYPE_NAME}</option>`;
            else
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
        <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle </label>
        <div class="col-sm-7">
            <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
        vehicles.forEach((vehicle) => {
            if (vehicle.VEHICLE_ID == transactionDetails.VEHICLE_ID)
                formContent += `<option value="${vehicle['VEHICLE_ID']}" selected>${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            else
                formContent += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
        });
        formContent += `</select></div>
        </div>
        </div>`;

        formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editTransactionDescription" class="col-sm-5 col-form-label">Description</label>
            <div class="col-sm-7">
                <textarea rows="3" name="description" class="form-control" id="editTransactionDescription" value="${transactionDetails.DESCRIPTION}" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" value="${transactionDetails.BILL_AMOUNT}" id="editBillAmount" placeholder="Bill Amount">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="editDebitTo"><option value="">Please select</option>`;
        departments.forEach((department) => {
            if (department.deptCode == transactionDetails.DEBIT_TO_DEPT)
                formContent += `<option value="${department.deptCode}" selected>${department.deptName}</option>`;
            else
                formContent += `<option value="${department.deptCode}">${department.deptName}</option>`;
        });
        formContent += `</select></div>
        <input type="hidden" name="debit_to_dept_name" id="editDebitToDeptName" value="${transactionDetails.DEPARTMENT_NAME}">
        </div>`;

        if (transactionDetails.INVOICE_DOCUMENT) {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <a href="${uploadedFilePath + '/' + transactionDetails.INVOICE_DOCUMENT}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file"></i>&nbsp; View File</a>
            </div></div>`;
        } else {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <div class="mt-2">No file uploaded</div>
            </div></div>`;
        }

        formContent += `<div class="form-group row">
        <label for="newTransactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
        <div class="col-sm-7 d-flex flex-wrap">
            <input type="file" id="newTransactionInvoiceUpload" name="invoice_upload">
        </div>
        </div>
        </div></div></div>`;

        formContent += `<div class="row">
        <div class="col-12 text-right">
        <button type="submit" class="btn btn-success">Update</button>
        </div>
        </div>`;

        $("#updateTransactionForm").empty().append(formContent);

        // Enable Date picker
        $("#editBillDate").daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });

        // On changing vehicle type, load vehciles of tht type into vehicle select box
        $("#editVehicleType").change(function () {
            loadFilteredVehicles(this);
        });
    }

    else if (transType == 5) {
        // 5 For Tour Bata Expenses
        // Add CSRF token and Transaction Type
        formContent = `<input type="hidden" name="_token" value="${csrfToken}">`;
        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="updateTransactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select name="transaction_type" id="updateTransactionType" class="form-control" disabled>
            <option value="">Please select</option>`;

        transactionTypes.forEach((transactionType) => {
            if (transactionType['TRANSACTION_TYPE_ID'] == transType)
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}" selected>${transactionType['TRANSACTION_TYPE']}</option>`;
            else
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}">${transactionType['TRANSACTION_TYPE']}</option>`;
        });
        formContent += `</select></div></div></div></div>`;

        formContent += `<div class="row"><div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editBillDate" class="col-form-label col-sm-5">Date of Application <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" name="bill_date" value="${billDate}" class="form-control" id="editBillDate">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDriverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="driver_name" id="editDriverName" class="form-control basic-single">
                    <option value="">Please Select</option>`;
        drivers.forEach((driver) => {
            if (driver.DRIVER_ID == transactionDetails.DRIVER_ID)
                formContent += `<option value="${driver['DRIVER_ID']}" selected="selected">${driver['DRIVER_NAME']}</option>`;
            else
                formContent += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
        });
        formContent += `</select></div>
        </div>
        
        <div class="form-group row">
            <label for="editVehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="editVehicleType"><option value="">Please select</option>`;
        vehicleTypes.forEach((vehicleType) => {
            if (vehicleType.VEHICLE_TYPE_ID == transactionDetails.VEHICLE_TYPE_ID)
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}" selected>${vehicleType.VEHICLE_TYPE_NAME}</option>`;
            else
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
        <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle </label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
        vehicles.forEach((vehicle) => {
            if (vehicle.VEHICLE_ID == transactionDetails.VEHICLE_ID)
                formContent += `<option value="${vehicle['VEHICLE_ID']}" selected>${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            else
                formContent += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
            <label for="editDevoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="devotee_name" value="${transactionDetails.DEVOTEE_NAME}" id="editDevoteeName" maxlength="50" placeholder="Devotee name">
            </div>
        </div>
        <div class="form-group row">
            <label for="editJourneyStartDate" class="col-sm-5 col-form-label">Start Date of journey <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="start_date_of_journey" value="${moment(transactionDetails.JOURNEY_START_DATE).format('DD-MMM-YYYY')}" id="editJourneyStartDate" maxlength="50" placeholder="Journey Start Date">
            </div>
        </div>
        <div class="form-group row">
            <label for="editJourneyReturnDate" class="col-sm-5 col-form-label">Return Date of journey <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="return_date_of_journey" value="${moment(transactionDetails.JOURNEY_RETURN_DATE).format('DD-MMM-YYYY')}" id="editJourneyReturnDate" maxlength="50" placeholder="Journey Return Date">
            </div>
        </div></div>`;

        formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editJourneyNumberOfDays" class="col-sm-5 col-form-label">Number of days of journey <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="editJourneyNumberOfDays" name="journey_total_days" value="${transactionDetails.JOURNEY_NUM_OF_DAYS}" placeholder="No. of days">
            </div>
        </div>
        <div class="form-group row">
            <label for="editRatePerDay" class="col-sm-5 col-form-label">Rate Per Day <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" id="editRatePerDay" name="rate_per_day" value="${transactionDetails.RATE_PER_DAY}" placeholder="Daily rate" maxlength="10">
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" value="${transactionDetails.BILL_AMOUNT}" id="editBillAmount" placeholder="Bill Amount">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="editDebitTo"><option value="">Please select</option>`;
        departments.forEach((department) => {
            if (department.deptCode == transactionDetails.DEBIT_TO_DEPT)
                formContent += `<option value="${department.deptCode}" selected>${department.deptName}</option>`;
            else
                formContent += `<option value="${department.deptCode}">${department.deptName}</option>`;
        });
        formContent += `</select></div>
        <input type="hidden" name="debit_to_dept_name" id="editDebitToDeptName" value="${transactionDetails.DEPARTMENT_NAME}">
        </div>`;

        if (transactionDetails.INVOICE_DOCUMENT) {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <a href="${uploadedFilePath + '/' + transactionDetails.INVOICE_DOCUMENT}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file"></i>&nbsp; View File</a>
            </div></div>`;
        } else {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <div class="mt-2">No file uploaded</div>
            </div></div>`;
        }

        formContent += `<div class="form-group row">
        <label for="newTransactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
        <div class="col-sm-7 d-flex flex-wrap">
            <input type="file" id="newTransactionInvoiceUpload" name="invoice_upload">
        </div>
        </div>
        </div></div></div>`;

        formContent += `<div class="row">
        <div class="col-12 text-right">
        <button type="submit" class="btn btn-success">Update</button>
        </div>
        </div>`;

        $("#updateTransactionForm").empty().append(formContent);

        $("#editJourneyStartDate, #editJourneyReturnDate").daterangepicker({
            singleDatePicker: true,
            drops: 'up',
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").daterangepicker({
            singleDatePicker: true,
            // drops: 'up',
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
        // On changing vehicle type, load vehciles of tht type into vehicle select box
        $("#editVehicleType").change(function () {
            loadFilteredVehicles(this);
        });

        // To automatically calculate Number of days of journey
        $("#editJourneyStartDate, #editJourneyReturnDate").on('apply.daterangepicker', function (ev, picker) {
            if ($("#editJourneyStartDate").val() && $("#editJourneyReturnDate").val()) {
                let journeyStartDate = moment($("#editJourneyStartDate").val(), 'DD-MMM-YYYY');
                let journeyReturnDate = moment($("#editJourneyReturnDate").val(), 'DD-MMM-YYYY');
                let journeyNumOfDays = journeyReturnDate.diff(journeyStartDate, 'days') + 1;
                $("#editJourneyNumberOfDays").val(journeyNumOfDays).change();
            } else {
                $("#editJourneyNumberOfDays").val('').change();
            }
        });

        // To auto-calculate bill amount based on number of days and rate
        $("#editRatePerDay, #editJourneyNumberOfDays").change(function () {
            if ($("#editJourneyNumberOfDays").val() && $("#editRatePerDay").val()) {
                let totalAmount = parseInt($("#editJourneyNumberOfDays").val()) * parseFloat($("#editRatePerDay").val());
                $("#editBillAmount").val(totalAmount).change();
            } else {
                $("#editBillAmount").val('').change();
            }
        });

    } else if (transType == 7) {
        // 7 For Emission test Charges
        // Add CSRF token and Transaction Type
        formContent = `<input type="hidden" name="_token" value="${csrfToken}">`;
        formContent += `<div class="row">
        <div class="col-md-12 col-lg-6">
        <div class="form-group row">
        <label for="updateTransactionType" class="col-sm-5 col-form-label">Transaction Type <i class="text-danger">*</i></label>
        <div class="col-sm-7">
        <select name="transaction_type" id="updateTransactionType" class="form-control" disabled>
            <option value="">Please select</option>`;

        transactionTypes.forEach((transactionType) => {
            if (transactionType['TRANSACTION_TYPE_ID'] == transType)
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}" selected>${transactionType['TRANSACTION_TYPE']}</option>`;
            else
                formContent += `<option value="${transactionType['TRANSACTION_TYPE_ID']}">${transactionType['TRANSACTION_TYPE']}</option>`;
        });
        formContent += `</select></div></div></div></div>`;
        formContent += `<div class="row"><div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editInvoiceNumber" class="col-sm-5 col-form-label">Invoice Number <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" name="bill_number" value="${transactionDetails.BILL_NUMBER}" id="editInvoiceNumber" class="form-control" placeholder="Invoice Number">
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillDate" class="col-form-label col-sm-5">Date <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" name="bill_date" value="${billDate}" class="form-control" id="editBillDate" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDriverName" class="col-sm-5 col-form-label">Driver <i class="text-danger">*</i></label>
            <div class="col-sm-7">
            <select name="driver_name" id="editDriverName" class="form-control basic-single">
                <option value="">Please Select</option>`;
        drivers.forEach((driver) => {
            if (driver.DRIVER_ID == transactionDetails.DRIVER_ID)
                formContent += `<option value="${driver['DRIVER_ID']}" selected="selected">${driver['DRIVER_NAME']}</option>`;
            else
                formContent += `<option value="${driver['DRIVER_ID']}">${driver['DRIVER_NAME']}</option>`;
        });
        formContent += `</select></div>
    </div>
    <div class="form-group row">
            <label for="editDevoteeName" class="col-sm-5 col-form-label">Devotee Name <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="devotee_name" value="${transactionDetails.DEVOTEE_NAME}" id="editDevoteeName" maxlength="50" placeholder="Devotee name">
            </div>
    </div>
    
        <div class="form-group row">
            <label for="editVehicleType" class="col-sm-5 col-form-label">Type of vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle_type" class="form-control basic-single" id="editVehicleType"><option value="">Please select</option>`;
        vehicleTypes.forEach((vehicleType) => {
            if (vehicleType.VEHICLE_TYPE_ID == transactionDetails.VEHICLE_TYPE_ID)
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}" selected>${vehicleType.VEHICLE_TYPE_NAME}</option>`;
            else
                formContent += `<option value="${vehicleType.VEHICLE_TYPE_ID}">${vehicleType.VEHICLE_TYPE_NAME}</option>`;
        });
        formContent += `</select></div>
        </div>
        <div class="form-group row">
            <label for="editTransactionVehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="vehicle" class="form-control basic-single" id="editTransactionVehicle"><option value="">Please select</option>`;
        vehicles.forEach((vehicle) => {
            if (vehicle.VEHICLE_ID == transactionDetails.VEHICLE_ID)
                formContent += `<option value="${vehicle['VEHICLE_ID']}" selected>${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
            else
                formContent += `<option value="${vehicle['VEHICLE_ID']}">${vehicle['VEHICLE_NAME'] + ' (' + vehicle['LICENSE_PLATE'] + ')'}</option>`;
        });
        formContent += `</select></div>
        </div>
        </div>`; // End col-md-12 col-lg-6 half of form, begin new;

        formContent += `<div class="col-md-12 col-lg-6">
        <div class="form-group row">
            <label for="editTransactionDescription" class="col-sm-5 col-form-label">Description</label>
            <div class="col-sm-7">
                <textarea rows="3" name="description" class="form-control" id="editTransactionDescription" value="${transactionDetails.DESCRIPTION}" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="editBillAmount" class="col-sm-5 col-form-label">Bill Amount (INR) <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <input type="number" class="form-control" name="bill_amount" value="${transactionDetails.BILL_AMOUNT}" id="editBillAmount" placeholder="Bill Amount">
            </div>
        </div>
        <div class="form-group row">
            <label for="editDebitTo" class="col-sm-5 col-form-label">Debit to Whom <i class="text-danger">*</i></label>
            <div class="col-sm-7">
                <select name="debit_to" class="form-control basic-single" id="editDebitTo"><option value="">Please select</option>`;
        departments.forEach((department) => {
            if (department.deptCode == transactionDetails.DEBIT_TO_DEPT)
                formContent += `<option value="${department.deptCode}" selected>${department.deptName}</option>`;
            else
                formContent += `<option value="${department.deptCode}">${department.deptName}</option>`;
        });
        formContent += `</select></div>
        <input type="hidden" name="debit_to_dept_name" id="editDebitToDeptName" value="${transactionDetails.DEPARTMENT_NAME}">
        </div>`;

        if (transactionDetails.INVOICE_DOCUMENT) {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <a href="${uploadedFilePath + '/' + transactionDetails.INVOICE_DOCUMENT}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-file"></i>&nbsp;View File</a>
            </div></div>`;
        } else {
            formContent += `<div class="form-group row">
            <label class="col-form-label col-sm-5">Current Invoice File </label>
            <div class="col-sm-7">
            <div class="mt-2">No file uploaded</div>
            </div></div>`;
        }

        formContent += `<div class="form-group row">
        <label for="newTransactionInvoiceUpload" class="col-sm-5 col-form-label">Invoice upload</label>
        <div class="col-sm-7 d-flex flex-wrap">
            <input type="file" id="newTransactionInvoiceUpload" name="invoice_upload">
        </div>
        </div>
        </div></div></div>`;

        formContent += `<div class="row">
        <div class="col-12 text-right">
        <button type="submit" class="btn btn-success">Update</button>
        </div>
        </div>`;

        $("#updateTransactionForm").empty().append(formContent);
        // On changing vehicle type, load vehciles of tht type into vehicle select box
        $("#editVehicleType").change(function () {
            loadFilteredVehicles(this);
        });
        $('.basic-single').select2();

        $("#editBillDate").daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MMM-YYYY'
            },
            autoUpdateInput: false
        });
        $("#editBillDate").on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD-MMM-YYYY'));
        });
    }
    $("#edit").modal('show');


    // initialize Validation for the Edit Form generated above
    initValidationForEditForm();
}

function initValidationForEditForm() {
    $("#updateTransactionForm").validate({
        rules: {
            transaction_type: 'required',
            bill_date: 'required',
            bill_number: {
                required: true,
                maxlength: 40
            },
            bill_amount: {
                number: true,
                required: true,
            },
            driver_name: 'required',
            devotee_name: 'required',
            vehicle: {
                required: function (element) {
                    if ($("#updateTransactionType").val() == 1 || $("#updateTransactionType").val() == 2 || $("#updateTransactionType").val() == 3)
                        return true;
                }
            },
            vehicle_type: {
                required: function (element) {
                    if ($("#updateTransactionType").val() == 1 || $("#updateTransactionType").val() == 2 || $("#updateTransactionType").val() == 3 || $("#updateTransactionType").val() == 4)
                        return true;
                }
            },
            debit_to: 'required',
            devotee_name: 'required',
            description: {
                maxlength: 250
            },
            start_date_of_journey: {
                required: true,
            },
            return_date_of_journey: {
                required: true,
            },
            journey_total_days: {
                required: true
            },
            rate_per_day: {
                required: true,
            },
            invoice_upload: {
                validFileType: true,
                validFileSize: true
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            $(element).closest('div[class*=col-]').append(error);
        },
        submitHandler: function (form, ev) {
            ev.preventDefault();

            let transactionDetails = new FormData($(form)[0]);

            $.ajax({
                url: form.action,
                type: form.method,
                data: transactionDetails,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res.successCode === 1) {
                        toastr.success(res.message, '', { closeButton: true });
                        loadTable($("#transactionTable").DataTable());
                        $("#edit").modal('hide');
                    } else {
                        toastr.error(res.message, '', { closeButton: true });
                    }
                },
                error: function () {
                    toastr.error('Error updating. Please try again', '', { closeButton: true });
                }
            });
        }
    });
}

// Load filterd vehicles list to Vehicle Select Dropdown in either Add or Edit Form
function loadFilteredVehicles(el) {
    $.ajax({
        url: filteredVehiclesListURL,
        type: 'post',
        data: {
            _token: csrfToken,
            vehicle_type: $(el).val()
        },
        dataType: 'json',
        beforeSend: function () {
            $('.custom-loader').show();
        },
        success: function (res) {
            let vehicleSelectBox = $(el).closest('form').find('select[name=vehicle]');
            if (res.length >= 1) {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');

                $.each(res, function (i, data) {
                    // console.log(i, data);
                    vehicleSelectBox.append(`<option value="${data.VEHICLE_ID}">
                    ${data.VEHICLE_NAME + ' (' + data.LICENSE_PLATE + ')'}
                    </option>`);
                });
            } else {
                vehicleSelectBox.empty().append('<option value="">Please Select</option>');
                toastr.error("No vehicles found", '', { closeButton: true });
            }
        },
        error: function () {
            toastr.error("Error getting data. Please try again", "", { closeButton: true });
        },
        complete: function () {
            $('.custom-loader').hide();
        }
    });
}