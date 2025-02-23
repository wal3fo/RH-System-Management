@php use App\Models\Functions; @endphp

<script src="{{ asset('resources/assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('resources/assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/jasonday-printThis/printThis.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/pace-progress/pace.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/fontawesome/js/pro.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('resources/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('resources/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="{{ asset('resources/assets/js/adminlte.js') }}"></script>

<!-- <script src="{{ asset('resources/assets/js/waveaus.js') }}"></script> -->

<script type="text/javascript">
$(document).ready(function() {
    $('.preloader').addClass('d-none');
    $('body').addClass('pace-olive');

  setInterval(function() {
      $('form').find('input, textarea').each(function() {
          if (!$(this).prop('readonly') && !$(this).val()) {
              if ($(this).is(':checkbox') || $(this).is(':radio')) {
                  $(this).prop('checked', false);
              } else {
                  $(this).val('');
              }
          }
      });
  }, 1500);

  $(document).on('keydown', 'input[pattern]', function(e){
    var input = $(this);
    var oldVal = input.val();
    var regex = new RegExp(input.attr('pattern'), 'g');

    setTimeout(function(){
      var newVal = input.val();
      if(!regex.test(newVal)){
        input.val(oldVal); 
      }
    }, 1);
  });

  setInterval(function() {
    $('#calendarjquery').html('{{ @Functions::getActualCalendar() }}');
  }, 1000);

  $('[data-mask]').inputmask();

  $('.select2picker').select2({ width: '100%' });

  $('#calendar').datepicker({inline:true});

  $('#start_requestDate').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayBtn: true
  }).datepicker("setDate", new Date());

  $('#start_requestStartDate').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayBtn: true
  }).datepicker("setDate", new Date());

  $('#start_requestEndDate').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayBtn: true
  }).datepicker("setDate", new Date());

  $('#start_requestEditStartDate').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
  });

  $('#start_requestEditEndDate').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
  });

  $('#start_requestCertifPeriod').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
  });

  $('#userNextTimeOfRegister').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
  });
  
  $('#userRegisterTimeOf').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
  }).datepicker("setDate", new Date());

  $("#datatables").DataTable({
    responsive: true, 
    lengthChange: false, 
    autoWidth: false,
    language: {
      url: "{{ asset('resources/assets/js/frTables.js') }}",
    },
    buttons: ["excel", "csv", "print"]
  });

  setTimeout(function() {
    $("#datatables").DataTable().buttons().container().appendTo('#datatables_wrapper .col-md-6:eq(0)');
  }, 1024);

  const $start_unlinkUser = $('.start_unlinkUser');
  $start_unlinkUser.on('click', function(e) {
    const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserId = $(this).attr('data-user');
      const $SeniorId = $(this).attr('data-senior');

      formData.append('UserId', $UserId);
      formData.append('SeniorId', $SeniorId);

      sendAjaxRequest('/handleUnlinkUsers', formData, $actionButton, originalText);
  });

  const $start_linkUsers = $('#start_linkUsers');
  $start_linkUsers.on('click', function(e) {
    const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $SeniorId = $('#start_linkSeniorId');
      const $ListUsers = $('#start_linkListUsers');

      formData.append('SeniorId', $SeniorId.val());
      formData.append('ListUsers', $ListUsers.val());

      sendAjaxRequest('/handleLinkUsers', formData, $actionButton, originalText);
  });

  const $start_printCertificate = $('#start_printCertificate');
  $start_printCertificate.on('click', function(e) {
      const $actionButton = $('#containerPrint');

      if($actionButton !== null) {
        $actionButton.printThis();
      }
  });

  const $userStart_AvatarPicker = $('#userSettingAvatarPicker');
  $userStart_AvatarPicker.on('click', function(e) {
      const $actionButton = $('#userSettingAvatar');
      $actionButton.trigger("click");
  });

  const $userStart_UserAvatar = $('#userSettingAvatar');
  $userStart_UserAvatar.on('change', function (e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      const $userTarget = $(this).attr('data-user');

      const formData = new FormData();

      const reader = new FileReader();

      reader.onload = (e) => {
        $avatarPreviewer = $('#avatarPreviwer');
          
          $avatarPreviewer.attr('src', e.target.result);

        formData.append('userTarget', $userTarget);
          formData.append('userAvatarUpdate', this.files[0]);

          sendAjaxRequest('/handleUserAvatarUpdate', formData, $actionButton, originalText);
      }

      reader.readAsDataURL(this.files[0]);
  });

  const $userStart_SignIn = $('#userStart_SignIn');
  $userStart_SignIn.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserEmail = $('#userLoginEmail');
      const $UserPassword = $('#userLoginPassword');

      formData.append('UserEmail', $UserEmail.val());
      formData.append('UserPassword', $UserPassword.val());

      sendAjaxRequest('/handleUserSignIn', formData, $actionButton, originalText);
  });

  const $userStart_SignUp = $('#userStart_SignUp');
  $userStart_SignUp.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserName = $('#userRegisterName');
      const $UserEmail = $('#userRegisterEmail');

      const $UserSerial = $('#userRegisterSerial');
      const $UserInsurance = $('#userRegisterInsurance');

      const $UserCIN = $('#userRegisterCIN');
      const $UserPhone = $('#userRegisterPhone');

      const $UserBalance = $('#userRegisterBalance');
      const $UserTimeOfRegister = $('#userRegisterTimeOf');

      const $UserWorkJob = $('#userRegisterWorkJob');
      const $UserWorkFunction = $('#userRegisterWorkFunction');

      const $UserPassword = $('#userRegisterPassword');
      const $User2Password = $('#userRegister2Password');

      formData.append('UserName', $UserName.val());
      formData.append('UserEmail', $UserEmail.val());
      formData.append('UserSerial', $UserSerial.val());
      formData.append('UserInsurance', $UserInsurance.val());
      formData.append('UserCIN', $UserCIN.val());
      formData.append('UserPhone', $UserPhone.val());
      formData.append('UserWorkJob', $UserWorkJob.val());
      formData.append('UserBalance', $UserBalance.val());
      formData.append('UserWorkFunction', $UserWorkFunction.val());
      formData.append('UserPassword', $UserPassword.val());
      formData.append('User2Password', $User2Password.val());
      formData.append('UserTimeOfRegister', $UserTimeOfRegister.val());

      sendAjaxRequest('/handleUserSignUp', formData, $actionButton, originalText);
  });

  const $userStart_updateUser = $('#userStart_updateUser');
  $userStart_updateUser.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserId = $(this).attr('data-user');

      const $UserName = $('#userNextName');
      const $UserEmail = $('#userNextEmail');

      const $UserSerial = $('#userNextSerial');
      const $UserInsurance = $('#userNextInsurance');

      const $UserBalance = $('#userNextBalance');
      const $UserTimeOfRegister = $('#userNextTimeOfRegister');

      const $UserCIN = $('#userNextCIN');
      const $UserPhone = $('#userNextPhone');

      const $UserWorkJob = $('#userNextWorkJob');
      const $UserWorkFunction = $('#userNextWorkFunction');

      const $UserPassword = $('#userNextPassword');
      const $User2Password = $('#userNext2Password');

      formData.append('UserId', $UserId);
      formData.append('UserName', $UserName.val());
      formData.append('UserEmail', $UserEmail.val());
      formData.append('UserSerial', $UserSerial.val());
      formData.append('UserInsurance', $UserInsurance.val());
      formData.append('UserCIN', $UserCIN.val());
      formData.append('UserPhone', $UserPhone.val());
      formData.append('UserWorkJob', $UserWorkJob.val());
      formData.append('UserBalance', $UserBalance.val());
      formData.append('UserWorkFunction', $UserWorkFunction.val());
      formData.append('UserTimeOfRegister', $UserTimeOfRegister.val());

      if($UserPassword.val() && $User2Password.val()) {
      	formData.append('UserPassword', $UserPassword.val());
      	formData.append('User2Password', $User2Password.val());
	  }

      sendAjaxRequest('/handleUserUpdate', formData, $actionButton, originalText);
  });

  const $userStart_SignOut = $('#userStart_SignOut');
  $userStart_SignOut.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      sendAjaxRequest('/handleUserSignOut', formData, $actionButton, originalText);
  });

  const $userStart_DeleteUser = $('#userStart_DeleteUser');
  $userStart_DeleteUser.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserId = $(this).attr('data-user');

      formData.append('UserId', $UserId);

      sendAjaxRequest('/handleUserDelete', formData, $actionButton, originalText);
  });

  const $userStart_RestoreUser = $('#userStart_RestoreUser');
  $userStart_RestoreUser.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $UserId = $(this).attr('data-user');

      formData.append('UserId', $UserId);

      sendAjaxRequest('/handleUserRestore', formData, $actionButton, originalText);
  });

  const $start_editRequest = $('.start_editRequest');
  $start_editRequest.on('click', function(e) {
      const $actionModal = $('#mdStatusValidator');

      if($actionModal) {
        $Parent = $(this).closest('tr');
        $StatusField = $Parent.find('.senior__status__field').text();
        $PrefixField = $Parent.find('.senior__prefix__field').text();

        $actionModal.find('#request_Status').val($StatusField).trigger('change');
        $actionModal.find('#request_Prefix').text($PrefixField);

        $requestId = $(this).attr('data-iue');
        $updateButton = $('#start_updateRequest');

        if($requestId !== null && $updateButton !== null) {
          $updateButton.attr('data-sue', $requestId);
          $actionModal.modal('show');
        }
      }
  });

  const $start_editUserVRequest = $('.start_editUserVRequest');
  $start_editUserVRequest.on('click', function(e) {
      const $actionModal = $('#mdEditVacation');

      if($actionModal) {
        $Parent = $(this).closest('tr');

        $StartDateField = $Parent.find('.start__date__field').val();
        $EndDateField = $Parent.find('.end__date__field').val();

        $PrefixField = $Parent.find('.prefix__field').val();

        $TypeField = $Parent.find('.type__field').val();
        $HalfField = $Parent.find('.half__field').val();

        $('#start_requestEditStartDate').datepicker('setDate', new Date($StartDateField));
        $('#start_requestEditEndDate').datepicker('setDate', new Date($EndDateField));

        $('#start_requestEditType').val($TypeField).trigger('change');
        $('#start_requestEditPrefix').val($PrefixField).trigger('change');

        $('#start_editHalfRequest').prop('checked', $HalfField == 1);

        $requestId = $(this).attr('data-iue');
        $updateButton = $('#start_updateUserVRequest');

        if($requestId !== null && $updateButton !== null) {
          $updateButton.attr('data-sue', $requestId);
          $actionModal.modal('show');
        }
      }
  });

  const $start_updateUserVRequest = $('#start_updateUserVRequest');
  $start_updateUserVRequest.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestId = $(this).attr('data-sue');
      const $RequestStartDate = $('#start_requestEditStartDate');
      const $RequestEndDate = $('#start_requestEditEndDate');
      const $RequestPrefix = $('#start_requestEditPrefix');
      const $RequestType = $('#start_requestEditType');
      const $RequestIsHalf = $('#start_editHalfRequest');

      formData.append('RequestId', $RequestId);
      formData.append('RequestStartDate', $RequestStartDate.val());
      formData.append('RequestEndDate', $RequestEndDate.val());
      formData.append('RequestPrefix', $RequestPrefix.val());
      formData.append('RequestType', $RequestType.val());
      formData.append('RequestIsHalf', $RequestIsHalf.prop('checked') ? 1 : 0);

      sendAjaxRequest('/handleRequestUpdateV', formData, $actionButton, originalText);
  });

  const $start_createRequestV = $('#start_createRequestV');
  $start_createRequestV.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestType = $('#start_requestType');
      const $RequestStartDate = $('#start_requestStartDate');
      const $RequestEndDate = $('#start_requestEndDate');
      const $RequestPrefix = $('#start_requestPrefix');
      const $RequestCategory = $('#start_requestCategory');
      const $RequestIsHalf = $('#start_createHalfRequest');

      formData.append('RequestType', $RequestType.val());
      formData.append('RequestStartDate', $RequestStartDate.val());
      formData.append('RequestEndDate', $RequestEndDate.val());
      formData.append('RequestPrefix', $RequestPrefix.val());
      formData.append('RequestCategory', $RequestCategory.val());

      formData.append('RequestIsHalf', $RequestIsHalf.prop('checked') ? 1 : 0);

      sendAjaxRequest('/handleRequestCreateV', formData, $actionButton, originalText);
  });

  const $start_createRequestA = $('#start_createRequestA');
  $start_createRequestA.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestType = $('#start_requestType');
      const $RequestDate = $('#start_requestDate');
      const $RequestPrefix = $('#start_requestPrefix');
      const $RequestCategory = $('#start_requestCategory');
      const $RequestLocation = $('#start_requestLocation');
      const $RequestLeaveHours = $('#start_requestLeaveHours');
      const $RequestEnterHours = $('#start_requestEnterHours');

      formData.append('RequestType', $RequestType.val());
      formData.append('RequestDate', $RequestDate.val());
      formData.append('RequestPrefix', $RequestPrefix.val());
      formData.append('RequestCategory', $RequestCategory.val());
      formData.append('RequestLocation', $RequestLocation.val());
      formData.append('RequestLeaveHours', $RequestLeaveHours.val());
      formData.append('RequestEnterHours', $RequestEnterHours.val());

      sendAjaxRequest('/handleRequestCreateA', formData, $actionButton, originalText);
  });

  const $start_editUserARequest = $('.start_editUserARequest');
  $start_editUserARequest.on('click', function(e) {
      const $actionModal = $('#mdEditAbsence');

      if($actionModal) {
        $Parent = $(this).closest('tr');

        $DateField = $Parent.find('.date__field').val();
        $LeaveHoursField = $Parent.find('.leave__hours__field').val();
        $EnterHoursField = $Parent.find('.enter__hours__field').val();
        $PrefixField = $Parent.find('.prefix__field').val();
        $TypeField = $Parent.find('.type__field').val();

        $LocationField = $Parent.find('.location__field').val();

        $('#start_requestEditDate').datepicker('setDate', new Date($DateField));

        $('#start_requestEditLeaveHours').val($LeaveHoursField);
        $('#start_requestEditEnterHours').val($EnterHoursField);

        $('#start_requestEditType').val($TypeField).trigger('change');
        $('#start_requestEditPrefix').val($PrefixField).trigger('change');
        $('#start_requestEditLocation').val($LocationField).trigger('change');

        $requestId = $(this).attr('data-iue');
        $updateButton = $('#start_updateUserARequest');

        if($requestId !== null && $updateButton !== null) {
          $updateButton.attr('data-sue', $requestId);
          $actionModal.modal('show');
        }
      }
  });

  const $start_updateUserARequest = $('#start_updateUserARequest');
  $start_updateUserARequest.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestId = $(this).attr('data-sue');
      const $RequestType = $('#start_requestEditType');
      const $RequestDate = $('#start_requestEditDate');
      const $RequestPrefix = $('#start_requestEditPrefix');
      const $RequestLocation = $('#start_requestEditLocation');
      const $RequestLeaveHours = $('#start_requestEditLeaveHours');
      const $RequestEnterHours = $('#start_requestEditEnterHours');

      formData.append('RequestId', $RequestId);
      formData.append('RequestType', $RequestType.val());
      formData.append('RequestDate', $RequestDate.val());
      formData.append('RequestLeaveHours', $RequestLeaveHours.val());
      formData.append('RequestEnterHours', $RequestEnterHours.val());
      formData.append('RequestPrefix', $RequestPrefix.val());
      formData.append('RequestLocation', $RequestLocation.val());

      sendAjaxRequest('/handleRequestUpdateA', formData, $actionButton, originalText);
  });

  const $start_updateRequest = $('#start_updateRequest');
  $start_updateRequest.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestId = $(this).attr('data-sue');
      const $RequestStatus = $('#request_Status');
      const $RequestPrefix = $('#request_Prefix');

      formData.append('RequestId', $RequestId);
      formData.append('RequestStatus', $RequestStatus.val());
      formData.append('RequestPrefix', $RequestPrefix.val());

      sendAjaxRequest('/handleRequestUpdate', formData, $actionButton, originalText);
  });

  const $start_createRequestCertif = $('#start_createRequestCertif');
  $start_createRequestCertif.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestType = $('#start_requestCertifType');
      const $RequestPrefix = $('#start_requestCertifPrefix');
      const $RequestPeriod = $('#start_requestCertifPeriod');

      formData.append('RequestType', $RequestType.val());
      formData.append('RequestPrefix', $RequestPrefix.val());

      if($RequestPeriod.val()) {
        formData.append('RequestPeriod', $RequestPeriod.val());
      }
      sendAjaxRequest('/handleRequestCreateC', formData, $actionButton, originalText);
  });

  const $start_editUserCRequest = $('.start_editUserCRequest');
  $start_editUserCRequest.on('click', function(e) {
    const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $RequestId = $(this).attr('data-iue');

      formData.append('RequestId', $RequestId);
      sendAjaxRequest('/handleRequestUpdateC', formData, $actionButton, originalText);
  });

  const $start_requestCertifType = $('#start_requestCertifType');
  $start_requestCertifType.on('change', function(e) {
    var selectedValues = $(this).val();
    var requiredValues = [
      'Bulletin de Paie',
      'BDS'
    ];

    if (!Array.isArray(selectedValues)) {
      selectedValues = [selectedValues];
    }

    var latestSelected = selectedValues.slice(-2);

    if (latestSelected.some(value => requiredValues.includes(value))) {
      $('#periodSection').removeClass('d-none');
    } else {
      $('#periodSection').addClass('d-none');
    }
  });

  const $start_uploadHolidays = $('#start_uploadHolidays');
  $start_uploadHolidays.on('click', function(e) {
      const $actionButton = $('#companyHolidays');
      $actionButton.trigger("click");
  });

  const $companyHolidays = $('#companyHolidays');
  $companyHolidays.on('change', function (e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      const formData = new FormData();

      formData.append('excelHolidays', this.files[0]);

      sendAjaxRequest('/handleHolidaysUpdate', formData, $actionButton, originalText);
  });

  const $start_deleteUserFunction = $('.start_deleteUserFunction');
  $start_deleteUserFunction.on('click', function(e) {
      const $actionModal = $('#mdDeleteFunction');

      if($actionModal) {
        $Parent = $(this).closest('tr');
        $FunctionField = $Parent.find('.job__function__field').val();

        $functionId = $(this).attr('data-iue');
        $updateButton = $('#start_removeUserFunction');
        $updateTarget = $('#to_delete_function_field');

        if($functionId !== null && $updateButton !== null && $updateTarget !== null) {
          $updateButton.attr('data-sue', $functionId);
          $updateTarget.text($FunctionField);
          $actionModal.modal('show');
        }
      }
  });

  const $start_editUserFunction = $('.start_editUserFunction');
  $start_editUserFunction.on('click', function(e) {
      const $actionModal = $('#mdEditFunction');

      if($actionModal) {
        $Parent = $(this).closest('tr');

        $WorkJobField = $Parent.find('.job__work__job__field').val();
        $FunctionField = $Parent.find('.job__function__field').val();
        $ValidatorField = $Parent.find('.job__validator__field').val();
        $DepartmentField = $Parent.find('.job__department__field').val();
        $SuperAdminField = $Parent.find('.job__super__admin__field').val();

        $('#start_functionEditLabel').val($FunctionField);
        $('#start_functionEditDepartment').val($DepartmentField);
        $('#start_functionEditWorkJob').val($WorkJobField).trigger('change');
        $('#start_functionEditValidator').val($ValidatorField).trigger('change');

        if($SuperAdminField == 1) {
          $('#start_functionEditSuperAdmin').prop('checked', true);
        } else {
          $('#start_functionEditSuperAdmin').prop('checked', false);
        }

        $functionId = $(this).attr('data-iue');
        $updateButton = $('#start_updateUserFunction');

        if($functionId !== null && $updateButton !== null) {
          $updateButton.attr('data-sue', $functionId);

          $actionModal.modal('show');
        }
      }
  });

  const $start_createUserFunction = $('#start_createUserFunction');
  $start_createUserFunction.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $FunctionLabel = $('#start_functionLabel');
      const $FunctionWorkJob = $('#start_functionWorkJob');
      const $FunctionValidator = $('#start_functionValidator');
      const $FunctionDepartment = $('#start_functionDepartment');
      const $FunctionSuperAdmin = $('#start_functionSuperAdmin');

      formData.append('FunctionLabel', $FunctionLabel.val());
      formData.append('FunctionWorkJob', $FunctionWorkJob.val());
      formData.append('FunctionDepartment', $FunctionDepartment.val());
      formData.append('FunctionSuperAdmin', $FunctionSuperAdmin.prop('checked') ? 1 : 0);
      formData.append('FunctionValidator', $FunctionValidator.val() ? $FunctionValidator.val() : 0);

      sendAjaxRequest('/handleFunctionCreate', formData, $actionButton, originalText);
  });

  const $start_updateUserFunction = $('#start_updateUserFunction');
  $start_updateUserFunction.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $FunctionId = $(this).attr('data-sue');
      const $FunctionLabel = $('#start_functionEditLabel');
      const $FunctionWorkJob = $('#start_functionEditWorkJob');
      const $FunctionValidator = $('#start_functionEditValidator');
      const $FunctionDepartment = $('#start_functionEditDepartment');
      const $FunctionSuperAdmin = $('#start_functionEditSuperAdmin');

      formData.append('FunctionId', $FunctionId);
      formData.append('FunctionLabel', $FunctionLabel.val());
      formData.append('FunctionWorkJob', $FunctionWorkJob.val());
      formData.append('FunctionValidator', $FunctionValidator.val());
      formData.append('FunctionSuperAdmin', $FunctionSuperAdmin.prop('checked') ? 1 : 0);
      formData.append('FunctionDepartment', $FunctionDepartment.val() ? $FunctionDepartment.val() : 0);

      sendAjaxRequest('/handleFunctionUpdate', formData, $actionButton, originalText);
  });

  const $start_removeUserFunction = $('#start_removeUserFunction');
  $start_removeUserFunction.on('click', function(e) {
      const $actionButton = $(this);
      const originalText = $actionButton.html();

      disableActionButton($actionButton);

      var formData = new FormData();

      const $FunctionId = $(this).attr('data-sue');

      formData.append('FunctionId', $FunctionId);

      sendAjaxRequest('/handleFunctionRemove', formData, $actionButton, originalText);
  });

  function sendAjaxRequest($url, $data, $actionButton, $originalText) {
      const $csrf_token = $('meta[name="csrf_token"]').attr('content');

      $.ajax({
          url: $url,
          type: 'POST',
          data: $data,
          enctype: 'multipart/form-data',
          dataType: 'json',
          contentType: false,
          processData: false,
          cache: false,
          headers: {
              'X-CSRF-TOKEN': $csrf_token
          },
          success: async function(data, status, xhr) {
              sendAlertRequest(data);
          },
          error: function(jqXhr, textStatus, errorMessage) {
              sendAlertRequest(jqXhr);
          },
          complete: function() {
              if($actionButton !== null) {
                  enableActionButton($actionButton, $originalText);
              }
          }
      });
  }

  function disableActionButton($actionButton) {
      if($actionButton !== null) {
          $actionButton.html('<i class="fas fa-spinner fa-spin me-1"></i> Traitement').prop('disabled', true);
      }
  }

  function enableActionButton($actionButton, $originalText) {
      if($actionButton !== null) {
          $actionButton.html($originalText).prop('disabled', false);
      }
  }

  function sendAlertRequest(data) {
    try {
        var Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 1500
        });

        if (data.success) {
            return Toast.fire({ icon: 'success', title: data.success }).then(function() {
                const $redirect = data.redirect;
                if($redirect !== undefined) {
                  if($redirect !== false) {
                      location.replace($redirect);
                  }
                } else {
                    location.reload();
                }
            });
        }

        if (data.redirect) {
          return location.replace(data.redirect);
        }

        if (data.warning) {
            return Toast.fire({ icon: 'warning', title: data.warning });
        }

        if (data.errors) {
            return Toast.fire({ icon: 'error', title: data.errors });
        }

        return Toast.fire({ icon: 'warning', title: data.responseJSON.message });
    } catch (error) { }
  }
});
</script>