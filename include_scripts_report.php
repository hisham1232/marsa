<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/plugins/popper/popper2018.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="js/bootstrap-confirmation.js"></script>
<script src="js/bootstrap-confirmation_new.js"></script>
<script src="js/bootstrap-tooltip.js"></script>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="js/custom.min.js"></script>
<script src="js/validation.js"></script>

<script src="js/bootstrap-select.min.js"></script>

<!-- Plugin JavaScript -->
<script src="assets/plugins/moment/moment.js"></script>
<script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Clock Plugin JavaScript -->
<script src="assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Color Picker Plugin JavaScript -->
<script src="assets/plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="assets/plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
        
<!-- Important! Do not Delete this! Submit validator for null values -->
<script>
! function(window, document, $) {
    "use strict";
    $("input,select,textarea,checkbox").not("[type=submit]").jqBootstrapValidation(), $(".skin-square input").iCheck({
        checkboxClass: "icheckbox_square-green",
        radioClass: "iradio_square-green"
    }), $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();
}(window, document, jQuery);
</script>

<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
<script src="js/main_backtotop.js"></script> <!-- Resource JavaScript -->
<script src="js/bootbox.min.js"></script> <!-- Resource JavaScript -->

<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables/buttons.flash.min.js"></script>
<script src="assets/plugins/datatables/jszip.min.js"></script>
<script src="assets/plugins/datatables/pdfmake.min.js"></script>
<script src="assets/plugins/datatables/vfs_fonts.js"></script>
<script src="assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->

<!-- User-defined Javascript Functions -->
<script>
    $(document).ready(function() {
        $('select').selectpicker();
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
        $("#employmentForm :input").prop("disabled", true);
        $("#staff_add_new :input").prop("disabled", true);
    });
    $('#dynamicTable').DataTable({
        dom: 'Bfrltip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#intLeaveBalanceHistory').DataTable({
        dom: 'Bfrltip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "iDisplayLength": 100
    });
    $('#myLeaveList').DataTable({
        dom: 'Bfrltip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "iDisplayLength": 5000
    });
    $('#shortLeaveList').DataTable({
        dom: 'Bfrltip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "iDisplayLength": 5000
    });
    $('#dynamicTableServer').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "iDisplayLength": 10,
        "processing": true,
        "serverSide": true,
        "ajax": "ajaxpages/leaves/standardleave/v_standardleave.php"
    });

</script>

