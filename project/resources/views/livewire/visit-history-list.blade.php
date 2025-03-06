<div class="container-fluid pr-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex justify-content-end">
        <div class="pb-4 align-middle">
            <div class="mb-2 bg-secondary text-white">来店記録</div>
		    <div class="row pb-2">
                <div class="col-auto">
                    <button type="button" name="update_btn" id="update_btn" class="btn btn-success btn-sm modalBtn" onclick="location_href()">更新</button>
                </div>
                <div class="col-auto">
                    <button type="button" name="create_btn" id="create_btn" class="btn btn-primary btn-sm modalBtn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#ModifyModal" 
                        data-nserial="{{$newVisitHistorySerial}}"
                        data-name="{{$User_name}}">
                        新規登録
                    </button>
                </div>
                <div class="col-auto">
                    <button type="button" wire:click="searchClear()" onclick="document.getElementById('Vkensakukey_txt').value=''" disabled>解除</button>
                    <input type="text" name="Vkensakukey_txt" id="Vkensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="Vkensakukey" disabled>
                    <button type="button" name="SerchBtn" id="SerchBtn" wire:click="Vsearch()" disabled>検索</button>
                </div>
            </div>

            <table id="table_responsive container-fluid" class="table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th class="border px-4 py-2">来店番号(修正)
                            <div class="text-nowrap">
                                <button type="button" wire:click="Vsort('visit_history_serial-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="Vsort('visit_history_serial-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px"/></button>
                            </div>   
                        </th>
                        <th class="border px-4 py-2">来店日(カルテ入力)
                            <div class="text-nowrap">
                                <button type="button" wire:click="Vsort('date_visit-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="Vsort('date_visit-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">施術内容
                            <div class="text-nowrap">
                                <button type="button" wire:click="Vsort('treatment_dtails-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="Vsort('treatment_dtails-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        <th class="border px-4 py-2">施術者
                            <div class="text-nowrap">
                                <button type="button" wire:click="Vsort('last_name_kana-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="Vsort('last_name_kana-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                        {{-- 
                        <th class="border px-4 py-2">取得ポイント
                            <div class="text-nowrap">
                                <button type="button" wire:click="Vsort('point-ASC')" disabled><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                <button type="button" wire:click="Vsort('point-Desc')" disabled><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                            </div>
                        </th>
                         --}}
                        <th class="border px-4 py-2">削除</th>
                    </tr>
                </thead>
                <tbody>
                    
                   @foreach ($VisitHistoryQuery as $dVisitHistory)
                        <tr>
                            <td class="border px-4 py-2">
                                <button type="button" id="modify_btn_{{$dVisitHistory->visit_history_serial}}" class="btn btn-info modalBtn btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ModifyModal" 
                                    data-num="{{$dVisitHistory->VisitNum}}" 
                                    data-sejyutu_naiyou="{{$dVisitHistory->treatment_dtails}}" 
                                    data-visit_history_serial="{{$dVisitHistory->visit_history_serial}}" 
                                    data-name="{{$User_name}}"
                                    data-visit_date="{{$dVisitHistory->date_visit}}"
                                    data-sejyutusya="{{$dVisitHistory->last_name_kanji}}&nbsp;{{$dVisitHistory->first_name_kanji}}"
                                > 
                                    {{--data-point="{{$dVisitHistory->point}}" --}}
                                {{$dVisitHistory->VisitNum}}
                                </button>
                            </td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('customers.ShowMedicalRecordIflame') }}" method="POST">@csrf
                                    <button name="count_btn" type="submit" value="{{$dVisitHistory->visit_history_serial}}" formtarget="_blank" class="btn btn-outline-primary btn-sm">{{$dVisitHistory->date_visit}}</button>
                                </form>
                            </td>
                            <td class="border px-4 py-2">
                                {{$dVisitHistory->treatment_dtails}}
                            </td>
                            <td class="border px-4 py-2">
                                {{$dVisitHistory->last_name_kanji}}&nbsp;{{$dVisitHistory->first_name_kanji}}
                            </td>
                            {{--
                            <td class="border px-4 py-2">
                                {{$dVisitHistory->point}}
                            </td>
                            --}}
                            <td class="border px-4 py-2">
                                <form action="/customers/deleteContract/{{$dVisitHistory->serial_keiyaku}}/{{$dVisitHistory->serial_user}}" method="GET">@csrf
                                    <input disabled name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $dVisitHistory->serial_user}} {{ $dVisitHistory->name_sei}} {{ $dVisitHistory->name_mei}}');" >
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
	        {{$VisitHistoryQuery->appends(request()->query())->links('pagination::bootstrap-5')}}

            <!-- モーダル・ダイアログ -->
            <div class="modal fade" id="ModifyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <meta http-equiv="Pragma" content="no-cache">
                            <meta http-equiv="Cache-Control" content="no-cache"> 
                            <h4 class="modal-title">来店履歴修正</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-auto">
                                    <label>来店シリアル：<span id="visit_history_serial"></span></label>
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
                                <label>来店日：<input type="date" id="visit_date"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>施術内容：<span id="tr"></span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label>施術者：<span id="sejyutusya"></span></label>
                                
                            </div>
                        </div>
                        <div class="row">
                            &nbsp;&nbsp;※施術者を修正するときは、カルテを修正してください。
                        </div>
                        {{-- 
                        <div class="row">
                            <div class="col-auto">
                                <label>取得ポイント：<input type="text" id="point"></label>
                            </div>
                        </div>
                         --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">キャンセル</button>
                        <button type="button" id="btn1" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
