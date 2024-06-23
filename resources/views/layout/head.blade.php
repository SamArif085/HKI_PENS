<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>HKI PENS | @if (isset($title_content))
        {{ $title_content }}
        @endif
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('images/logo-web.jpg') }}">
    <link rel="icon" href="{{ asset('images/logo-web.jpg') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/quill/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/simple-datatables/style.css') }}">

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.7/datatables.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .form-label {
            color: white;
        }

        .my-custom-popup-class {
            width: 85% !important;
            max-height: 85vh;
            overflow-y: auto;
        }

        .my-custom-popup-class-edit-ktp {
            width: 50% !important;
            /* max-height: 65vh; */
            overflow-y: auto;
        }

        .my-custom-popup-class-edit-dokumen {
            width: 65% !important;
            max-height: 85vh;
            overflow-y: auto;
        }

        .my-custom-content-class {
            width: 1000px !important;
        }

        .my-custom-content-class {
            width: 100% !important;
        }

        .swal2-popup .form-control {
            font-size: 15px;

        }

        .modal-dialog {
            max-width: 80%;

            width: 50%;

        }

        .modal-body {
            max-height: 70vh;

            overflow-y: auto;

        }

        .swal2-popup1 {
            width: 50%;
            height: 50%;
            max-height: 70vh;
            padding: 0;
            margin: 0;
            background: white;
            overflow-y: auto;
        }

        .swal2-content {
            background: transparent;
            text-align: center;
            color: white;
            margin-top: 20px;
        }

        .swal2-content img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .status-section {
            float: right;
            margin-top: 10px;
            margin-right: 10px;
        }
    </style>
</head>
