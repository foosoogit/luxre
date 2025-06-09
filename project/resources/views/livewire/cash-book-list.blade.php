<div class="container text-center">
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="pb-4 justify-content-center align-middle">
                <div class="row">
					@include('layouts.header')
				</div>
                <div class="mb-2 bg-info text-white">出納帳</div>

						    <div class="row pb-2">
                <div class="col-auto">
                    <button type="button" name="create_btn" id="create_btn" class="btn btn-primary btn-sm modalBtn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#CreateModal"
                        data-manage="create">
                        新規登録
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
                        <th class="border px-4 py-2">シリアル(修正)
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('payment_history_serial-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('payment_history_serial-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>   
                        </th>
                        <th class="border px-4 py-2">日付
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('payment_history_serial-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('payment_history_serial-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>   
                        </th>
                        <th class="border px-4 py-2">摘要
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('date_payment-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('date_payment-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">出金
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('amount_payment-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('amount_payment-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">入金
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('how_to_pay-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('how_to_pay-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
						<th class="border px-4 py-2">備考
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('how_to_pay-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('how_to_pay-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($CashBookQuery as $dCashBookQuery)
                        <tr>
                            <td class="border px-4 py-2">
                                <button type="button" id="modify_btn_{{$dCashBookQuery->payment_history_serial}}" class="btn btn-info modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#CreateModal" 
                                    data-id="{{$dCashBookQuery->id}}"
                                    data-manage="modyfy"
                                    data-t_date="{{$dCashBookQuery->target_date}}"
                                    data-in_out="{{$dCashBookQuery->in_out}}" 
                                    data-summary="{{$dCashBookQuery->summary}}" 
                                    data-payment="{{$dCashBookQuery->payment}}"
                                    data-deposit="{{$dCashBookQuery->deposit}}"
                                    data-remarks="{{$dCashBookQuery->remarks}}">
                                    {{ $dCashBookQuery->id}}
                                </button>
                            </td>
                            <td class="border px-4 py-2">
                                {{$dCashBookQuery->target_date}}
                            </td>
                            <td class="border px-4 py-2">
                                {{$dCashBookQuery->summary}}
                            </td>
                            <td class="border px-4 py-2">
                                {{$dCashBookQuery->PaymentAddYen }}
                            </td>
                            <td class="border px-4 py-2">{{ $dCashBookQuery->DepositAddYen}}</td>
                            <td class="border px-4 py-2">{{ $dCashBookQuery->remarks}}</td>
                            <td class="border px-4 py-2">
                                <button type="button" wire:click="del('{{$dCashBookQuery->id}}')" id="delete_btn_{{$dCashBookQuery->id}}" class="btn btn-danger modalBtn btn-sm">
                                削除
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
	        {{$CashBookQuery->appends(request()->query())->links('pagination::bootstrap-4')}}
            
            <!-- モーダル・ダイアログ -->
            <div class="modal fade" id="CreateModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <meta http-equiv="Pragma" content="no-cache">
                            <meta http-equiv="Cache-Control" content="no-cache"> 
                            <h4 class="modal-title">出納帳 新規登録</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                        </div>
                        <form name="submitForm" id="submitForm"> @csrf
                            <div class="modal-body">
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <label>シリアル：<span id="id"></span></label>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <div class="form-check">
                                             <input class="form-check-input" type="radio" name="payment_deposit_rdo" id="payment" wire:model="payment_deposit_rdo" value='payment'> 
                                            <label class="form-check-label" for="payment">出金</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_deposit_rdo" id="deposit" wire:model="payment_deposit_rdo" value='deposit'>
                                            <label class="form-check-label" for="deposit">入金</label>
                                        </div>
                                    </div>
                                    <span class="text-start text-danger" id="payment_deposit_rdo_for_error"></span>
                                    @error('payment_deposit_rdo')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <label>日付：<input type="date" name="target_date" id="target_date" wire:model="target_date"></label>
                                        <span id="target_date_for_error" class="text-danger"></span>
                                    </div>
                                    @error('target_date')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <label>摘要：<input type="datalist" id="summary" name="summary" wire:model="summary"/><span id="summary"></span></label>
                                        <span id="summary_for_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <label>金額：<input type="number" id="amount" name="amount" wire:model="amount"/></label>円
                                        <span id="amount_for_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-auto">
                                        <label>備考：<textarea id="remarks" name="remarks" wire:model="remarks"></textarea></label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="lwtest_btn" class="btn btn-primary" wire:click="submitForm">保存</button>
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>