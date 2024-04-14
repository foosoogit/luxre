@if ($message = Session::get('success'))
    <script type="text/javascript">
        swal({
            title: 'Success!',
            text: "{{Session::get('success')}}",
            timer: 5000,
            type: 'success'
        }).then((value) => {
            //location.reload();
        }).catch(swal.noop);
    </script>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Please check the form below for errors</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
{{-- 
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }

    @if (Session::has('flashSuccess'))
        toastr.success("{{ session('flashSuccess') }}");
    @endif

    @if (Session::has('flashError'))
        toastr.error("{{ session('flashError') }}");
    @endif

    @if (Session::has('flashInfo'))
        toastr.info("{{ session('flashInfo') }}");
    @endif

    @if (Session::has('flashWarning'))
        toastr.warning("{{ session('flashWarning') }}");
    @endif
</script>
 --}}