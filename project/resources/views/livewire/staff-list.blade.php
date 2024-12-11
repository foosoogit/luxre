<div>
    <div class="container text-center">
		{{-- <div class="py-12"> --}}
			{{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
					
					{{--  <mark class="mb-2 bg-success text-white">スタッフ一覧</mark>--}}
					<div class="row row-cols-auto" style="line-height:3em">
						<div class="col-auto">
							{{--<button class="btn btn-primary" type="button" onclick="location.href='../ShowMenuCustomerManagement'">メニューに戻る</button>--}}
							<a class="btn btn-primary" href="{{route('admin.top')}}">メニューに戻る</a>
						</div>
						<div class="col-auto" style="line-height:3em">
							<form method="GET" action="ShowInputStaff/new">@csrf
								<button class="btn btn-primary" type="submit" name="ShowInputStaffCreateBtn" value="ShowInputStaff">スタッフ新規登録</button>
							</form>
						</div>
					</div>
					<div class="mb-2 bg-secondary text-white">スタッフ一覧</div>
					<div class="row">
						<div class="col-auto">
							<button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()" disabled="disabled">検索</button>
						</div>
						<div class="col-auto">
							<input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey" disabled="disabled">
						</div>
						<div class="col-auto">
							<button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''" disabled="disabled">解除</button> 
						</div>
					</div>
					<div class="card-body">
						<table class="table-auto" border-solid>
							<thead>
								<tr>
									<th class="border px-4 py-2">スタッフデータ修正<br>
										<button type="button" wire:click="sort('serial_user-ASC')" disabled="disabled"><img src="{{ asset('/storage/images/sort_A_Z.png') }}" width="15px"/></button>
										<button type="button" wire:click="sort('serial_user-Desc')" disabled="disabled"><img src="{{ asset('/storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
									<th class="border px-4 py-2">氏名
										<button type="button" wire:click="sort('name_sei-ASC')" disabled="disabled"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('name_sei-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
									<th class="border px-4 py-2">しめい
										<button type="button" wire:click="sort('name_sei_kana-ASC')" disabled="disabled"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('name_sei_kana-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
									<th class="border px-4 py-2">生年月日
										<button type="button" wire:click="sort('birth_year-ASC')" disabled="disabled"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('birth_year-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
									<th class="border px-4 py-2">電話番号
										<button type="button" wire:click="sort('phone-ASC')" disabled="disabled"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('phone-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
									<th class="border px-4 py-2">メールアドレス
									<button type="button" wire:click="sort('refereecnt-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									</th>
									<th class="border px-4 py-2">出退勤カード送付
										<button type="button" wire:click="sort('refereecnt-Desc')" disabled="disabled"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
										</th>
									<th class="border px-4 py-2">削除</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($staffs as $staff)
									<tr>
										<td class="border px-4 py-2"><form action="ShowInputStaff/{{$staff->serial_staff}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{ $staff->serial_staff}}"></form></td>
										<td class="border px-4 py-2">{{ $staff->last_name_kanji}}&nbsp;{{ $staff->first_name_kanji}}</td>
										<td class="border px-4 py-2">{{ $staff->last_name_kana}}&nbsp;{{ $staff->first_name_kana}}</td>
										<td class="border px-4 py-2">{{ $staff->birth_date}}</td>
										<td class="border px-4 py-2">{{ $staff->phone}}</td>
										<td class="border px-4 py-2">{{ $staff->email}}</td>
										{{-- 
										<td class="border px-4 py-2">
											<form action="send_attendance_card/{{$staff->serial_staff}}" method="GET">@csrf
												<input name="send_attendance_card_btn" type="submit" value="送付" onclick="return window.confirm('{{ $staff->serial_staff}} {{ $staff->last_name_kanji}} {{ $staff->first_name_kanji}}'+'送付します。よろしいですか？');" >
											</form>
											<button type="button" wire:click="send_attendance_card('{{$staff->serial_staff}}')" onclick="return window.confirm('{{ $staff->serial_staff}} {{ $staff->last_name_kanji}} {{ $staff->first_name_kanji}}'+'送付します。よろしいですか？');">送付</button>
										</td>
										 --}}
										<td class="border px-4 py-2">
											<form action="deleteStaff/{{$staff->serial_staff}}" method="GET">@csrf
												<input name="delete_btn" type="submit" value="削除" onclick="return window.confirm('{{ $staff->serial_staff}} {{ $staff->last_name_kanji}} {{ $staff->first_name_kanji}}'+'削除します。よろしいですか？');" >
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						{{ $staffs->links() }}
					</div>
				{{--</div>--}}
			{{-- </div> --}}
	</div>
</div>
