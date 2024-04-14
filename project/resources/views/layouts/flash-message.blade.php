@if ($message = Session::get('success'))

<script type="text/javascript">
    /*
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }
    */
    /*
    toastr.success('登録が完了しました。');
    */
   /*
    $.toast({ 
    		  text : "入力は半角数字で入力してね", //表示したいテキスト(HTML使用可)
    		  showHideTransition : 'fade',  // 表示・消去時の演出
    		  bgColor : 'blue',              // 背景色
    		  textColor : '#eee',            // 文字色
    		  allowToastClose : false,       // 閉じるボタンの表示・非表示
    		  hideAfter : 2000,              // 自動的に消去されるまでの時間(ミリ秒)(falseを指定すると自動消去されない)
    		  stack : 5,                     // 一度に表示できる数
    		  textAlign : 'left',            // テキストの配置
    		  position : 'top-right'       // ページ内での表示位置
    		})
*/
    

    swal({
        title: 'Success!',
        text: "{{Session::get('success')}}",
        timer: 5000,
        type: 'success'
    }).then((value) => {
        //location.reload();
    }).catch(swal.noop);

</script>


{{-- 
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
 --}}
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