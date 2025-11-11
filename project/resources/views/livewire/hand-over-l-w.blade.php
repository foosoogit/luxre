<div class="container text-center">
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="pb-4">
                <div class="row">
					@include('layouts.header')
				</div>
                <div class="mb-2 bg-info text-white">日報・申し送り</div>
				<div class="row pb-2">
                    <div class="col-auto">
                        <button type="button" name="create_btn" id="create_btn" class="btn btn-primary btn-sm modalBtn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#CreateModal"
                            data-manage="create">
                            新規登録
                        </button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-auto">
                        <button type="button" wire:click="searchClear()" onclick="searchClearManage()">検索解除</button>
                    </div>
                    <div class="col-auto">
                        <input type="month" id="month" name="month" wire:model="serch_key_month_ho"/><button type="button" name="serch_month_btn" id="serch_month_btn" wire:click="search_month()" >月で検索</button>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="date" name="date" wire:model="serch_key_date_ho"/><button type="button" name="serch_date_btn" id="serch_date_btn" wire:click="search_date()" >日付で検索</button>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="serch_key_all_ho" id="serch_key_all_ho" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model="serch_key_all()">
                    </div>
                    <div class="col-auto">
                        <button type="button" name="SerchBtn" id="SerchBtn" wire:click="search_all()">全件検索</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
            <table id="table_handover" class="table container-fluid table-striped table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th >シリアル(修正)
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('id-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('id-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>   
                        </th>
                        <th >日付
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('target_date-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('target_date-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>   
                        </th>
                        <th >入力者
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('last_name_kana-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('last_name_kana-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th >種類
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('type_flag-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('type_flag-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th >顧客名
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('target_customaer_serial-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('target_customaer_serial-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="sentence" style="width: 250px" >内容
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('sentence-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('sentence-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
    					<th >備考
                            <div class="text-nowrap">
                                <button type="button" wire:click="sort('remarks-ASC')"><img src="{{ asset('images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="sort('remarks-Desc')"><img src="{{ asset('images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th >削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($HandOverQuery as $dHandOverQuery)
                        <tr>
                            <td >
                                <button type="button" id="modify_btn_{{$dHandOverQuery->payment_history_serial}}" class="btn btn-info modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#CreateModal" 
                                    data-id="{{$dHandOverQuery->id}}"
                                    data-manage="modyfy"
                                    data-t_date="{{$dHandOverQuery->target_date}}"
                                    data-serial_staff="{{$dHandOverQuery->serial_staff}}" 
                                    data-type_flag="{{$dHandOverQuery->type_flag}}" 
                                    data-sentence="{{$dHandOverQuery->sentence}}"
                                    data-remarks="{{$dHandOverQuery->remarks}}">
                                    {{ $dHandOverQuery->id}}
                                </button>
                            </td>
                            <td >
                                {{$dHandOverQuery->target_date}}
                            </td>
                            <td >
                                {{$dHandOverQuery->last_name_kanji}} {{$dHandOverQuery->first_name_kanji}}
                            </td>
                            <td >
                                {{$dHandOverQuery->TypeFlagJP}}
                           </td>
                           <td >
                                {{$dHandOverQuery->CustomerName}}
                           </td>
                            <td  >
                                <button type="button" class="text-wrap NoBorder td_daily_report" style="word-break: break-word; white-space: normal;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#DispHandoverModal"
                                    data-serial="{{$dHandOverQuery->id}}"
                                    data-sentence="{{ $dHandOverQuery->sentence}}"
                                    data-inputter_name="{{$dHandOverQuery->InputterName}}"
                                    data-type_flag="{{$dHandOverQuery->TypeFlagJP}}"
                                    data-t_date="{{$dHandOverQuery->target_date}}"
                                    data-customer_name="{{$dHandOverQuery->last_name_kanji}} {{$dHandOverQuery->first_name_kanji}}"
                                >{!!nl2br($dHandOverQuery->sentence)!!}</button>
                            </td>
                            <td ><span class="item-row" data-detail="{{ $dHandOverQuery->handover}}">{{ $dHandOverQuery->remarks}}</span></td>
                            <td >
                                <button type="button" id="delete_btn_{{$dHandOverQuery->id}}" class="btn btn-danger modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#delConfirmModal" 
                                    data-num="{{$dHandOverQuery->id}}"
                                    data-t_date="{{$dHandOverQuery->target_date}}"
                                    data-inputter_name="{{$dHandOverQuery->InputterName}}" 
                                    data-daily_report_del="{{$dHandOverQuery->daily_report}}"
                                    data-handover_del="{{$dHandOverQuery->handover}}"
                                    data-remarks_del="{{$dHandOverQuery->remarks}}"
                                > 
                                削除
                            </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
	        {{$HandOverQuery->appends(request()->query())->links('pagination::bootstrap-4')}}
            </div>
        </div>    
        <!-- モーダル・ダイアログ -->
        <!--　申し送り・日報表示 -->
        <div class="modal fade" id="DispHandoverModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <meta http-equiv="Pragma" content="no-cache">
                        <meta http-equiv="Cache-Control" content="no-cache"> 
                        <h4 class="modal-title"><span id="title"></span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-auto">
                                <label>入力番号：<span id="serial"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>入力した日付：<span id="t_date"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>入力者：<span id="InputterName"></span></label>
                            </div>
                        </div>
                        <div class="row" id="disp_type_customer">
                            <div class="col-auto">
                                <label>顧客名：<span id="target_customer_name"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>種類：<span id="type_flag"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto auto-wrap">
                                <span id="sentence" class="pull-left"></span>
                            </div>
                        </div>
                     </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">閉じる</button>
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
                        <h4 class="modal-title">日報・申し送り削除確認</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-auto">
                                <label>シリアル：<span id="serial"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>日付：<span id="t_date"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>入力者：<span id="InputterName"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>申し送り：<span id="handover_del"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>日報：<span id="daily_report_del"></span></label>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-auto">
                                <label>備考：<span id="remarks_del"></span></label>
                            </div>
                        </div>
                        上記データを削除します。よろしいですか？
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="delTargetHandoverSerial_hdn">
                        <button type="button" id="del_btn" wire:click="del_handover_rec(document.getElementById('delTargetHandoverSerial_hdn').value)" class="btn btn-danger">削除</button>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">キャンセル</button>
                    </div>
                </div>
            </div>
        </div>
        <!--　新規・修正入力 -->
        {{--<div class="modal fade" id="CreateModal" tabindex="-1" aria-hidden="true">--}}
        <div class="modal fade CreateModal" id="CreateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <meta http-equiv="Pragma" content="no-cache">
                        <meta http-equiv="Cache-Control" content="no-cache"> 
                        <h4 class="modal-title">日報・申し送り&nbsp;<span id='modal_title'></span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                    </div>
                    <form name="submitForm" id="submitForm">@csrf
                        <div class="modal-body">
                            <span id="serial_disp_none">
                                <div class="d-flex flex-row mb-2">
                                    <div class="p-2">登録番号</div>
                                    <div class="p-2">
                                        <input type="text" id="id_txt" name="id_txt" wire:model="id_txt" class="form-control" readonly/>
                                    </div>
                                </div>
                            </span>
                            <div class="row justify-content-md-left">
                                <div class="col col-lg-2">入力者</div>
                                <div class="col-md-auto">
                                    {!!$htm_staff_select!!}
                                    <span id="staff_slct_for_error" class="text-danger"></span>
                                </div>
                                <div class="col-md-auto">日　付</div>
                                <div class="col-md-auto">
                                    <input type="date" name="target_date" id="target_date" wire:model="target_date" class="form-control">
                                    <span id="target_date_for_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="my-box col-2">
                                        <input class="form-check-input" type="radio" name="HandOver_DaylyRepo_rbn" wire:model="HandOver_DaylyRepo_rbn" id="handover_rbn" onclick="type_manage()" value="HandOver">
                                        <label class="form-check-label" for="handover_rbn">
                                            申し送り
                                        </label>
                                    </div>
                                    <div class="my-box col-2">
                                        <input class="form-check-input" type="radio" name="HandOver_DaylyRepo_rbn" wire:model="HandOver_DaylyRepo_rbn" id="daylyrepo_rbn" onclick="type_manage()" value="DaylyRepo">
                                        <label class="form-check-label" for="daylyrepo_rbn">
                                            日報
                                        </label>
                                        
                                    </div>
                                    <span id="HandOver_DaylyRepo_rbn_for_error" class="text-danger col-md-auto"></span>
                                </div>
                            </div>
                            <span id="disp_non_customer">
                                <div class="row justify-content-md-left">
                                    <div class="col col-lg-2">対象来店者</div>
                                    <div class="col-md-auto">
                                        <input type="text" name="customer_txt" id="customer_txt" class="form-control" placeholder="直接入力できません。" readonly>
                                        <input type="hidden" name="customer_serial_hdn" id="customer_serial_hdn" wire:model="customer_serial_hdn">
                                    </div>
                                    <div class="col-md-auto">
                                        <label>※下記リストから選択してください。</label>
                                    </div>
                                </div>
                                <div class="row justify-content-md-left">
                                    <div class="col col-lg-2 p-2">来店日から検索</div>
                                        {{--<button type="button" id="customer_serch_by_date_btn" class="btn btn-primary" onclick="show_customers('');">来院日から検索</button>--}}
                                    <div class="col-md-auto p-2"><span id="show_customers_list"></span></div>
                                    <div class="col-md-auto p-2"> 顧客名から検索</div>
                                        {{--<button type="button" id="customer_serch_by_list_btn" class="btn btn-primary" onclick="show_customers_order('');">顧客名から検索</button>--}}
                                    <div class="col-md-auto p-2">
                                        <select id="customer_slct_chosen_id" name="customer_slct_chosen" class="customer_slct_chosen_" onchange="set_customer_serial(this);">
                                            <option value="">選択してください。(検索できます。)</option>
                                        </select>
                                    </div>
                                    {{-- <select id="customer_slct_chosen" class="chosen customer_slct_chosen_1"> --}}
                                    <span id="customer_slct_for_error" class="text-danger"></span>
                                </div>
                            </span>
                                <div>
                                    <textarea id="sentence_txtarea" name="sentence" wire:model="sentence" class="form-control" style="word-break: normal;"></textarea>
                                </div>
                                <span id="sentence_for_error" class="text-danger"></span>
                            {{--
                            <div class="d-flex flex-row mb-2">
                                <div class="p-2 text-start">日報</div>
                                <div class="p-2">
                                    <textarea id="daily_report" name="daily_report" wire:model="daily_report" class="form-control RequiredContent"></textarea>
                                </div>
                                <span id="RequiredContent_for_error" class="text-danger"></span>
                                <span id="test"></span>
                            </div>
                            --}}

                                <div class="p-2 text-start">備考</div>
                                    <textarea id="remarks" name="remarks" wire:model="remarks" class="form-control"></textarea>
                                <input type="hidden" id="error_flg_hdn" name="error_flg_hdn" wire:model="error_flg_hdn"/>
                        <div class="modal-footer">
                            <button type="submit" id="submit_btn" class="btn btn-primary" wire:click="submitForm">保存</button>
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>