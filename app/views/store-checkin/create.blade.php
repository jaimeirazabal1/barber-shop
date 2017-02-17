<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>{{ $store->name }} - {{ $companyo->name }}</title>

    <meta name="description" content="AppUI Frontend is a Responsive Bootstrap Site Template created by pixelcave and added as a bonus in AppUI Admin Template package">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/frontend/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon57.png') }}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon72.png') }}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon114.png') }}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon144.png') }}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/img/icon180.png') }}" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/plugins.css') }}">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/main.css') }}">

    <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/themes.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/flipclock/flipclock.css') }}">
    <!-- END Stylesheets -->

    <!-- Modernizr (browser feature detection library) -->
    <script src="{{ asset('assets/frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('vendors/animate.css/animate.css') }}">


    <style>
        body {
            background: #fff;
        }

        /*
==============================================
(#15s2s) Select2
==============================================
*/

        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 8px;
            padding-right: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
            padding-right: 8px;
            padding-left: 20px;
        }
        .select2-container .select2-selection--multiple {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            min-height: 32px;
            user-select: none;
            -webkit-user-select: none;
        }
        .select2-container .select2-selection--multiple .select2-selection__rendered {
            display: inline-block;
            overflow: hidden;
            padding-left: 8px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .select2-container .select2-search--inline {
            float: left;
        }
        .select2-container .select2-search--inline .select2-search__field {
            box-sizing: border-box;
            border: none;
            font-size: 100%;
            margin-top: 5px;
        }
        .select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button {
            -webkit-appearance: none;
        }
        .select2-dropdown {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            z-index: 1051;
        }
        .select2-results {
            display: block;
        }
        .select2-results__options {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .select2-results__option {
            padding: 6px;
            user-select: none;
            -webkit-user-select: none;
        }
        .select2-results__option[aria-selected] {
            cursor: pointer;
        }
        .select2-container--open .select2-dropdown {
            left: 0;
        }
        .select2-container--open .select2-dropdown--above {
            border-bottom: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .select2-container--open .select2-dropdown--below {
            border-top: none;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .select2-search--dropdown {
            display: block;
            padding: 4px;
        }
        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .select2-search--dropdown .select2-search__field::-webkit-search-cancel-button {
            -webkit-appearance: none;
        }
        .select2-search--dropdown.select2-search--hide {
            display: none;
        }
        .select2-close-mask {
            border: 0;
            margin: 0;
            padding: 0;
            display: block;
            position: fixed;
            left: 0;
            top: 0;
            min-height: 100%;
            min-width: 100%;
            height: auto;
            width: auto;
            opacity: 0;
            z-index: 99;
            background-color: #fff;
            filter: alpha(opacity=0);
        }
        .select2-hidden-accessible {
            border: 0 !important;
            clip: rect(0 0 0 0) !important;
            height: 1px !important;
            margin: -1px !important;
            overflow: hidden !important;
            padding: 0 !important;
            position: absolute !important;
            width: 1px !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            cursor: pointer;
            float: right;
            font-weight: bold;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #999;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
        }
        .select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear {
            float: left;
        }
        .select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow {
            left: 1px;
            right: auto;
        }
        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #eee;
            cursor: default;
        }
        .select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear {
            display: none;
        }
        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #888 transparent;
            border-width: 0 4px 5px 4px;
        }
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: text;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0 5px;
            width: 100%;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #999;
            margin-top: 5px;
            float: left;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__clear {
            cursor: pointer;
            float: right;
            font-weight: bold;
            margin-top: 5px;
            margin-right: 10px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #999;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            margin-right: 2px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #333;
        }
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder,
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline {
            float: right;
        }
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
            margin-left: 5px;
            margin-right: auto;
        }
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
            margin-left: 2px;
            margin-right: auto;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid black 1px;
            outline: 0;
        }
        .select2-container--default.select2-container--disabled .select2-selection--multiple {
            background-color: #eee;
            cursor: default;
        }
        .select2-container--default.select2-container--disabled .select2-selection__choice__remove {
            display: none;
        }
        .select2-container--default.select2-container--open.select2-container--above .select2-selection--single,
        .select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .select2-container--default.select2-container--open.select2-container--below .select2-selection--single,
        .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
        }
        .select2-container--default .select2-search--inline .select2-search__field {
            background: transparent;
            border: none;
            outline: 0;
            box-shadow: none;
        }
        .select2-container--default .select2-results > .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }
        .select2-container--default .select2-results__option[role=group] {
            padding: 0;
        }
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #999;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #ddd;
        }
        .select2-container--default .select2-results__option .select2-results__option {
            padding-left: 1em;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__group {
            padding-left: 0;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -1em;
            padding-left: 2em;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -2em;
            padding-left: 3em;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -3em;
            padding-left: 4em;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -4em;
            padding-left: 5em;
        }
        .select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
            margin-left: -5em;
            padding-left: 6em;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #5897fb;
            color: white;
        }
        .select2-container--default .select2-results__group {
            cursor: default;
            display: block;
            padding: 6px;
        }
        .select2-container--classic .select2-selection--single {
            background-color: #f7f7f7;
            border: 1px solid #aaa;
            border-radius: 4px;
            outline: 0;
            background-image: -webkit-linear-gradient(top, white 50%, #eeeeee 100%);
            background-image: -o-linear-gradient(top, white 50%, #eeeeee 100%);
            background-image: linear-gradient(to bottom, white 50%, #eeeeee 100%);
            background-repeat: repeat-x;
        }
        .select2-container--classic .select2-selection--single:focus {
            border: 1px solid #5897fb;
        }
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }
        .select2-container--classic .select2-selection--single .select2-selection__clear {
            cursor: pointer;
            float: right;
            font-weight: bold;
            margin-right: 10px;
        }
        .select2-container--classic .select2-selection--single .select2-selection__placeholder {
            color: #999;
        }
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            background-color: #ddd;
            border: none;
            border-left: 1px solid #aaa;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            height: 26px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            background-image: -webkit-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: -o-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
            background-repeat: repeat-x;
        }
        .select2-container--classic .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -2px;
            position: absolute;
            top: 50%;
            width: 0;
        }
        .select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__clear {
            float: left;
        }
        .select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__arrow {
            border: none;
            border-right: 1px solid #aaa;
            border-radius: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            left: 1px;
            right: auto;
        }
        .select2-container--classic.select2-container--open .select2-selection--single {
            border: 1px solid #5897fb;
        }
        .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow {
            background: transparent;
            border: none;
        }
        .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #888 transparent;
            border-width: 0 4px 5px 4px;
        }
        .select2-container--classic.select2-container--open.select2-container--above .select2-selection--single {
            border-top: none;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            background-image: -webkit-linear-gradient(top, white 0%, #eeeeee 50%);
            background-image: -o-linear-gradient(top, white 0%, #eeeeee 50%);
            background-image: linear-gradient(to bottom, white 0%, #eeeeee 50%);
            background-repeat: repeat-x;
        }
        .select2-container--classic.select2-container--open.select2-container--below .select2-selection--single {
            border-bottom: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            background-image: -webkit-linear-gradient(top, #eeeeee 50%, white 100%);
            background-image: -o-linear-gradient(top, #eeeeee 50%, white 100%);
            background-image: linear-gradient(to bottom, #eeeeee 50%, white 100%);
            background-repeat: repeat-x;
        }
        .select2-container--classic .select2-selection--multiple {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: text;
            outline: 0;
        }
        .select2-container--classic .select2-selection--multiple:focus {
            border: 1px solid #5897fb;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__rendered {
            list-style: none;
            margin: 0;
            padding: 0 5px;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__clear {
            display: none;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__choice {
            background-color: #e4e4e4;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove {
            color: #888;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            margin-right: 2px;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #555;
        }
        .select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
            float: right;
        }
        .select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice {
            margin-left: 5px;
            margin-right: auto;
        }
        .select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
            margin-left: 2px;
            margin-right: auto;
        }
        .select2-container--classic.select2-container--open .select2-selection--multiple {
            border: 1px solid #5897fb;
        }
        .select2-container--classic.select2-container--open.select2-container--above .select2-selection--multiple {
            border-top: none;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .select2-container--classic.select2-container--open.select2-container--below .select2-selection--multiple {
            border-bottom: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .select2-container--classic .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
            outline: 0;
        }
        .select2-container--classic .select2-search--inline .select2-search__field {
            outline: 0;
            box-shadow: none;
        }
        .select2-container--classic .select2-dropdown {
            background-color: white;
            border: 1px solid transparent;
        }
        .select2-container--classic .select2-dropdown--above {
            border-bottom: none;
        }
        .select2-container--classic .select2-dropdown--below {
            border-top: none;
        }
        .select2-container--classic .select2-results > .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }
        .select2-container--classic .select2-results__option[role=group] {
            padding: 0;
        }
        .select2-container--classic .select2-results__option[aria-disabled=true] {
            color: grey;
        }
        .select2-container--classic .select2-results__option--highlighted[aria-selected] {
            background-color: #3875d7;
            color: white;
        }
        .select2-container--classic .select2-results__group {
            cursor: default;
            display: block;
            padding: 6px;
        }
        .select2-container--classic.select2-container--open .select2-dropdown {
            border-color: #5897fb;
        }
        .select2-container .select2-selection--single {
            height: 34px;
        }
        .select2-container .select2-dropdown {
            border-color: #dae0e8;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
        }
        .select2-container--default .select2-selection--single {
            border-color: #dae0e8;
            border-radius: 3px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 8px;
            line-height: 34px;
        }
        .form-material .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }
        .select2-container--default .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #dae0e8;
            border-radius: 3px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered,
        .select2-container--default.select2-container--focus .select2-selection--multiple .select2-selection__rendered {
            padding-right: 8px;
            padding-left: 8px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            height: 22px;
            line-height: 22px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            background-color: #5ccdde;
            border: none;
            border-radius: 3px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            margin-right: 5px;
            color: rgba(255, 255, 255, 0.5);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: rgba(255, 255, 255, 0.75);
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-color: #e6e6e6;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #5ccdde;
        }
        .select2-container--default .select2-search--inline .select2-search__field {
            padding-right: 0;
            padding-left: 0;
            font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        .select2-search--dropdown .select2-search__field {
            padding: 6px 12px;
            font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
            border-radius: 3px;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .select2-container.select2-container--open .select2-dropdown,
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--multiple,
        .select2-container--default.select2-container--focus.select2-container--open .select2-selection--multiple {
            border-color: #5ccdde;
        }

    </style>

</head>
<body>
<!-- Page Container -->
<!-- In the PHP version you can set the following options from inc/config file -->
<!-- 'boxed' class for a boxed layout -->
<div id="page-container">
    <!-- Site Header -->
    <?php /*
    <header>
        <div class="container">
            <!-- Site Logo -->
            <a href="index.html" class="site-logo">
                <i class="fa fa-cube"></i> App<strong>UI</strong>
            </a>
            <!-- END Site Logo -->

            <!-- Site Navigation -->
            <nav>
                <!-- Menu Toggle -->
                <!-- Toggles menu on small screens -->
                <a href="javascript:void(0)" class="btn btn-default site-menu-toggle visible-xs visible-sm">Menu</a>
                <!-- END Menu Toggle -->

                <!-- Main Menu -->
                <ul class="site-nav">
                    <li>
                        <a href="index.html">Welcome</a>
                    </li>
                    <li>
                        <a href="features.html">Features</a>
                    </li>
                    <li>
                        <a href="pricing.html">Pricing</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
                    </li>
                    <li>
                        <a href="ui.html">UI</a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)" class="site-nav-sub"><i class="fa fa-angle-down site-nav-arrow"></i>Pages</a>
                        <ul>
                            <li>
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="blog_post.html">Blog Post</a>
                            </li>
                            <li>
                                <a href="portfolio.html">Portfolio</a>
                            </li>
                            <li>
                                <a href="project.html">Project</a>
                            </li>
                            <li>
                                <a href="team.html">Team</a>
                            </li>
                            <li>
                                <a href="faq.html">FAQ</a>
                            </li>
                            <li>
                                <a href="jobs.html">Jobs</a>
                            </li>
                            <li>
                                <a href="search_results.html">Search Results</a>
                            </li>
                            <li>
                                <a href="page_scroller.html" class="active">Page Scroller</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://pixelcave.com/demo/appui" class="featured">Get Started <i class="fa fa-arrow-right"></i></a>
                    </li>
                </ul>
                <!-- END Main Menu -->
            </nav>
            <!-- END Site Navigation -->
        </div>
    </header>
    <!-- END Site Header -->


    <!-- Intro -->
    <section class="site-section site-section-top site-section-light themed-background-dark">
        <div class="container">
            <h1 class="text-center animation-fadeInQuickInv"><strong>You can easily create a page scroller.</strong></h1>
        </div>
    </section>
    <!-- END Intro -->
 */ ?>
    <!-- Page Scroller Container -->
    <!-- Functionality initialized in js/app.js - uiInit() with vPageScroll, check out examples and documentation at https://github.com/nico-martin/vPageScroll -->
    <!--div class="scroller-container"-->
    <div class="">
        <!-- Page Scroller Navigation, it is auto created and you can specify a Font Awesome icon in each section by using the property 'data-icon' -->
        <!--div class="scroller-nav"></div-->

        <!-- Buttons Title -->
        <section class="site-content site-section-mini themed-background-muted border-top border-bottom">
            <div class="container">
                <h2 class="site-heading h3 site-block">
                    <i class="fa fa-fw fa-chevron-right"></i> <strong>{{ $companyo->name }}&nbsp;&nbsp;&nbsp;<span class="label label-info">{{ $store->name }}</span></strong>
                </h2>
            </div>
        </section>
        <!-- END Buttons Title -->

        <!-- Jobs -->
        <section class="site-content site-section">
            <div class="container">
<?php /*
                <div class="row">
                    <div class="col-md-12">
                        <!-- Success Alert -->
                        <div class="alert alert-success alert-dismissable site-block">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><strong>Success</strong></h4>
                            <p>The <a href="javascript:void(0)" class="alert-link">App</a> was updated successfully!</p>
                        </div>
                        <!-- END Success Alert -->
                    </div>
                </div>
*/ ?>
                <div class="row push-bit">

                    <div class="col-md-7">
                        <a href="javascript:void(0)" class="portfolio-item themed-background-classy visibility-none" data-toggle="animation-appear" data-animation-class="animation-fadeInQuick" data-element-offset="-20">
                            <h2 class="site-heading h3 text-center">
                                <strong class="text-uppercase" data-timer></strong>
                            </h2>
                            <div class="portfolio-item-icon">
                                <i class="fa fa-clock-o text-dark-op fa-2x"></i>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div>
                                        <strong>{{ $day }}</strong>
                                    </div>
                                    <em>{{ $datefull }}</em>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span class="h2 text-light-op"><strong>Bienvenido</strong></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-5  site-block">


                        {{ Form::open(['route' => 'api.checkins.store', 'method' => 'POST', 'id' => 'checkin-form']) }}
                        
                            {{-- Tipo de registro -  SELECT2 --}}
                            <div class="form-group {{ $errors->first('type') ? 'has-error' : '' }}">

                                {{ Form::select('type', $type_checkins, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Tipo de registro', 'style' => 'min-width: 100%;', 'id' => 'type')) }}

                                @if( $errors->first('type'))
                                    <span class="help-block">{{ $errors->first('type')  }}</span>
                                @endif

                            </div>
                        
                            <div class="form-group">
                                {{ Form::text('code', null, ['id' => 'code', 'class' => 'form-control input-lg', 'placeholder' => 'Código de checador...']) }}
                                {{ Form::hidden('store_id', $store->id, ['id' => 'store-id']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::submit('Registrarme', ['class' => 'btn btn-effect-ripple btn-block btn-lg btn-success']) }}
                            </div>
                        {{ Form::close() }}

                        <!-- Success Alert -->
                        <!--div class="alert alert-info alert-dismissable site-block">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <!--h4><strong>Registrado</strong></h4-->
                            <!--p>Bienvenido <strong>Diego González</strong>, tu hora de registro se almacenó correctamente.</p>
                        </div>
                        <!-- END Success Alert -->

                    </div>
                </div>
            </div>
        </section>


    </div>
    <!-- END Page Scroller Container -->

    <!-- Footer -->
    <?php /*
    <footer class="site-footer site-section site-section-light">
        <div class="container">
            <!-- Footer Links -->
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="footer-heading">Company</h4>
                    <ul class="footer-nav ul-breath list-unstyled">
                        <li><a href="javascript:void(0)">About Us</a></li>
                        <li><a href="javascript:void(0)">Our Team</a></li>
                        <li><a href="javascript:void(0)">Memberships</a></li>
                        <li><a href="javascript:void(0)">Terms &amp; Conditions</a></li>
                        <li><a href="javascript:void(0)">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h4 class="footer-heading">Need support?</h4>
                    <ul class="footer-nav footer-nav-links list-inline">
                        <li><a href="javascript:void(0)"><i class="fa fa-fw fa-book"></i> Knowledge Base</a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-fw fa-support"></i> FAQ</a></li>
                    </ul>
                    <h4 class="footer-heading">We are social!</h4>
                    <ul class="footer-nav footer-nav-links list-inline">
                        <li><a href="javascript:void(0)" class="social-facebook" data-toggle="tooltip" title="Like our Facebook page"><i class="fa fa-fw fa-facebook"></i></a></li>
                        <li><a href="javascript:void(0)" class="social-twitter" data-toggle="tooltip" title="Follow us on Twitter"><i class="fa fa-fw fa-twitter"></i></a></li>
                        <li><a href="javascript:void(0)" class="social-google-plus" data-toggle="tooltip" title="Like our Google+ page"><i class="fa fa-fw fa-google-plus"></i></a></li>
                        <li><a href="javascript:void(0)" class="social-dribbble" data-toggle="tooltip" title="Follow us on Dribbble"><i class="fa fa-fw fa-dribbble"></i></a></li>
                        <li><a href="javascript:void(0)" class="social-youtube" data-toggle="tooltip" title="Subscribe to our Youtube channel"><i class="fa fa-fw fa-youtube-play"></i></a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h4 class="footer-heading">Newsletter</h4>
                    <form action="index.html" method="post" class="form-inline" onsubmit="return false;">
                        <div class="form-group">
                            <label class="sr-only" for="register-email">Your Email</label>
                            <div class="input-group">
                                <input type="email" id="register-email" name="register-email" class="form-control" placeholder="Your Email..">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">Subscribe</button>
                                        </span>
                            </div>
                        </div>
                    </form>
                    <h4 class="footer-heading"><a href="http://goo.gl/RcsdAh">AppUI - Frontend</a></h4>
                    <em><span id="year-copy"></span></em> &copy; Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://goo.gl/WCS84b">pixelcave</a>
                </div>
            </div>
            <!-- END Footer Links -->
        </div>
    </footer>
    <!-- END Footer -->
 */ ?>
</div>
<!-- END Page Container -->

<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
<!--a href="#" id="to-top"><i class="fa fa-arrow-up"></i></a-->

<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="{{ asset('assets/frontend/js/vendor/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/plugins.js') }}"></script>
<script src="{{ asset('assets/frontend/js/app.js') }}"></script>
<script src="{{ asset('vendors/flipclock/flipclock.js') }}"></script>
<script src="{{ asset('vendors/noty/jquery.noty.packaged.js') }}"></script>
<script src="{{ asset('vendors/blockui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/admin/js/select2.js') }}"></script>

<script>

    $(function(){

        $('.select-select2').select2();


        $.noty.defaults = {
            layout: 'topRight',
            theme: 'relax', // or 'relax'
            type: 'success',
            text: '', // can be html or string
            dismissQueue: true, // If you want to use queue feature set this true
            template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
            animation: {
                open: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceInLeft'
                close: {height: 'toggle'}, // or Animate.css class names like: 'animated bounceOutLeft'
                easing: 'swing',
                speed: 500 // opening & closing animation speed
            },
            timeout: 10000, // delay for closing event. Set false for sticky notifications
            force: false, // adds notification to the beginning of queue when set to true
            modal: false,
            maxVisible: 5, // you can set max visible notification for dismissQueue true option,
            killer: false, // for close all notifications before show
            closeWith: ['click'], // ['click', 'button', 'hover', 'backdrop'] // backdrop click will close all notifications
            callback: {
                onShow: function() {},
                afterShow: function() {},
                onClose: function() {},
                afterClose: function() {},
                onCloseClick: function() {}
            },
            buttons: false // an array of buttons
        };


        var clock = $('[data-timer]').FlipClock({
            // ... your options here
            clockFace: 'TwelveHourClock'
        });


        $('#checkin-form').on('submit', function(e){
            e.preventDefault();

            var code = $('#code').val().trim() || null;
            var type = $('#type').val();
            var $form = $(this);

            if (code)
            {
                $.blockUI({ message: '<p style="padding-top: 10px;" class="text-muted"><i class="fa fa-cog fa-spin"></i> en progreso de registro...</p>' });

                var data = {
                    code : code,
                    store: {
                        id: $('#store-id').val()
                    },
                    type: type
                };

                $.ajax({
                    url: $form.prop('action'),
                    //contentType: 'application/json; charset=UTF-8',
                    contentType: "application/json",
                    data: JSON.stringify(data),
                    //data: data,
                    dataType: 'json',
                    type: $form.prop('method'),
                    success: function(response){

                        var fullname = response.data.barber.first_name + ' ' + response.data.barber.last_name;

                        var message = '<i class="fa fa-check"></i><b>' + fullname + '</b><br />registrado correctamente.';

                        var n = noty({
                            text: message,
                            animation: {
                                open: 'animated bounceInLeft', // Animate.css class names
                                close: 'animated bounceOutLeft', // Animate.css class names
                                easing: 'swing', // unavailable - no need
                                speed: 500 // unavailable - no need
                            }
                        });

                        $('#code').val('');
                    },
                    error: function(xhr, textStatus, error){

                        var message = xhr.responseJSON.error.message;

                        switch(xhr.status)
                        {
                            case 404:
                                message = 'El código proporcionado no es válido.';
                                break;
                            case 500:
                                message = 'Ocurrió un error, por favor contacte al administrador del sistema.'
                                break;
                        }

                        var n = noty({
                            text: message,
                            animation: {
                                open: 'animated bounceInLeft', // Animate.css class names
                                close: 'animated bounceOutLeft', // Animate.css class names
                                easing: 'swing', // unavailable - no need
                                speed: 500 // unavailable - no need
                            },
                            type: 'error'
                        });

                        console.log(xhr);
                        console.log(textStatus);
                        console.log(error);
                    },
                    complete: function(){
                        $.unblockUI();
                    }
                })
            }
            else
            {
                var n = noty({
                    text: '<i class="fa fa-exclamation-triangle"></i> Por favor ingresa tu código de checador.',
                    animation: {
                        open: 'animated bounceInLeft', // Animate.css class names
                        close: 'animated bounceOutLeft', // Animate.css class names
                        easing: 'swing', // unavailable - no need
                        speed: 500 // unavailable - no need
                    },
                    type: 'warning'
                });
            }

        });
    });

</script>

</body>
</html>