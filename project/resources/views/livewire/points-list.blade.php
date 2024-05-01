<div class="container-fluid ml-5">
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">ポイント管理</div>
                <div class="col-auto">
                    <div class="row lh-lg">
                        <p class="lh-lg">
                            <div class="col">
                                <label>日付検索： </label>
                            </div>
                            <div class="col">
                                <input name="target_day" id="target_day" type="date" wire:change="search_day(document.getElementById('target_day').value)" value="{{$target_day}}"/>
                            </div>
                            <div class="col">
                                <button wire:click="search_day('')" class='btn btn-primary btn-sm rounded'>検索解除</button>    
                                {{--<x-primary-button wire:click="search_day('')" class='btn btn-primary btn-sm rounded'>検索解除</x-primary-button>--}}
                            </div>
                            <div class="col">
                                <label>検索： </label>
                            </div>
                            {{--  
                            <div class="col">
                                <input name="target_day" id="target_day" type="date" wire:change="search_day(document.getElementById('target_day').value)" value="{{$target_day}}"/>
                            </div>
                            --}}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="table_responsive">
                                <tr>
                                    <th>ポイントID</th>
                                    <th>ポイント取得日&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort_day('target_date-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th>顧客番号</th>
                                    <th>顧客氏名</th>
                                    <th>取得方法</th>
                                    <th>来店日</th>
                                    <th>紹介した人</th>
                                    <th>取得ポイント</th>
                                    <th>ポイント消滅日</th>
                                </tr>
                                @foreach ($points_histories as $history)
                                    <tr>
                                        {{--<td>{{ $history->points_id }}</td>--}}
                                        <td>{{ $history->id }}</td>
                                        <td>{{ $history->date_get }}</td>
                                        <td>{{ $history->serial_user }}</td>
                                        {{--<td>{{ $history->name_sei }}&nbsp;{{ $history->name_mei }}</td>--}}
                                        <td>{{ $history->UserName }}</td>
                                        <td>{{ $history->method }}</td>
                                        <td>{{ $history->visit_date }}</td>
                                        <td>{{ $history->ReferredName }}</td>
                                        <td>{{ $history->point }}</td>
                                        <td>{{ $history->note }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    {{$points_histories->appends(request()->query())->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>