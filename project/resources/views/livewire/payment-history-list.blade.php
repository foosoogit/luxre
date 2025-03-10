<div class="container-fluid pl-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-2 bg-secondary text-white">支払いリスト</div>
		    <div class="row pb-2">
                <div class="col-auto">
                    <button type="button" name="create_btn" id="create_btn" class="btn btn-primary btn-sm modalBtn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#ModifyModal" 
                        data-nserial="{{$newPaymentHistorySerial}}"
                        data-name="{{$UserInf->name_sei}}&nbsp;{{$UserInf->name_mei}}">
                        支払い記録新規登録
                    </button>
                </div>
                <div class="col-auto">
                    <button type="button" wire:click="searchClear()" onclick="document.getElementById('kensakukey_txt').value=''" disabled>解除</button>
                    <input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey">
                    <button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()" disabled>検索</button>
                </div>
            </div>
            <table id="table_responsive container-fluid" class="table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th class="border px-4 py-2">支払い番号(修正)
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('payment_history_serial-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('payment_history_serial-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>   
                        </th>
                        <th class="border px-4 py-2">支払日
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('date_payment-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('date_payment-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">支払い金額
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('amount_payment-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('amount_payment-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">支払い方法
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('how_to_pay-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('how_to_pay-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($PaymentHistoryQuery as $dPaymentHistory)
                        <tr>
                            <td class="border px-4 py-2">
                                <button type="button" id="modify_btn_{{$dPaymentHistory->payment_history_serial}}" class="btn btn-info modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ModifyModal" 
                                    data-num="{{$dPaymentHistory->PaiedNum}}" 
                                    data-payment_date="{{$dPaymentHistory->date_payment}}"
                                    data-payment_history_serial="{{$dPaymentHistory->payment_history_serial}}" 
                                    data-amount="{{$dPaymentHistory->amount_payment}}" 
                                    data-name="{{$UserInf->name_sei}}&nbsp;{{$UserInf->name_mei}}"
                                    data-method="{{$dPaymentHistory->how_to_pay}}">
                                    {{ $dPaymentHistory->PaiedNum}}
                                </button>
                            </td>
                            <td class="border px-4 py-2">
                                {{$dPaymentHistory->date_payment}}
                            </td>
                            <td class="border px-4 py-2">
                                {{number_format($dPaymentHistory->amount_payment)}}円
                            </td>
                            <td class="border px-4 py-2">{{ $dPaymentHistory->MethodSCR}}</td>
                            <td class="border px-4 py-2">
                                <button type="button" id="delete_btn_{{$dPaymentHistory->payment_history_serial}}" class="btn btn-danger modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#delConfirmModal" 
                                    data-num_d="{{$dPaymentHistory->PaiedNum}}" 
                                    data-payment_date_d="{{$dPaymentHistory->date_payment}}"
                                    data-payment_history_serial_d="{{$dPaymentHistory->payment_history_serial}}" 
                                    data-amount_d="{{number_format($dPaymentHistory->amount_payment)}}円" 
                                    data-name_d="{{$UserInf->name_sei}}&nbsp;{{$UserInf->name_mei}}"
                                    data-method_d="{{$dPaymentHistory->MethodSCR}}">
                                削除
                                </button>
                                {{-- 
                                <form action="/customers/deleteContract/{{$dPaymentHistory->serial_keiyaku}}/{{$dPaymentHistory->serial_user}}" method="GET">@csrf
                                    <input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $dPaymentHistory->serial_user}} {{ $dPaymentHistory->name_sei}} {{ $dPaymentHistory->name_mei}}');" >
                                </form>
                                 --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
	        {{$PaymentHistoryQuery->appends(request()->query())->links('pagination::bootstrap-4')}}

            <!-- モーダル・ダイアログ -->
            <div class="modal fade" id="ModifyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <meta http-equiv="Pragma" content="no-cache">
                            <meta http-equiv="Cache-Control" content="no-cache"> 
                            <h4 class="modal-title">支払い履歴修正</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-auto">
                                    <label>支払いシリアル：<span id="payment_history_serial"></span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <label>顧客氏名：<span id="name"></span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <label>回数：<span id="num"></span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <label>支払日：<input type="date" id="payment_date"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <label>支払い金額：<input type="text" id="amount"></span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <label>支払い方法：<span id="method"></span></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn1" class="btn btn-primary">保存</button>
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--　削除確認 -->
            <div class="modal fade" id="delConfirmModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <meta http-equiv="Pragma" content="no-cache">
                            <meta http-equiv="Cache-Control" content="no-cache"> 
                            <h4 class="modal-title">支払い削除</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-auto">
                                <label>支払いシリアル：<span id="payment_history_serial_d"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>顧客氏名：<span id="name_d"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>回数：<span id="num_d"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>支払日：<span type="date" id="payment_date_d"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>支払い金額：<span type="text" id="amount_d"></span></label>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-auto">
                            <label>支払い方法：<span id="method_d"></span></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="delTargetPaymentHistorySerial_hdn">
                    <button type="button" id="del_btn" class="btn btn-danger" wire:click="del_payment_history(document.getElementById('delTargetPaymentHistorySerial_hdn').value)">削除</button>
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
</div>