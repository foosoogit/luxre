<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>スタッフ一覧</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  {{-- <link rel="stylesheet" href="css/style.css"> --}}
  <link href="{{asset('css/app.css')}}" rel="stylesheet">
	{{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}
  {{--<link rel="stylesheet" href="css/style.css">--}}
	{{--<link rel="stylesheet" href="{{ asset('css/studentsList.css')  }}" >--}}
	{{--<link rel="stylesheet" href="css/studentsList.css" >--}}
	{{-- @vite('public/storage/images/') --}}
  {{-- @vite(['public/storage/images/sort_A_Z.png', 'public/storage/images/sort_Z_A.png']) --}}
{{-- 
	<style>

		/* table_responsive */
#table_responsive th, #table_responsive td {
    text-align: center;
    width: 20%;
    min-width: 130px;
    padding: 10px;
    height: 60px;
  }
  #table_responsive tr:nth-child(2n+1) {
    background: #e9faf9;
   }

   #table_responsive th {
    padding: 10px;
    background: #778ca3;
    border-right: solid 1px #778ca3;
    color: #ffffff;
   }

   #table_responsive th:last-child {
    border-right: none;
   }

   .#table_responsive td {
    padding: 10px;
    border-right: solid 1px #778ca3; 
   }

   .#table_responsive td:last-child {
    border-right: none;
   }

  /* tab */
  @media only screen and (max-width: 768px) {
    #table_responsive {
      display: block;
      overflow-x: scroll;
      white-space: nowrap;
    }
  }
	</style>
   --}}
	@livewireStyles
</head>
<body>
  <div class="table-responsive">
	<p><livewire:staff-list /></p>
	<body>
  @livewireScripts
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
  {{--
     <script>
		function clickDelete(namae) {
			if(!confirm(namae+'さんを退会にします。もよろしいですか？（元に戻せます。）')){
				return false;
			}
		}
	</script>
   --}}
</body>
</html>