<script>
    $(document).on('click', '.delete-confirm', function(){
        var id = $(this).attr('delete-id');
        var deleting = $(this).attr('deleting');
        bootbox.confirm({
            /*message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Are you sure?</h4><br/><p>Once this record was deleted, you cannot undo it.</p><p><small class='text-danger'><i class='fa fa-bullhorn'></i> Note: Any data that has a reference to this record will also be delete.</small></p><p><small class='text-primary'><i class='fa fa-info-circle'></i> Example<br/><i class='fa fa-arrow-circle-right'></i> Deleted department that has section under it will also be deleted.</small></p>",*/
            message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Are you sure?</h4><br/><p>This will <strong>permanently</strong> delete this record. Once deleted, you cannot undo it.</p><p><small class='text-danger'>",
            buttons: {
                confirm: {
                    label: '<i class="fas fa-check"></i> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<i class="fas fa-times"></i> No',
                    className: 'btn-dark'
                }
            },
            callback: function (result) {
                if(result==true){
                    $.post('file_all_delete.php', {
                        object_id: id, deleting: deleting
                    }, function(data){
                        bootbox.alert("<h4>Record has been deleted!</h4>", function(){ location.reload(); })
                    }).fail(function() {
                        alert('Unable to delete.');
                    });
                }
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>

<script>
    /**-------------------------------------------------------------------------------------------------------------------------------------**/
    //Customized AJAX user-defined functions    
    function loadAjax(linkPage, variables, divName) {
        $(divName).empty().html();
        $.get(linkPage + "?" + variables, function (data) {
            $(divName).html(data);
        });
    }
    function generateStaffId(input) {
        var deptCode = document.getElementById('fDepartment').value;
        var yearCode = document.getElementById('fYear').value;
        var yearCodeLast2 = yearCode.slice(-2);
        var firstThree = deptCode + yearCodeLast2;
        loadAjax("ajaxpages/ids/load-staff-ids.php", "deptCode=" + deptCode + "&yearCode=" + yearCodeLast2 + "&first3=" + firstThree, "#lastStaffId");
        loadAjax("ajaxpages/ids/load-staff-ids-name.php", "deptCode=" + deptCode + "&yearCode=" + yearCodeLast2 + "&first3=" + firstThree, "#lastStaffName");
        loadAjax("ajaxpages/ids/load-staff-newstaffId.php", "deptCode=" + deptCode + "&yearCode=" + yearCodeLast2 + "&first3=" + firstThree, "#newStaffId");
    }
    function submitNewId(){
        var bagoAydi = document.getElementById('newStaffId').innerHTML;
        window.location = "staff_add_new.php?nid="+bagoAydi;
    }
    function checkStaffId(){
        loadAjax("ajaxpages/ids/checkstaffid.php","id=" + document.getElementById('staffIdCheck').value,"#staffIdChecker");
    }
    function checkCivilId(){
        loadAjax("ajaxpages/ids/checkcivilid.php","id=" + document.getElementById('civilIdCheck').value,"#civilIdChecker");
    }
    function checkMinistryStaffId(){
        loadAjax("ajaxpages/ids/checkministrystaffid.php","id=" + document.getElementById('ministryStaffIdCheck').value,"#ministryStaffIdChecker");
    }
    function checkGSM(){
        loadAjax("ajaxpages/ids/checkgsm.php","gsm=" + document.getElementById('gsmCheck').value,"#GSMChecker");
    }
    $('.draftAddInternalLeave').click(function(){
        var staff_id = $('.staffDropDown').val();
        var department_id = $('.department_id').val();
        if(department_id == "") {
            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Please select department name in the dropdown list.</p>");
        } else if (staff_id == ""){
            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Please select staff name in the dropdown list.</p>");
        } else {
            var requestNo = $('.requestNo').text();
            var leavetype_id = 1;
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            var total = $('.noOfDays').val();
            var status = "Unsaved"; //Unsaved or Draft whichever is better
            var notes = $('.notes').val();
            var addType = 1;
            var createdBy = $('.createdBy').val();
            var data = {
                internalleavebalance_id : requestNo,
				leavetype_id : leavetype_id,
                staffId : staff_id,
                startDate : startDate,
                endDate : endDate,
                total : total,
                status : status,
                notes : notes,
                addType : addType,
                createdBy : createdBy
			}
            $.ajax({
				 url	 : 'ajaxpages/leaves/add-internal/draft.php'
				,type	 : 'POST'
				,dataType: 'json'
				,data	 : data
				,success : function(e){
                    if(e.error == 1){
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>"+e.message);
                    } else {
                        $('#draftAddInternal tbody').empty();
                        if(e.totalCount != 0) {
                            $('.finalizedSubmit').removeAttr('disabled');
                        }
                        $.each(e.rows, function(i, j){
                            /*$('#draftAddInternal tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"editAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-info waves-effect waves-light editAddedInternal' title='Edit'><i class='fas fa-pencil-alt'></i></button><button onClick=\"deleteAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Delete'><i class='fa fa-trash'></i></button></td></tr>");*/
                            $('#draftAddInternal tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"deleteAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Remove this entry'><i class='fa fa-trash'></i></button></td></tr>");
                        });
                        $('.actionNotification').html(e.notification);
                    }	
				}
				,error	: function(e){
				}
			});
        }
    });

    $('.draftAddOtherLeave').click(function(){
        var leave_type_id = $('.leaveTypeId').val();
        var staff_id = $('.staffDropDown').val();
        if(leave_type_id == "") {
            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Please select kind of leave in the dropdown list.</p>");
        } else if (staff_id == ""){
            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Please select staff name in the dropdown list.</p>");
        } else {
            var requestNo = $('.requestNo').text();
            var leavetype_id = 1;
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            var total = $('.noOfDays').val();
            var status = "Unsaved"; //Unsaved or Draft whichever is better
            var notes = $('.notes').val();
            var addType = 1;
            var createdBy = $('.createdBy').val();
            var data = {
                internalleavebalance_id : requestNo,
				leavetype_id : leavetype_id,
                staffId : staff_id,
                startDate : startDate,
                endDate : endDate,
                total : total,
                status : status,
                notes : notes,
                addType : addType,
                createdBy : createdBy
			}
            $.ajax({
				 url	 : 'ajaxpages/leaves/add-internal/draft-XXX.php'
				,type	 : 'POST'
				,dataType: 'json'
				,data	 : data
				,success : function(e){
                    if(e.error == 1){
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>"+e.message);
                    } else {
                        $('#draftAddInternal tbody').empty();
                        if(e.totalCount != 0) {
                            $('.finalizedSubmit').removeAttr('disabled');
                        }
                        $.each(e.rows, function(i, j){
                            $('#draftAddInternal tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"deleteAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Remove this entry'><i class='fa fa-trash'></i></button></td></tr>");
                        });
                        $('.actionNotification').html(e.notification);
                    }	
				}
				,error	: function(e){
				}
			});
        }
    });

    function deleteAddedInternal(id){
        var data = {
            id : id
        }
        $.ajax({
                url	 : 'ajaxpages/leaves/add-internal/delete.php'
            ,type	 : 'POST'
            ,dataType: 'json'
            ,data	 : data
            ,success : function(e){
                if(e.error == 1){
                    bootbox.alert(e.message);
                } else {
                    $('#draftAddInternal tbody').empty();
                    if(e.totalCount <= 0) {
                        $('.finalizedSubmit').attr('disabled','disabled');
                    } else {
                        $('.finalizedSubmit').removeAttr('disabled');
                    }
                    $.each(e.rows, function(i, j){
                        /*$('#draftAddInternal tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"editAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-info waves-effect waves-light editAddedInternal' title='Edit'><i class='fas fa-pencil-alt'></i></button><button onClick=\"deleteAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Delete'><i class='fa fa-trash'></i></button></td></tr>");*/
                        $('#draftAddInternal tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"deleteAddedInternal('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Remove this entry'><i class='fa fa-trash'></i></button></td></tr>");
                    });
                    $('.actionNotification').html(e.notification);
                }	
            }
            ,error	: function(e){
            }
        });
    };

    function editAddedInternal(id){
        alert("ID to be edit is: "+id);
    };

    $('.draftOvertimeLeave').click(function(){
            var requestNo = $('.requestNo').text();
            var leavetype_id = 1;
            var staff_id = $('.staffDropDown').val();
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            var total = $('.noOfDays').val();
            var status = "Drafted";
            var notes = $('.notes').val();
            var addType = 1;
            var createdBy = $('.createdBy').val();
            var data = {
                internalleaveovertime_id : requestNo,
				leavetype_id : leavetype_id,
                staffId : staff_id,
                startDate : startDate,
                endDate : endDate,
                total : total,
                status : status,
                notes : notes,
                addType : addType,
                createdBy : createdBy
			}
            $.ajax({
				 url	 : 'ajaxpages/leaves/overtime/draft.php'
				,type	 : 'POST'
				,dataType: 'json'
				,data	 : data
				,success : function(e){
                    if(e.error == 1){
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>"+e.message);
                    } else {
                        $('#draftAddOvertime tbody').empty();
                        if(e.totalCount != 0) {
                            $('.finalizedSubmit').removeAttr('disabled');
                        }
                        $.each(e.rows, function(i, j){
                            $('#draftAddOvertime tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"deleteAddedOvertime('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Remove this entry'><i class='fa fa-trash'></i></button></td></tr>");
                        });
                        $('.actionNotification').html(e.notification);
                    }	
				}
				,error	: function(e){
				}
			});
    });

    function deleteAddedOvertime(id){
        var data = {
            id : id
        }
        $.ajax({
                url	 : 'ajaxpages/leaves/overtime/delete.php'
            ,type	 : 'POST'
            ,dataType: 'json'
            ,data	 : data
            ,success : function(e){
                if(e.error == 1){
                    bootbox.alert(e.message);
                } else {
                    $('#draftAddOvertime tbody').empty();
                    if(e.totalCount <= 0) {
                        $('.finalizedSubmit').attr('disabled','disabled');
                    } else {
                        $('.finalizedSubmit').removeAttr('disabled');
                    }
                    $.each(e.rows, function(i, j){
                        $('#draftAddOvertime tbody').append("<tr><td>" + j.id + "</td><td>" + j.staffId + "</td><td>" + j.staffName + "</td><td>" + j.fStartDate + "</td><td>" + j.fEndDate + "</td><td>" + j.total + "</td><td><button onClick=\"deleteAddedOvertime('"+j.id+"')\" type='button' class='btn btn-outline-danger waves-effect waves-light' title='Remove this entry'><i class='fa fa-trash'></i></button></td></tr>");
                    });
                    $('.actionNotification').html(e.notification);
                }	
            }
            ,error	: function(e){
            }
        });
    };
   
    
    //Customized User-defined functions
    $('.btnShowEmploymentForm').click(function(){
        $("#employmentForm :input").prop("disabled", false);
        $(".btnShowEmploymentForm").hide();
    });
    $('.btnShowAddNewStaffForm').click(function(){
        $("#staff_add_new :input").prop("disabled", false);
        $(".btnShowAddNewStaffForm").hide();
        $(".firstName").focus();
    });


    //Filing of Leaves Validations Will Start Here*****
    // Daterange Picker PLUS Computation of Date Difference between two chosen dates, Filing of Internal Leave
    $(function() {
        $('.daterange').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $(".startDate").val(start.format('YYYY-MM-DD'));
            $('.endDate').val(end.format('YYYY-MM-DD'));
            //Number of days computation here...
            var start_date = $('.startDate').val();
            var today = $('#today').val();
            var end_date = $('.endDate').val();
            var diff =  Math.floor(( Date.parse(end_date) - Date.parse(start_date) ) / 86400000);
            var noOfDays = diff + 1;

            var leaveId = $('#leaveTypeId').val();
            if(leaveId == 1) { //If Internal Leave
                var nStartDate = new Date(start_date);
                var nToday = new Date(today);
                if(nStartDate <= nToday) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Invalid starting date!</strong><br/><br/><p>Internal leave must be filed at least a day before.</p>");
                    $('.noOfDays').val("");
                } else {
                    var intLeaveBal = $('#intLeaveBal').val();
                    if(intLeaveBal < noOfDays) {
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Insufficient Internal Leave Balance!</strong><br/><br/><p>Current Balance: "+intLeaveBal+" days.<br/>You are applying for: "+noOfDays+" days.<br/><br/>Kindly adjust the date of your leave to continue.</p>");
                        $('.noOfDays').val("");
                    } else {
                        proceedStandardLeave(noOfDays);
                        //$('.noOfDays').val(noOfDays);
                    }    
                }
            } else if(leaveId == 2) { //If Emergency Leave
                var emerLeaveBal = $('#emerLeaveBal').val();
                var nStartDate = new Date(start_date);
                var nToday = new Date(today);
                if(emerLeaveBal < noOfDays) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Insufficient Emergency Leave Balance!</strong><br/><br/><p>Current Balance: "+emerLeaveBal+" days.<br/>You are applying for: "+noOfDays+" days.<br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else if (nStartDate >= nToday) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable to Continue!</strong><br/><br/><p>Emergency leave must be filed at least a day after you had an emergency.</p>");
                    $('.noOfDays').val("");
                } else {
                    var sponsorId = $('#sponsorId').val();
                    if(sponsorId > 1) {
                        if(noOfDays > 2) {
                            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>2 days</strong> per filing of leave.<br/><br/>Kindly adjust the date of your leave to continue.</p>");
                            $('.noOfDays').val("");
                        } else {
                            proceedStandardLeave(noOfDays);
                            //$('.noOfDays').val(noOfDays);    
                        }
                    } else {
                        proceedStandardLeave(noOfDays);
                        //$('.noOfDays').val(noOfDays);
                    }
                    
                }
            } else if(leaveId == 3) { //If Unpaid Leave
                var sponsorId = $('#sponsorId').val();
                if(sponsorId > 1) {
                    if(noOfDays > 30) {
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>30 days</strong> for unpaid leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                        $('.noOfDays').val("");
                    } else {
                        proceedStandardLeave(noOfDays);
                        //$('.noOfDays').val(noOfDays);    
                    }
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);
                }
            } else if (leaveId == 4){ //If Maternity leave (giving birth) - FOR FEMALE ONLY
                if(noOfDays > 50) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>50 days</strong> for maternity leave (giving birth).<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }
            } else if(leaveId == 5) { //If Hajj Leave
                var sponsorId = $('#sponsorId').val();
                if(sponsorId > 1) {
                    if(noOfDays > 15) {
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>15 days</strong> for hajj leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                        $('.noOfDays').val("");
                    } else {
                        proceedStandardLeave(noOfDays);
                        //$('.noOfDays').val(noOfDays);    
                    }
                } else {
                    if(noOfDays > 20) {
                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>20 days</strong> for hajj leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                        $('.noOfDays').val("");
                    } else {
                        proceedStandardLeave(noOfDays);
                        //$('.noOfDays').val(noOfDays);    
                    }
                }    
            } else if (leaveId == 6){ //Mourning for Muslim Women (Eiddah) Leave - FOR FEMALE ONLY
                if(noOfDays > 130) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>130 days</strong> for mourning for muslim Women (Eiddah) leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }
            } else if (leaveId == 7){ //Sick Leave - HR will do the validations here...
                proceedStandardLeave(noOfDays);
                //$('.noOfDays').val(noOfDays);    
            } else if(leaveId == 8) { //If Accompanying A Patient Leave - For Ministry Staff Only
                if(noOfDays > 15) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>15 days</strong> for accompanying a patient leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }
            } else if(leaveId == 9) { //If Marriage Leave  - For Company Staff Only
                if(noOfDays > 3) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>3 days</strong> for marriage leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }
            } else if(leaveId == 10) { //If Death Leave  - For Company Staff Only
                if(noOfDays > 3) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>3 days</strong> for death leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }        
            } else if(leaveId == 11) { //If Examination Leave - Ministry Only, can be company BUT it has to be an Omani
                if(noOfDays > 15) {
                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You are only allowed to take a maximum of <strong>15 days</strong> for examination leave.<br/><br/>You are applying for <strong>"+noOfDays+" days.</strong><br/><br/>Kindly adjust the date of your leave to continue.</p>");
                    $('.noOfDays').val("");
                } else {
                    proceedStandardLeave(noOfDays);
                    //$('.noOfDays').val(noOfDays);    
                }             
            }
        });
    });
    function proceedStandardLeave(noOfDays){
        var staff_id = $('.staff_id').val();
        var start_date = $('.startDate').val();
        var end_date = $('.endDate').val();
        var data = {
            staff_id : staff_id,
            start_date : start_date,
            end_date : end_date
        }
        
        $.ajax({
            url	 : 'ajaxpages/leaves/standardleave/validate.php'
            ,type	 : 'POST'
            ,dataType: 'json'
            ,data	 : data
            ,success : function(e){
                if(e.error == 1){
                    bootbox.alert({
                        title: "<span class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</span>", 
                        message: e.message,
                        size: 'large'
                    });
                } else {
                    $('.noOfDays').val(noOfDays);
                }	
            }
            ,error	: function(e){
            }
        });
    }                            
    $('.daterange').keypress(function(e) {
        e.preventDefault();
    });

    // Daterange Picker PLUS Computation of Date Difference between two chosen dates, Adding of Internal Leave, Adding of Overtime
    $(function() {
        $('.addDateRange').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            $(".startDate").val(start.format('YYYY-MM-DD'));
            $('.endDate').val(end.format('YYYY-MM-DD'));
            $('.noOfDays').val("");
            //Number of days computation here...
            var start_date = $('.startDate').val();
            var today = $('#today').val();
            var end_date = $('.endDate').val();
            var diff =  Math.floor(( Date.parse(end_date) - Date.parse(start_date) ) / 86400000);
            var noOfDays = diff + 1;
            $('.noOfDays').val(noOfDays);
            if(noOfDays > 0) {
                proceedDelegation();
            }
        });
    });
    function proceedDelegation(){
        var staff_id = $('.staffIdTo').val();
        var start_date = $('.startDate').val();
        var end_date = $('.endDate').val();
        var data = {
            staff_id : staff_id,
            start_date : start_date,
            end_date : end_date
        }
        
        $.ajax({
            url	 : 'ajaxpages/delegations/validations/validate.php'
            ,type	 : 'POST'
            ,dataType: 'json'
            ,data	 : data
            ,success : function(e){
                if(e.error == 1){
                    $('.noOfDays').val("");
                    bootbox.alert({
                        title: "<span class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</span>", 
                        message: e.message,
                        size: 'large'
                    });
                    return false;
                } else {
                    //$('.noOfDays').val(noOfDays);
                    return true;
                }	
            }
            ,error	: function(e){
            }
        });
    }                            
    $('.addDateRange').keypress(function(e) {
        e.preventDefault();
    });

</script>