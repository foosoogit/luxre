@extends('layouts.appCustomer')
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<<--<script src='lib/jquery.min.js'></script>-->>
<<--<script src='lib/moment.min.js'></script>-->>
<script src='fullcalendar/fullcalendar.js'></script>
<div id="calendar"></div>
<script type="text/javascript">
    <!--scriptタグの中にこう↓↓書きます。scriptタグの書き方はプロジェクト毎に変えてください-->
    $(function() {
      // 初期処理
      $('#calendar').fullCalendar({
        // ここに各種オプションを書いていくと設定が適用されていく
      })
    });
</script>