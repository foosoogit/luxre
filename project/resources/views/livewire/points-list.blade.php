<div class="container-fluid ml-5">
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">ポイント管理</div>
                <div class="container text-center">
                    <div class="row justify-content-start">
                        <div class="col-auto form-check form-check-inline">
                            {{--  
                            <input type="checkbox" name="state_cbx" id="state_cbx_validity" wire:click="state_validity('{{$state_validity_flg}}')" class="form-check-input" {{session('state_validity')}} >
                            <input type="checkbox" name="state_cbx_validity" id="state_cbx_validity" wire:click="state_validity('checked')" class="form-check-input" value="true"{!!session('state_validity_checked')!!} {!!$state_validity_checked!!}>
                            --}}
                            <input type="checkbox" name="state_cbx_validity" id="state_cbx_validity" wire:click="state_validity(document.getElementById('state_cbx_validity').checked)" class="form-check-input" value="true" {!!session('state_validity_checked')!!}>
                            <label class="form-check-label" for="state_cbx_validity">&nbsp;有効</label>
                        </div>
                        <div class="col-auto form-check form-check-inline">
                            {{--<input type="checkbox" name="state_cbx_used" id="state_cbx_used" wire:click="state_used('checked')" class="form-check-input"  value="true"{!!session('state_used_checked')!!} {!!$state_used_checked!!}>--}}
                            <input type="checkbox" name="state_cbx_used" id="state_cbx_used" wire:click="state_used(document.getElementById('state_cbx_used').checked)" class="form-check-input"  value="true" {!!session('state_used_checked')!!}>
                            <label class="form-check-label" for="state_cbx_used">&nbsp;消化済み</label>
                        </div>
                    </div>
                </div>
                
                    <div class="row">
                        <p class="lh-lg">
                            <div class="col-auto">
                                <label>日付検索：</label>
                                <input name="target_day" id="target_day" type="date" wire:change="search_date(document.getElementById('target_day').value)" value="{{$serch_date_key}}"/>
                            </div>
                            <div class="col-auto">
                                <label>検索：</label>
                                <input name="search_key" id="search_key" type="text" wire:change="search(document.getElementById('search_key').value)" value="{{$serch_key}}"/>
                            </div>
                            <div class="col-auto">
                                {{-- <button onclick="document.getElementById('search_key').value='';)" wire:click="searchClear()" class='btn btn-primary btn-sm rounded'>検索解除</button>     --}}
                                <button onclick="clear_serch();" wire:click="searchClear()" class='btn btn-primary btn-sm rounded'>検索解除</button>
                            </div>
                        </p>
                    </div>
            
                    <div class="row">
                        <div class="col">
                            <table id="table_responsive">
                                <tr>
                                    <th>ポイントID</th>
                                    <th>ポイント取得日&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort('date_get-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort('date_get-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th>顧客番号&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
                                    <th>顧客氏名&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort('name_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort('name_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
                                    <th>取得方法</th>
                                    <th>来店日&nbsp;<button type="button" class="btn-orderby-border" wire:click="sort('visit_date-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" class="btn-orderby-border" wire:click="sort('visit_date-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
                                    {{--<th>紹介した人</th>--}}
                                    <th>取得ポイント(タップで修正)</th>
                                    <th>消化</th>
                                    {{--<th>ポイント消滅日</th>--}}
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
                                        {{--<td>{{ $history->ReferredName }}</td>wire:click="change_point('{{ $history->id }}')"--}}
                                        <td>
                                            
                                            @if($history->digestion_flg=='true')
                                                <input type="button" class="btn btn-light btn-sm text-muted" name="change_point_btn_{{ $history->id }}" id="change_point_btn_{{ $history->id }}" value="{{ $history->point }}" readonly/>
                                            @else
                                                <input type="button" class="btn btn-info btn-sm" onclick="change_point('{{ $history->id }}')" name="change_point_btn_{{ $history->id }}" id="change_point_btn_{{ $history->id }}" value="{{ $history->point }}"/>
                                            @endif

                                        </td>
                                        <td>
                                            @if($history->digestion_flg=='true')
                                                <input type="button" class="btn btn-outline-warning btn-sm" onclick="point_digestion('{{ $history->id }}')" name="point_digestion_btn_{{ $history->id }}" id="point_digestion_btn_{{ $history->id }}" value="復元"/></button>
                                            @else
                                                <input type="button" class="btn btn-warning btn-sm" onclick="point_digestion('{{ $history->id }}')" name="point_digestion_btn_{{ $history->id }}" id="point_digestion_btn_{{ $history->id }}" value="消化"/></button>
                                            @endif
                                        </td>
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