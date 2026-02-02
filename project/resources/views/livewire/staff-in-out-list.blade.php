<div class="container-fluid ml-5">
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">入退勤履歴</div>
                <div class="col">
                    {{-- <input type="button" name="show_calender" id="tshow_calender" value='カレンダー表示'> --}}
                    <input type="button" name="csv_download" id="csv_download" value='ファイルのダウンロード' wire:click="csv_download()">
                </div>
                <div class="col-auto">
                    <div class="row lh-lg">
                        <p class="lh-lg">
                            <div class="col">
                               {{--  <input name="target_day" id="target_day" type="date" wire:model.live="search_day(document.getElementById('target_day').value)" value="{{$target_day}}"/></label> --}}
                                <label>日付検索： <input name="target_day" id="target_day" type="date" wire:model.live="search_day()" value="{{$target_day}}"/></label>
                            </div>
                            <div class="col">
                                {{--<button wire:click="search_month(document.getElementById('year_slct').value,document.getElementById('month_slct').value)" class='btn btn-primary btn-sm rounded'>月検索</button>： {!!$html_working_list_year_slct!!}--}}
                                <button wire:click="search()" class='btn btn-primary btn-sm rounded'>月検索</button>： {!!$html_working_list_year_slct!!}
                            </div>
                            <div class="col">
                                {!!$html_working_list_month_slct!!}
                            </div> 
                            <div class="col">
                                <button wire:click="searchClear()" class='btn btn-primary btn-sm rounded'>検索解除</button>    
                            </div>
                            <div class="col">
                                {{--<label>スタッフ検索： <select name="staff_slct" id="staff_slct" class="form-select form-select-sm" wire:change="set_staff(document.getElementById('staff_slct').value)">--}}
                                    <label>スタッフ検索：
                                        {{-- <select name="staff_slct" id="staff_slct" class="form-select form-select-sm" wire:change="set_staff(document.getElementById('staff_slct').value)">--}}
                                        {{-- <select name="year_slct" id="year_slct" class="form-select" wire:model.change="target_staff_serial"> --}}
                                        <select name="year_slct" id="year_slct" class="form-select" wire:model.change="target_staff_serial">
                                    {!!$html_staff_inout_slct!!}
                                    </select></label>
                            </div>
                            <div class="col">※Enterで更新</div>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="table_responsive">
                                <tr>
                                    <th>データID</th>
                                    <th>日付(修正)&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th>スタッフ氏名</th>
                                    <th>出勤時間</th>
                                    <th>退勤時間</th>
                                    <th>勤務時間(分)</th>
                                    <th>遅刻理由</th>
                                    <th>備考</th>
                                    <th>削除</th>
                                </tr>
                                @foreach ($histories as $history)
                                    <tr> 
                                        <td>{{$history->id}}</td>
                                        <td>
                                            <input data-format="dd-MM-yyyy" type="date" class="btn btn-outline-primary btn-sm target_date" name="target_date_{{$history->id}}" id="target_date_{{$history->id}}" value="{{ $history->target_date }}" onclick="ReleaseReadOnly(this);" readonly>
                                            @if($history->Week=="日")
                                                (<span class="text-danger">{{ $history->Week }}</span>)
                                            @elseif($history->Week=="土")   
                                                (<span class="text-primary">{{ $history->Week }}</span>)
                                            @else
                                                (<span class="text-secondary">{{ $history->Week }}</span>)
                                            @endif
                                        </td>
                                        <td>{{$history->target_name}}</td>
                                        <td>
                                            <input data-format="hh:mm:ss" type="time" step="1" class="btn btn-outline-success btn-sm target_date" name="time_in_{{$history->id}}" id="time_in_{{$history->id}}" value="{{$history->TimeOnlyIn}}" onclick="ReleaseReadOnly(this);" readonly>
                                        </td>
                                        <td>
                                            <input data-format="hh:mm:ss" type="time" step="1" class="btn btn-outline-success btn-sm target_date" name="time_out_{{$history->id}}" id="time_out_{{$history->id}}" value="{{$history->TimeOnlyOut}}" onclick="ReleaseReadOnly(this);" readonly>
                                        </td>
                                        <td>{{$history->StaffDiff}}</td>
                                        <td><input type="text" name="reason_late_{{$history->id}}" id="reason_late_{{$history->id}}" data-toggle="tooltip" data-placement="top" title="{{$history->reason_late}}" class="form-control form-control-sm text-truncate target_date" onclick="ReleaseReadOnly(this);" readonly value="{{ $history->reason_late }}" /></td>
                                        <td><input type="text" name="remarks_{{$history->id}}" id="remarks_{{$history->id}}" data-toggle="tooltip" data-placement="top" title="{{$history->remarks}}" class="form-control form-control-sm text-truncate target_date" onclick="ReleaseReadOnly(this);" readonly value="{{$history->remarks}}" /></td>
                                        <td>
                                            <button type="button" onclick="delArert('{{$history->id}}') || event.stopImmediatePropagation()" wire:click="del_rec('{{$history->id}}')" class="btn btn-outline-warning btn-sm del" name="target_del_{{$history->id}}" id="target_del_{{$history->id}}">Del</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {{$histories->appends(request()->query())->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>
