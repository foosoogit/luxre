<div class="container container-fluid ml-5">
	<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 justify-content-center align-middle">
                <div class="row">
                    <div class="col-auto">
                        <form method="GET" action="{{ route('admin.top') }}">@csrf
                            <button class="btn btn-primary" type="submit">メニュー</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="javascript:history.back();">戻る</a>
                    </div>
                    <div class="col-auto">   
                        <form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">@csrf
                            <button class="btn btn-primary" type="submit">新規登録</button>
                        </form>
                    </div>
                </div>
		        @if($UserSerial==="all")
                    <button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" wire:click="search()">検索</button>
                    <input type="text" name="kensakukey_txt" id="kensakukey_txt" wire:model.defer="kensakukey" value="{{$serchKey_contract}}"class="mt-1 block rounded-md border-gray-300 border-2 p-0.8 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <button type="button" class="bg-blue-500 text-white rounded px-3 py-1" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button>
	        	@else
			        顧客番号：&nbsp;{{$UserSerial}}&nbsp;&nbsp;契約者：{{$userinf->name_sei}}&nbsp;{{$userinf->name_mei}}
		        @endif
                <table class="table-auto" border-solid>
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">契約番号(修正)
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('serial_keiyaku-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('serial_keiyaku-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">最終来店日(支払い・来店記録入力)
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('date_latest_visit-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('date_latest_visit-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>
                            </th>
                            @if($UserSerial==="all")
                                <th class="border px-4 py-2">顧客番号（新規作成)
                                    <div class="text-nowrap">
                                        <button type="button" wire:click="sort('keiyakus.serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('keiyakus.serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </div>
                                </th>
                                <th class="border px-4 py-2">氏名
                                    <div class="text-nowrap">
                                        <button type="button" wire:click="sort('users.name_sei_kana-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('users.serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </div>
                                </th>
                            @endif
                            <th class="border px-4 py-2">契約日
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('keiyaku_bi-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('keiyaku_bi-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>   
                            </th>
                            <th class="border px-4 py-2">契約期間</th>
                            <th class="border px-4 py-2">契約金額
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('keiyaku_kingaku-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('keiyaku_kingaku-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>   
                            </th>
                            <th class="border px-4 py-2">支払い方法
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('how_to_pay-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('how_to_pay-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">支払い回数
                            </th>
                            <th class="border px-4 py-2">削除</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contractQuery as $dContracts)
                            <tr>
                                <td class="border px-4 py-2">
                                    <form action="/customers/ShowSyuseiContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                        <input name="syusei_Btn" type="submit" value="{{$dContracts->serial_keiyaku}}">
                                    </form>
                                </td>
                                <td class="border px-4 py-2">
                                    <form action="/customers/ShowInpRecordVisitPayment/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                        @if($dContracts->date_latest_visit==Null)
                                            <input name="Record_Btn" type="submit" value="なし">
                                        @else
                                            <input name="Record_Btn" type="submit" value="{{$dContracts->date_latest_visit}}">
                                        @endif
                                    </form>
                                </td>
                                @if($UserSerial=="all")
                                    <td class="border px-4 py-2">
                                        <form action="/customers/ShowInpContract/{{$dContracts->serial_user}}" method="GET">@csrf
                                            <input name="syusei_Btn" type="submit" value="{{ $dContracts->serial_user}}">
                                        </form>
                                    </td>
                                    <td class="border px-4 py-2">{{$dContracts->name_sei}} &nbsp; {{$dContracts->name_mei}}</td>
                                @endif
                                <td class="border px-4 py-2">{{ $dContracts->keiyaku_bi}}</td>
                                <td class="border px-4 py-2" {!! $dContracts->closed_color!!}>{{ $dContracts->keiyaku_kikan_start}}-{{ $dContracts->keiyaku_kikan_end}}</td>
                                <td class="border px-4 py-2">{{ $dContracts->keiyaku_kingaku}}</td>
                                <td class="border px-4 py-2">{{ $dContracts->how_to_pay}}</td>
                                <td class="border px-4 py-2">{{ $dContracts->how_many_pay_genkin}}</td>
                                <td class="border px-4 py-2">
                                    <form action="/customers/deleteContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                        <input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $dContracts->serial_user}} {{ $dContracts->name_sei}} {{ $dContracts->name_mei}}');" >
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
	            {{$contractQuery->appends(request()->query())->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
