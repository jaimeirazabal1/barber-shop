<!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>!window.jQuery && document.write(decodeURI('%3Cscript src="{{ asset('assets/admin/js/vendor/jquery-2.1.3.min.js') }}}"%3E%3C/script%3E'));</script>

<script src="{{ asset('vendors/moment/moment.js') }}"></script>
<script src="{{ asset('vendors/noty/jquery.noty.packaged.js') }}"></script>
<script src="{{ asset('vendors/blockui/jquery.blockUI.js') }}"></script>


<!-- Bootstrap.js, Jquery plugins and Custom JS code -->
<script src="{{ asset('assets/admin/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins.js') }}"></script>
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.1/jquery.qtip.min.js"></script>



<script src="{{ asset('vendors/handlebars/handlebars.js') }}"></script>
<script src="{{ asset('vendors/underscore/underscore.js') }}"></script>
<script src="{{ asset('vendors/backbone/backbone.js') }}"></script>


<script src="{{ asset('vendors/intl-tel-input/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}?time={{ time() }}"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="{{ asset('assets/admin/js/pages/readyDashboard.js') }}"></script>
<!--script>$(function(){ ReadyDashboard.init(); });</script-->

@yield('javascript')