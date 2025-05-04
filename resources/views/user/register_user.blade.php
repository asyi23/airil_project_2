<html lang="en">

<head>
    <meta charset="utf-8">
    <title> Register User </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon-biscard.ico') }}">

    <link href="https://dealer.caricarz.com/assets/css/bootstrap-dark.min.css" id="bootstrap-dark" rel="stylesheet"
        type="text/css" disabled="">
    <link href="https://dealer.caricarz.com/assets/css/bootstrap.min.css" id="bootstrap-light" rel="stylesheet"
        type="text/css">
    <link href="https://dealer.caricarz.com/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://dealer.caricarz.com/assets/libs/select2/select2.min.css">
    <link href="https://dealer.caricarz.com/assets/css/app-dark.min.css" id="app-dark" rel="stylesheet" type="text/css"
        disabled="">
    <link href="https://dealer.caricarz.com/assets/css/app.min.css" id="app-light" rel="stylesheet" type="text/css">
    <link href="https://dealer.caricarz.com/assets/css/custom.css" id="app-light" rel="stylesheet" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}">
    <style>
        body {
            overflow-x: hidden;
        }

        .combined-input {
            display: flex;
            align-items: center;
        }

        .combined-left {
            flex: 1.5;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            width: 250px;
        }

        .combined-right {
            flex: 4;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .gap {
            width: 10px;
        }

        .custom-dropdown-container .select2-container {
            width: 10% !important;
        }

        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #img {
            margin: auto;
            padding-top: 100px;
            padding-bottom: 100px;
            display: block;
            top: 50%;
            left: 50%;
            max-height: 100%;
            max-width: 80%;
            animation-name: zoom;
            animation-duration: 0.5s;
        }

        @keyframes zoom {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .closebtn {
            position: absolute;
            top: 5px;
            right: 35px;
            color: white !important;
            font-size: 50px !important;
            font-weight: bold !important;
            cursor: pointer;
        }

        .closebtn:hover,
        .closebtn:focus {
            color: #cccccc !important;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            #img {
                width: 100%;
            }
        }

        .select2-dropdown.select2-dropdown--below {
            width: 15% !important;
            /* 4 columns out of 12, assuming a Bootstrap grid system */
        }

        .select2-dropdown.select2-dropdown--above {
            width: 15% !important;
            /* 4 columns out of 12, assuming a Bootstrap grid system */
        }


        .select2-container.select2-container--default.select2-container--open {
            width: 100% !important;
            /* 4 columns out of 12, assuming a Bootstrap grid system */
        }

        .modal {
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
    <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-W7NMF47"></script>
    <script type="text/javascript">
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-W7NMF47');
    </script>

    @include('layouts.head')
</head>

<body class="dealer-register-body">

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W7NMF47" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <header id="page-topbar" style="background-color: #293043">
        <div class="navbar-header container">
            <div class="dealer-login-logo-container">

                <div class="dealer-login-logo">
                    <img src="{{ asset('') }}assets/images/airil_logo.jpeg" alt="" height="60"
                        width="170" style="margin-top: 10px;">

                </div>
            </div>
            <div class="d-flex">
            </div>
        </div>
    </header>
    <div id="preloader" style="display: none;">
        <div id="status" style="display: none;">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <div class="account-pages">
        <div class="container dealer-login-container">
            <div class="row">
                <div class=" col-md-4 col-lg-6 col-xl-7 my-auto">
                    <img src="{{URL::asset('assets/images/Biscard Register.png')}}" alt=""
                        class="img-fluid">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-5">
                    {{-- @if (Session::has('success_msg'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {!! Session::get('success_msg') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    @if (Session::has('fail_msg'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ Session::get('fail_msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif --}}
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endforeach
                @enderror
                <div class="card overflow-hidden">
                    <div class="card-header font-size-16 font-weight-bold bg-white border-bottom">
                        Create Account
                    </div>
                    <div class="card-body">
                        <div class="p-2">
                            <form method="POST" class="form-horizontal"
                                action="{{$appUrl}}user/register/{{ $branch_id }}/{{$encrypt_code}}">
                                @csrf
                                @if ($company->hasMedia('company_logo'))
                                @php
                                $companylogo = $company->getMedia('company_logo')->last();
                                @endphp
                                <div class="text-center" style="display: flex;align-items:center;justify-content:center;margin-top:-20px">
                                    <div style="margin-bottom: 5px; display: {{ $companylogo ? 'block' : 'none' }};overflow:hidden;">
                                        <img src="{{ $companylogo ? $companylogo->getUrl() : '' }}" style="height:90px;max-width:150px;" class="pricelist-clickable">
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="company_name" class="title-input-font">Company Name</label>
                                    <input type="text" class="form-control"
                                        name="company_name" id="company_name"
                                        value="{{$company->company_name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="company_branch_name" class="title-input-font">Branch Name</label>
                                    <input type="text" class="form-control"
                                        name="company_branch_name" id="company_branch_name"
                                        value="{{$branch->company_branch_name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="user_fullname" class="title-input-font">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  input-font "
                                        name="user_fullname" id="user_fullname"
                                        placeholder="Full Name" maxlength="100"
                                        value="{{ @$post->user_fullname }}">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="title-input-font">Username<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  input-font nospace"
                                        name="username" id="username" placeholder="Username"
                                        maxlength="100" value="{{ @$post->username }}">
                                </div>
                                <div class="form-group">
                                    <label for="user_email" class="title-input-font">Email<span class="text-danger">*</span></label>
                                    <input type="user_email" class="form-control  input-font nospace"
                                        id="user_email" name="user_email"
                                        placeholder="youremail@email.com" maxlength="90"
                                        value="{{ @$post->user_email }}">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="title-input-font">Password<span class="text-danger">*</span></label><span
                                        class="bx bxs-info-circle info-tooltip" data-toggle="tooltip"
                                        data-placement="top" title=""
                                        data-original-title="Minimum 8 character"></span>
                                    <div id="password" class="input-group">
                                        <input type="password" class="form-control  input-font"
                                            name="password" id="userpassword" placeholder="Your password"
                                            value="">
                                        <span class="input-group-append">
                                            <span type="button"
                                                class="show-hide-password input-group-text font-size-18 bg-white"><i
                                                    class="bx bx bxs-show"></i></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="userpassword" class="title-input-font">Confirm
                                        Password<span class="text-danger">*</span></label><span class="bx bxs-info-circle info-tooltip"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Minimum 8 character"></span>
                                    <div id="confirm-password" class="input-group">
                                        <input id="password-confirm" type="password" name="confirm_password"
                                            class="form-control  input-font"
                                            value=""
                                            placeholder="Your password">
                                        <span class="input-group-append">
                                            <span type="button"
                                                class="show-hide-password input-group-text font-size-18 bg-white"><i
                                                    class="bx bx bxs-show"></i></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: -16px">
                                    <div class="form-group" style="padding-left: 12px">
                                        <label for="userpassword" class="title-input-font">Mobile Number<span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4" style="width: 50px !important">
                                        <select id="company_country_dialcode" name="user_country_dialcode"
                                            class="form-control select2 select2-hidden-accessible">
                                            @foreach ($countries as $countryAbb => $countryData)
                                            <option value="{{ $countryAbb }}" style="max-width: 40px"
                                                data-dialcode="{{ $countryData['dialcode'] }}"
                                                @if ($countryAbb==@$post->user_country_dialcode) selected @elseif ($countryAbb === 'MY') selected @endif>
                                                {{ $countryData['country_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" id="user_input-mask" class="form-control input-mask text-left " name="user_mobile"
                                            data-inputmask="'mask': '999999999999','clearIncomplete':'false','removeMaskOnSubmit':'true','autoUnmask':'true','placeholder':''" im-insert="true"
                                            value="{{ @$post->user_mobile }}" oninput="validateInput(this)"
                                            placeholder="Mobile Phone Number">
                                    </div>
                                </div>


                                <div class="mt-4">
                                    <button class="btn btn-theme-submit btn-block waves-effect waves-light"
                                        type="submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="card-footer bg-white border-top">
                            <div class="p-2 ">
                                Already have Caricarz Dealer account? <a href="https://dealer.caricarz.com/login"
                                    class="dealer-theme-color font-weight-bold">Sign in now</a>
                            </div>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
    <footer class="footer account-pages-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <script type="text/javascript">
                        document.write(new Date().getFullYear())
                    </script>2023 © Biscard All Rights Reserved.
                </div>
                <div class="col-sm-6 col-12">
                    <div class="text-sm-right d-block d-sm-block">
                        <a href="#">Terms Of Use</a>
                        <a href="#">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Modal -->
    @if($enableModal)
    <script>
        var enableModal = true;
    </script>
    @else
    <script>
        var enableModal = false;
    </script>
    @endif
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.1);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="text-align: center">
                    <img src="https://www.linkpicture.com/q/alert-icon-1562.png" alt="">
                </div>
                <form action="{{ route('password.request') }}">
                    @csrf
                    <div class="modal-body" style="text-align: center">
                        <h5>The phone number already linked with this email : <span style="color: red">{{@$email}}</span>.
                            <br><br>Do you want to reset the account password ?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Reset</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="ProductModal" class="modal">
        <span class="closebtn" id="closeModal" style="color: white">&times;</span>
        <img src="" alt="" id="img">
    </div>
    <!-- End Modal -->

    @include('layouts.footer-script')
    <script src="https://dealer.caricarz.com/assets/libs/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/metismenu/metismenu.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/simplebar/simplebar.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/node-waves/node-waves.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/select2/select2.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/libs/inputmask/inputmask.min.js" type="text/javascript"></script>
    <script src="https://dealer.caricarz.com/assets/js/pages/form-mask.init.js" type="text/javascript"></script>

    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>

    <!-- form mask -->
    <script src="{{ URL::asset('assets/libs/inputmask/inputmask.min.js') }}"></script>
    {{-- Google API --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>

    <!-- form mask init -->
    <script src="{{ URL::asset('assets/js/pages/form-mask.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#company_country_dialcode').select2({
                templateResult: formatCountryOption,
                templateSelection: formatSelectionOption,
                dropdownAutoWidth: true,
            });
            $('#user_country_dialcode').select2({
                templateResult: formatCountryOption,
                templateSelection: formatSelectionOption,
                dropdownAutoWidth: true,
            });

            if (enableModal) {
                $('#delete').modal('show');
            }

        });

        function formatCountryOption(option) {
            if (!option.id) {
                return option.text;
            }

            var countryCode = option.id.toLowerCase();
            var countryName = option.text;
            var dialCode = $(option.element).data('dialcode');

            var $option = $(
                '<span><img src="{{ URL::asset('
                assets / images / flags / ') }}/' + countryCode +
                '.svg" class="img-flag" width="20" height="20" /> ' +
                countryName + ' (+' + dialCode + ')</span>'
            );

            return $option;
        }

        function formatSelectionOption(option) {
            if (!option.id) {
                return option.text;
            }

            var countryCode = option.id.toLowerCase();
            var dialCode = $(option.element).data('dialcode');

            var $option = $(
                '<span><img src="{{ URL::asset('
                assets / images / flags / ') }}/' + countryCode +
                '.svg" class="img-flag" width="20" height="20" /> (+' + dialCode + ')</span>'
            );

            return $option;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#sector_id').select2({
                minimumResultsForSearch: Infinity
            });
        });
        $(document).ready(function() {
            $('#company_status').select2({
                minimumResultsForSearch: Infinity
            });
        });
        $(document).ready(function() {
            $('#user_role_id').select2({
                minimumResultsForSearch: Infinity
            });
        });
        $(document).ready(function() {
            $('#user_gender').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('.send-tac:enabled').on('click', function() {
                if ($('#user_mobile').val()) {
                    $.ajax({
                        type: 'POST',
                        url: "https://dealer.caricarz.com/request_tac",
                        data: {
                            user_mobile: $('#user_mobile').val(),
                            _token: 'lm4nBmeiYI2x13TCmFch4K0eGMKvzYg7HPxR6fu5'
                        },
                        success: function(e) {
                            $('.tac-feedback').show();
                            if (e.status) {
                                $('.tac-feedback').removeClass('text-danger');
                                $('.tac-feedback').addClass('text-success');
                                tac_timeout_request(e.data['time']);
                                $('#tac_no').show();
                            } else {
                                $('.tac-feedback').removeClass('text-success');
                                $('.tac-feedback').addClass('text-danger');
                                $('#tac_no').hide();
                            }
                            // $('#tac_no').show();
                            $('.tac-feedback').html('<strong>' + e.message + '</strong>');
                            $('.tac-feedback').siblings('.invalid-feedback').hide();
                        }
                    });
                } else {
                    $('#tac_no').hide();
                }
            });

            // $("#username").inputmask({

            //     mask: "a",
            //     repeat: "100",
            //     definitions: {
            //         'a': {
            //             validator: "[A-Za-z0-9_]",
            //         }
            //     },

            // });
            // {
            //     placeholder: " ",
            //     autoUnmask: "true"
            // });

            $('#password .show-hide-password').on('click', function() {
                var icon = 'bx bxs-hide';
                if ($('#password input').attr('type') == 'password') {
                    $('#password input').attr('type', 'text');
                } else {
                    $('#password input').attr('type', 'password');
                    icon = 'bx bxs-show';
                }
                $('#password .show-hide-password i').attr('class', icon);
            });

            $('#confirm-password .show-hide-password').on('click', function() {
                var icon = 'bx bxs-hide';
                if ($('#confirm-password input').attr('type') == 'password') {
                    $('#confirm-password input').attr('type', 'text');
                } else {
                    $('#confirm-password input').attr('type', 'password');
                    icon = 'bx bxs-show';
                }
                $('#confirm-password .show-hide-password i').attr('class', icon);
            });

            $("#username").keypress(function(event) {
                var character = String.fromCharCode(event.keyCode);
                return isValid(character);
            });
        });
        var countdown;
        var tac_timer;

        function tac_timeout_request(time) {
            countdown = time;
            $('.send-tac').prop('disabled', true);
            $('.send-tac').text(countdown);
            tac_timer = setInterval(function() {
                --countdown;
                $('.send-tac').text(countdown);
                if (countdown === 0) {
                    clearInterval(tac_timer);
                    $('.send-tac').text('Send TAC');
                    $('.send-tac').prop('disabled', false);
                }
            }, 1000);
        }

        $(function() {
            $('.nospace').on('keypress', function(e) {
                if (e.which == 32) {
                    return false;
                }
            });
        });

        function isValid(str) {
            return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function validateInput(input) {
            var inputValue = input.value;
            if (inputValue.startsWith('60')) {
                input.value = inputValue.substring(2);
            }
        }
    </script>

    <script src="https://dealer.caricarz.com/assets/js/app.min.js" type="text/javascript"></script>
    <script defer=""
        src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
        integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
        data-cf-beacon="{&quot;rayId&quot;:&quot;80549962cd87135e&quot;,&quot;version&quot;:&quot;2023.8.0&quot;,&quot;r&quot;:1,&quot;token&quot;:&quot;5600cceddc7d4c71b83f237cf6d24402&quot;,&quot;si&quot;:100}"
        crossorigin="anonymous" style="display: none !important;"></script>

    <div class="volume-up-wrapper">
        <div class="volume-up-indicator">100 %</div>
    </div>
</body>

</html>