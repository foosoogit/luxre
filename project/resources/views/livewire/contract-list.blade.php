<div class="container-fluid ml-5">
	<div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
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
                            {{-- 
                                <input class="form-check-input" type="checkbox" value="subscription" name="contract_type" id="contract_type_subscription" wire:model="isSubscriptionCheckBox" onclick="contract_type_manage(this)" checked wire:click="select_subscription()"/>
                                <label class="form-check-label" for="contract_type_subscription">サブスク</label>
                                <input class="form-check-input" type="checkbox" value="cyclic" name="contract_type" id="contract_type_cyclic" wire:model="isCyclicCheckBox" onclick="contract_type_manage(this)" checked wire:click="select_cyclic()"/>
                                <label class="form-check-label" for="contract_type_cyclic">期間契約</label>
                                <input class="form-check-input" type="checkbox" value="cancel" name="contract_status[]" id="contract_status_under" wire:model="isContractStatusUnderCheckBox" onclick="contract_status_manage()" checked wire:click="select_Under()"/>
                                <label class="form-check-label" for="contract_status_under">契約中</label>
                                <input class="form-check-input" type="checkbox" value="cancel" name="contract_status[]" id="contract_status_cancellation" wire:model="isContractStatusCancellationCheckBox" onclick="contract_status_manage()" checked wire:click="select_cancel()"/>
                                <label class="form-check-label" for="contract_status_cancellation">契約解約者</label>
                             --}}
                     
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
                            {{-- 
                            <th class="border px-4 py-2">契約タイプ</th>
                            <th class="border px-4 py-2">解約日</th>
                             --}}
                            <th class="border px-4 py-2">契約金額(円)
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
                            {{-- 
                            <th> class="border px-4 py-2">支払い回数</th>
                            --}}
                            
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
                                        {{-- 
                                        <span class="fs-12">{{$dContracts->keiyaku_name}}</span>
                                         --}}
                                        @if($dContracts->cancel<>null)
                                            <span class="text-danger">解約済み</span>
                                        @endif
                                    </form>
                                </td>
                                <td class="border px-4 py-2">
                                    <div class="row"><div class="col-auto">
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
                                    </div>
                                    <div class="col-auto">
                                        {{-- <form action="/customers/deleteContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf --}}
                                           {{--  <button type="button" class="btn btn-outline-primary btn-sm">カルテ一覧</button> --}}
                                            <button type="button" class="modalBtn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#MedicalRecordFormModal"
                                                data-contractserial="{{$dContracts->serial_keiyaku}}"
                                                data-customer_name="{{$dContracts->name_sei}}&nbsp;{{$dContracts->name_mei}}"
                                                data-customerserial="{{$dContracts->serial_user}}"
                                                data-keiyaku_name="{{$dContracts->keiyaku_name}}"
                                            >カルテ一覧</button>
                                        {{--</form>--}}
                                    </div>
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
                               {{-- 
                                <td class="border px-4 py-2">{{ $dContracts->KeiyakuTypeJP}}</td>
                                <td class="border px-4 py-2">{{ $dContracts->cancel}}</td>
                                 --}}
                                <td class="border px-4 py-2">{{ number_format($dContracts->keiyaku_kingaku)}}</td>
                                <td class="border px-4 py-2">{{ $dContracts->how_to_pay}}</td>
                                {{-- 
                                <td class="border px-4 py-2">{{ $dContracts->how_many_pay_genkin}}</td>
                                 --}}
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
        <!--　カルテ一覧 -->
        <div class="modal fade" id="MedicalRecordFormModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <meta http-equiv="Pragma" content="no-cache">
                        <meta http-equiv="Cache-Control" content="no-cache"> 
                        <h4 class="modal-title">カルテ一覧</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-auto">
                                <label>顧客番号：<span id="serial"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>顧客名：<span id="customer_name"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>契約内容：<span id="contract_name"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div id="medical_records_list_img" class="image-container">
                                {{-- <span id="medical_records_list_img"></span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="delTargetHandoverSerial_hdn">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
