<!-- Toastr -->
<link type="text/css" href="{{asset('template/vendor/toastr.min.css')}}" rel="stylesheet">
<!-- Toastr -->
<script src="{{asset('template/vendor/toastr.min.js')}}"></script>
{{-- <script src="{{asset('template/js/toastr.js')}}"></script> --}}

@if ($errors->any())
    @foreach($errors->all() as $error)
        <script>
            toastr.warning('{{$error}}', 'Warning!!');
        </script>
    @endforeach
@endif

@if ($message = Session::get('success'))
    <script>
        toastr.success('{{$message}}', 'Success!!');
    </script>
@endif

@if($message = Session::get('info'))
    <script>
        toastr.info('{{$message}}', 'Info!!');
    </script>
@endif

@if($message = Session::get('warning'))
    <script>
        toastr.warning('{{$message}}', 'warning!!');
    </script>
@endif
