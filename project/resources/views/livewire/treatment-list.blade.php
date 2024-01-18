<div class="container text-center">
    <script src="{{  asset('/js/Common.js') }}" defer></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 justify-content-center align-middle">
                @include('layouts.header')
                {{--
                <div class="row">
                    <div class="col-auto">
                        <a class="btn mb-2 btn-primary" href="{{route('admin.top')}}">メニューに戻る</a>
                    </div>
                    
                    @if(isset($target_historyBack_inf_array[1]))
                    @if($target_historyBack_inf_array[1]!=='admin.top')
                        <div class="col-auto">
                            <form method="POST" action="{{route($target_historyBack_inf_array[1])}}">@csrf
                                @if(isset( $target_day ))
                                    <input name="target_day" type="hidden" value="{{$target_day}}"/>
                                    <button type="submit" name="target_date" class="btn btn-primary" value="{{$target_day}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                                @endif
                                @if(isset( $today ))
                                    <input name="year_month_day" type="hidden" value="{{$today}}"/>
                                    <button type="submit" name="target_date" class="btn btn-primary" value="{{$today}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                                @endif
                                <input name="back_flg" type="hidden" value="true"/>
                            </form>
                        </div>
                    @endif
                    @endif
                    
                </div>
                --}}
                <div class="mb-2 bg-success text-white">施術登録リスト</div>
                <div class="card-header">
                    <div class="row h3">
                        <form method="GET" action="/admin/InpTreatment/new">@csrf
                            <button class="btn btn-primary" type="submit" name="NewTreatmentBtn" value="new">新規施術登録</button>
                        </form>	
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table-auto" border-solid>
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">施術番号(修正)
                                        {{--								
                                        <button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">施術名
                                        {{--
                                        <button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">施術名 かな
                                        {{--
                                        <button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
    
                                    <th class="border px-4 py-2">施術内容
                                        {{--
                                            <button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                            <button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                        </th>
                                    <th class="border px-4 py-2">メモ
                                        {{--									
                                        <button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">削除
                                        {{--									
                                        <button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
    
                                        --}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($treatment_contents as $treatment_content)
                                    <tr>
                                        <td class="border px-4 py-2"><form action="/workers/ShowSyuseiTreatmentContent/{{ $treatment_content->serial_treatment_contents}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{ $treatment_content->serial_treatment_contents}}"></form></td>
                                        <td class="border px-4 py-2">{{ $treatment_content->name_treatment_contents}}</td>
                                        <td class="border px-4 py-2">{{ $treatment_content->name_treatment_contents_kana}}</td>
                                        <td class="border px-4 py-2" style="text-align: left;">{{ $treatment_content->treatment_details }}</td>
                                        <td class="border px-4 py-2" style="text-align: left;">{{ $treatment_content->memo}}</td>
                                        <td class="border px-4 py-2" style="text-align: left;">
                                            <form action="/workers/deleteTreatmentContent/{{$treatment_content->serial_treatment_contents}}" method="GET">@csrf
                                                <input name="delete_btn" type="submit" value="削除" onclick="return delArert('施術番号：{{$treatment_content->serial_treatment_contents}} 施術名:{{$treatment_content->name_treatment_contents}}');">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $treatment_contents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
