<div class="container-fluid ml-5">
    <script src="{{  asset('/js/ListCustomer.js') }}" defer></script>
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">顧客一覧</div>
                <div class="row pb-2">
                    <div class="col-auto">
                        <form method="GET" action="{{route('customers.ShowInpNewCustomer')}}">@csrf
                            <button class="btn btn-primary" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規顧客登録</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <button type="button" wire:click="searchClear()" onclick="document.getElementById('kensakukey_txt').value=''">解除</button>
                        <input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey">
                        <button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button>
                    </div>
                </div>
                <table id="table_responsive container-fluid" class="table-striped table-hover table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th class="border px-4 py-2">顧客データ修正
                                <div class="text-nowrap">
                                    <button type="button" wire:click="sort('serial_user-ASC')"><img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('serial_user-Desc')"><img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">
                                契約
                            </th>
                            <th class="border px-4 py-2">
                                <div class="text-nowrap">氏名
                                    <button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">
                                <div class="text-nowrap">しめい
                                    <button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">
                                <div class="text-nowrap">残金
                                    <button type="button" wire:click="sort('zankin-ASC')"> <img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('zankin-Desc')"> <img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                                <div class="text-nowrap">
                                    <p>(合計:<button type="button" name="zankinBtn" id="zankinBtn" wire:click="zankin_search()">{{number_format($totalZankin)}}</button>円)</p>
                                </div>
                            </th>
                            <th class="border px-4 py-2">
                                <div class="text-nowrap">生年月日
                                    <button type="button" wire:click="sort('birth_year-ASC')"> <img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('birth_year-Desc')"> <img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">
                                <div class="text-nowrap">電話番号
                                    <button type="button" wire:click="sort('phone-ASC')"> <img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" /></button>
                                    <button type="button" wire:click="sort('phone-Desc')"> <img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" /></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">取得ポイント
                                <div>
                                    <button type="button" wire:click="sort('total_points-ASC')"><img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" disabled/></button>
                                    <button type="button" wire:click="sort('total_points-Desc')"><img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" disabled/></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">予約日入力
                                <div>
                                    <button type="button" wire:click="sort('yoyaku-ASC')"><img src="{{asset('storage/images/sort_A_Z.png')}}" width="15px" disabled/></button>
                                    <button type="button" wire:click="sort('yoyaku-Desc')"><img src="{{asset('storage/images/sort_Z_A.png')}}" width="15px" disabled/></button>
                                </div>
                            </th>
                            <th class="border px-4 py-2">削除</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('customers.ShowSyuseiCustomer') }}" method="POST">@csrf
                                        <input name="syusei_Btn" type="submit" value="{{ $user->serial_user}}">
                                    </form>
                                </td>
                                <td class="border px-4 py-2">
                                    <form action="/customers/ContractList/{{$user->serial_user}}" method="GET">@csrf<input name="keiyaku_Btn" type="submit" value="履歴・新規">
                                        <input name="page_num" type="hidden" value="{{$users->currentPage()}}"/>
                                    </form>
                                </td>
                                <td class="border px-4 py-2" {!! $user->default_color!!}><div class="text-nowrap">{{ $user->name_sei}}&nbsp;{{ $user->name_mei}}</div></td>
                                <td class="border px-4 py-2"><div class="text-nowrap">{{ $user->name_sei_kana}}&nbsp;{{ $user->name_mei_kana}}</div></td>
                                <td class="border px-4 py-2" style="text-align: right;">{{ number_format($user->zankin)}}</td>
                                <td class="border px-4 py-2"><div class="text-nowrap">{{ $user->birth_year}}-{{ $user->birth_month}}-{{ $user->birth_day}}&nbsp;({{ $user->User_Age}})</div></td>
                                <td class="border px-4 py-2">{{ $user->phone}}</td>
                                <td class="border px-4 py-2">{{ $user->TotalPoints}}</td>
                                <td class="border px-4 py-2"><input name="yoyaku_Btn" type="submit" value="予約日"></td>
                                <td class="border px-4 py-2">
                                    <form action="/customers/deleteCustomer/{{$user->serial_user}}" method="GET">@csrf
                                        <input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $user->serial_user}} {{ $user->name_sei}} {{ $user->name_mei}}');" >
                                        @if (auth('admin')->user()->serial_teacher==='A_0001')
                                            <input name="delete_btn" type="submit" value="完全削除" onclick="return delArert('{{ $user->serial_user}} {{ $user->name_sei}} {{ $user->name_mei}}');" >
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- モーダル・ダイアログ -->
<div class="modal" id="sampleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
          <h4 class="modal-title">タイトル</h4>
        </div>
        <div class="modal-body">
          <label><span id="morau"></span>の好きな食べ物:<input type="text" id="food"></label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
          <button type="button" id="btn1" class="btn btn-primary">ボタン1</button>
        </div>
      </div>
    </div>
  </div>
                {{$users->appends(request()->query())->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
