<div class="container-fluid ml-5">
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">出退勤履歴</div>
                <div class="col">
                    {{-- <input type="button" name="show_calender" id="tshow_calender" value='カレンダー表示'> --}}
                    <input type="button" name="csv_download" id="csv_download" value='ファイルのダウンロード' wire:click="csv_download()">
                </div>
                <div class="col-auto">
                    <div class="row lh-lg">
                        <p class="lh-lg">
                            <div class="col">
                                <label>日付検索： <input name="target_day" id="target_day" type="date" wire:change="search_day(document.getElementById('target_day').value)" value="{{$target_day}}"/></label>
                            </div>
                            <div class="col">
                                <label><button wire:click="search_month(document.getElementById('year_slct').value,document.getElementById('month_slct').value)" class='btn btn-primary btn-sm rounded'>月検索</button>： {!!$html_working_list_year_slct!!} {!!$html_working_list_month_slct!!}</label>
                            </div>
                            <div class="col">
                                <button wire:click="search_day('')" class='btn btn-primary btn-sm rounded'>検索解除</button>    
                                {{--<x-primary-button wire:click="search_day('')" class='btn btn-primary btn-sm rounded'>検索解除</x-primary-button>--}}
                            </div>
                            <div class="col">
                                <label>スタッフ検索： <select name="staff_slct" id="staff_slct" class="form-select form-select-sm" wire:change="set_staff(document.getElementById('staff_slct').value)">
                                    {!!$html_staff_inout_slct!!}
                                    </select></label>
                            </div>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="table_responsive">
                                <tr>
                                    <th>日付&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th>スタッフNo.</th>
                                    <th>スタッフ氏名</th>
                                    <th>出勤時間</th>
                                    <th>退勤時間</th>
                                    <th>勤務時間(分)</th>
                                </tr>
                                @foreach ($histories as $history)
                                    <tr>
                                        <td>{{ $history->target_date }}{{ $history->Week }}</td>
                                        <td>{{ $history->target_serial }}</td>
                                        <td>{{ $history->target_name }}</td>
                                        <td>{{ $history->time_in }}</td>
                                        <td>{{ $history->time_out }}</td>
                                        <td>{{ $history->StaffDiff }}</td>
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
