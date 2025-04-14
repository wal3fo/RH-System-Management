<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf_token" content="{{ csrf_token() }}">
  
  <title>RH | PORTAL</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" async>
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" async>
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" async>

  <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2/css/bootstrap.min.css') }}" async>
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" async>

  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/themes/bs4/bootstrap-4.min.css') }}" async>
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" async>

  <link rel="stylesheet" href="{{ asset('assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}" async>

  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}" async>
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" async>

  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}" async>

  <style type="text/css">
    .dark-mode .timeline>div>.timeline-item>.timeline-header {
      border: none !important;
    }

    .dark-mode a:not(.btn):hover {
      color: #ffffff;
    }

    .card-body::after, .card-footer::after, .card-header::after {
      content: none;
    }

    .form-select:focus, .form-select:active {
      box-shadow: none;
    }

    .badge {
      font-weight: 500;
    }

    .modal-header {
      padding: .5rem 1rem;
      align-items: center;
    }

    .modal-title {
      font-size: 1.2rem;
    }

    [class*=icheck-]>input:first-child:disabled+label {
      opacity: 1;
    }

    .bootstrap-select>.dropdown-toggle {
      z-index: 1000;
      background: transparent !important;
      border-radius: 0rem !important;

      border: 1px solid #ced4da;
      border-radius: .25rem !important;
      box-shadow: inset 0 0 0 transparent;
    }

    .bootstrap-select>.dropdown-toggle:focus {
      border: none !important;
      box-shadow: none !important;
    }

    .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
      width: 0rem;
    }

    .preloader {
      background-color: #FFF;
    }

    .dropdown-menu {
      z-index: 2000;
    }

    .dropdown-item.active, .dropdown-item:active {
      color: #fff;
      text-decoration: none;
      background-color: #343a40;
    }

    .datepicker {
        padding: .5rem;
        margin-top: 1px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        direction: ltr;
    }

    .no-sort::after,.no-sort::before {
      display: none !important;
    }

    .no-sort {
      pointer-events: none !important;
      cursor: default !important;
    }

    table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled) {
      padding-right: 10px; 
    }

    .btn.disabled, .btn:disabled {
      opacity: 1;
      box-shadow: none;
    }

    .page-item.active .page-link {
      background-color: #3d9970;
      border-color: #3d9970;
    }

    .page-link {
      padding: .25rem .5rem;
      line-height: 1;
    }

    .timeline::before {
      border-radius: .25rem;
      background-color: #dee2e6;
      bottom: 15px;
      content: "";
      left: 31px;
      margin: 0;
      position: absolute;
      top: 0;
      width: 4px;
    }

    .timeline>div {
      margin-bottom: 15px;
      margin-right: 0px; 
      position: relative;
    }

    .timeline>div>.timeline-item {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        border-radius: .25rem;
        background-color: #fff;
        color: #495057;
        margin-left: 30px;
        margin-right: 0px; 
        margin-top: 0;
        padding: 0;
        position: relative;
    }

    .timeline::before {
        border-radius: .25rem;
        background-color: #dee2e6;
        bottom: 15px;
        content: "";
        left: 5px;
        margin: 0;
        position: absolute;
        top: 0;
        width: 4px;
    }

    .timeline>div>.fa, .timeline>div>.fab, .timeline>div>.fad, .timeline>div>.fal, .timeline>div>.far, .timeline>div>.fas, .timeline>div>.ion, .timeline>div>.svg-inline--fa {
        background-color: #adb5bd;
        border-radius: 50%;
        font-size: 16px;
        height: 30px;
        left: -8px;
        line-height: 30px;
        position: absolute;
        text-align: center;
        top: 0;
        width: 30px;
    }

    .animation__wobble {
      width: 25%;
      height: 50%;
      box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0) !important;
    }

    .form-label {
        font-weight: 500 !important;
        font-size: .8rem;
        letter-spacing: .05rem;
        margin-bottom: .25rem;
    }

    .content-header {
      padding: .5rem;
    }

    .table td, .table th {
      padding: .5rem !important;
      vertical-align: middle;
    }

    thead tr th {
      font-size: .8rem;
      letter-spacing: .05rem;
      text-transform: uppercase;
    }

    tbody tr td {
      font-size: 80%;
      font-weight: 400;
    }

    table.dataTable {
        border-collapse: collapse !important;
    }

    div.dataTables_wrapper div.dataTables_info {
        padding-top: .5em;
        font-size: 80%;
    }

    div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dt-buttons {
        font-size: 80%;
        margin-top: .5rem;
        margin-right: .5rem;
        margin-left: .5rem;
    }

    div.dataTables_wrapper div.dataTables_filter > label, div.dataTables_wrapper div.dataTables_length > label {
      margin-bottom: 0;
    }

    div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
        font-size: 80%;
        margin-bottom: .5rem;
        margin-right: .5rem;
        margin-left: .5rem;
    }

    .nav-tabs .nav-link {
      color: #495057;
      margin-bottom: -1px;
      border: 1px solid transparent;
      border-top-left-radius: 0rem;
      border-top-right-radius: 0rem;
      text-transform: uppercase;
    }

    .w-1 {
      width: 1%;
    }

    #calendar .datepicker-inline {
      width: 100%;
    }

    #calendar .datepicker > div {
      width: -webkit-fill-available;
    }

    #calendar .datepicker table {
      width: 100%;
    }

    #calendar .datepicker table tbody tr td {
      font-size: 100%;
    }

    #calendar .datepicker thead tr:first-child th:hover, .datepicker tfoot tr:first-child th:hover {
        color: #fff;
        background: #42494f;
    }

    #calendar .datepicker table tr td.day:hover {
      color: #fff;
      background: #42494f;
      cursor: pointer;
    }

    #calendar .datepicker table tr td.active {
      color: #fff;
      background: #3d9970;
    }

    #calendar .datepicker td, .datepicker th {
      text-align: center;
      width: 10px;
      height: 20px;
    }

    #calendar .datepicker table tr td span:hover {
      background: #42494f;
    }

    #calendar .datepicker table tr td span.active {
      color: #fff;
      background: #fd821c;
    }

    .timeline>div>.timeline-item>.time, .timeline>div>.timeline-item>.timeline-header{
      padding: 5px;
    }

    .timeline>div>.timeline-item {
      box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0px 0 2px rgba(0, 0, 0, .2);
    }

    .timeline::before {
      bottom: 50px;
      background-color: #e9ecef;
    }

    .bg-gradient-orange, .bg-gradient-lime, .bg-orange {
      color: #fff !important;
    }

    .box-profile .img-fluid {
      width: 8rem;
      height: 8rem;
      padding: .2rem;
      object-fit: cover;
      background: #ffffff;
      border-radius: .2rem;
    }

    .nav-pills li:not(.nav-header):not(:last-of-type) {
      border-bottom: 1px solid #2d3135;
      box-shadow: 0 1px 0px 0px #3b434b;
      margin-top: 4px;
    }

    .nav-pills .nav-header {
      background: #2d3137;
      border-radius: .25rem;
      text-transform: uppercase;
      letter-spacing: .05rem;
      margin-top: 2px;
    }

    .dark-mode hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid rgb(113 113 113 / 70%);
    }

    .dark-mode.login-page {
      background-color: #262a2e !important;
      color: #fff;
    }

    a {
      color: #3d9970;
    }

    a:hover {
      color: #2d875f;
      text-decoration: none;
    }

    .ribbon-wrapper .ribbon {
      top: 14px;
      right: 0px;
    }

    .ribbon-wrapper .ribbon::after, .ribbon-wrapper .ribbon::before {
        border-top: 0px solid #9e9e9e;
      }

    .pace .pace-progress {
      height: .25rem;
    }

    [class*=icheck-]>input:first-child+input[type=hidden]+label::before, [class*=icheck-]>input:first-child+label::before {
      border-radius: .25rem;
    }

    .table>:not(:last-child)>:last-child>* {
      border-width: 1px;
    }

    .dataTables_paginate .page-link {
      color: #343a40;
    }

    .btn-close {
      background-size: .85em;
    }

    .dataTables_paginate .page-link:focus, .dataTables_paginate .page-link:active, .btn-close:focus {
      box-shadow: none;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected], .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
        background-color: #2e7555;
        color: #fff;
    }

    [class*=sidebar-dark] .brand-link {
      border-bottom: 1px solid #3d9970;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }

    hr:not([size]) {
      height: 0px;
    }
  </style>
</head>