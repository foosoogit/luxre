<div class="container-fluid ml-5">
	<div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                {{-- 
                <div class="row">
                    <div class="col-auto">
                        <form method="GET" action="{{ route('admin.top') }}">@csrf
                            <button class="btn btn-primary btn-sm" type="submit">メニュー</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary btn-sm" href="javascript:history.back();">戻る</a>
                    </div>
                    
                </div>
                 --}}
                <div class="mb-2 bg-secondary text-white">契約リスト</div>
		        <div class="row pb-2">
                    <div class="col-auto">   
                        <form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">@csrf
                            <button class="btn btn-primary btn-sm" type="submit">新規登録</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        @if($UserSerial==="all")
                            <button type="button" class="btn btn-primary btn-sm" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button>
                            <input type="text" name="kensakukey_txt" id="kensakukey_txt" wire:model.defer="serch_key_contract" value="{{$serchKey_contract}}" class="form-control-sm">
                            <button class="btn btn-primary btn-sm" type="submit" wire:click="search()">検索</button>
                        @else
                            顧客番号：&nbsp;{{$UserSerial}}&nbsp;&nbsp;契約者：{{$userinf->name_sei}}&nbsp;{{$userinf->name_mei}}
                        @endif
                    </div>
                </div>
                <table id="table_responsive container-fluid" class="table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th class="border px-4 py-2">契約日
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('keiyaku_bi-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                    <button type="button" wire:click="sort('keiyaku_bi-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                </div>   
                            </th>
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
                                        <button type="button" wire:click="sort('contracts.serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('contracts.serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </div>
                                </th>
                                <th class="border px-4 py-2">氏名
                                    <div class="text-nowrap">
                                        <button type="button" wire:click="sort('users.name_sei_kana-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('users.serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </div>
                                </th>
                            @endif
                            
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
                                <td class="border px-4 py-2">{{ $dContracts->keiyaku_bi}}</td>
                                <td class="border px-4 py-2">
                                    <form action="/customers/ShowSyuseiContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                        <input name="syusei_Btn" type="submit" value="{{$dContracts->serial_keiyaku}}">
                                        @if($dContracts->cancel<>null)
                                            <span class="text-danger">解約済み</span>
                                        @endif
                                    </form>
                                </td>
                                <td class="border px-4 py-2">
                                    @if ($dContracts->keiyaku_type=="subscription")
                                        <form action="/customers/ShowPaymentRegistrationIflame/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                            <input name="Record_Btn" type="submit" value="{{$dContracts->LatestVisitDate}}">
                                        </form>
                                    @else
                                        <form action="/customers/ShowInpRecordVisitPayment/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                            @if($dContracts->date_latest_visit==Null)
                                                <input name="Record_Btn" type="submit" value="なし">
                                            @else
                                                <input name="Record_Btn" type="submit" value="{{$dContracts->date_latest_visit}}">
                                            @endif
                                        </form>
                                    @endif
                                </td>
                                @if($UserSerial=="all")
                                    <td class="border px-4 py-2">
                                        <form action="/customers/ShowInpContract/{{$dContracts->serial_user}}" method="GET">@csrf
                                            <input name="syusei_Btn" type="submit" value="{{ $dContracts->serial_user}}">
                                        </form>
                                    </td>
                                    <td class="border px-4 py-2">{{$dContracts->name_sei}} &nbsp; {{$dContracts->name_mei}}</td>
                                @endif
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
