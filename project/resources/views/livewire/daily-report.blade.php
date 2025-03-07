<div class="container text-center">
    <script src="{{asset('/js/DailyReport.js')}}" defer></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 justify-content-center align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
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
                <div class="mb-2 bg-success text-white">日報</div>
                <div class="card-header">
                    <div class="row h3">
                        {{--<h3><form action="/admin/ShowDailyReport" method="POST" name="getTargetDate_fm" id="getTargetDate_fm">@csrf<input name="target_date" id="target_date" type="date" onchange="getTargetdata(this);" value="{{$today}}"/></form></h3>--}}
                        <div class="col-auto">
                            <form action="{{route('admin.DailyReport.post')}}" method="POST" name="getTargetDate_fm" id="getTargetDate_fm">@csrf<input name="target_date" id="target_date" type="date" onchange="getTargetdata(this);" value="{{$today}}"/></form></h3>
                        </div>
                        <div class="col-auto">
                            合計：{{number_format((int)$total)}}円
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <table class="table-auto" border-solid>
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">No.
                                                {{--								
                                                <button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                                <button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                                --}}
                                    </th>
                                    <th class="border px-4 py-2 col-2">氏名
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
                                    <th class="border px-4 py-2">ｸﾚｼﾞｯﾄ・ﾛｰﾝ<br>契約数・金額(税込）
                                                {{--
                                                <button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                                <button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                                --}}
                                    </th>
                                    <th class="border px-4 py-2">PayPay</th>
                                    {{-- 
                                    <th class="border px-4 py-2">月額（現金分割）<br>契約数・金額(税込）
                                    </th>
                                    --}}
                                    <th class="border px-4 py-2">現金売上(現金分割・一括支払い)(税込）
                                                {{--
                                                <button type="button" wire:click="sort('birth_year-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                                <button type="button" wire:click="sort('birth_year-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                                --}}
                                    </th>
                                    {{-- 
                                    <th class="border px-4 py-2">現金売上合計<br>契約数・金額(税込）
                                    </th>
                                    --}}
                                    <th class="border px-4 py-2">施術合計<br>金額(税込）
                                                {{--
                                                <button type="button" wire:click="sort('phone-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                                <button type="button" wire:click="sort('phone-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                                --}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PaymentHistories as $PaymentHistory)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $PaymentHistory->serial_user}}<br></td>
                                        <td class="border px-4 py-2">
                                            @if($PaymentHistory->ContractType=='subscription')
                                                <form action="/customers/ShowPaymentRegistrationIflame/{{$PaymentHistory->serial_keiyaku}}/{{$PaymentHistory->serial_user}}" method="GET">@csrf
                                                    {{--<input name="Record_Btn" type="submit" value="{{$dContracts->date_latest_visit}}">--}}
                                                    <button type="submit" name="btn_serial" value="{{$PaymentHistory->serial_user}}">{{ $PaymentHistory->name_sei}}&nbsp;{{ $PaymentHistory->name_mei}}</button>
                                                </form>    
                                            @else
                                                <form method="GET" action="{{ route('customers.ShowInpRecordVisitPayment.get',['SerialKeiyaku' => $PaymentHistory->serial_keiyaku,'SerialUser'=>$PaymentHistory->serial_user])}}">@csrf
                                                    <button type="submit" name="btn_serial" value="{{$PaymentHistory->serial_user}}">{{ $PaymentHistory->name_sei}}&nbsp;{{ $PaymentHistory->name_mei}}</button>
                                                    <input name="target_day" type="hidden" value="{{$today}}"/>
                                                </form>    
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">&nbsp;</td>
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->Card_Amount!=="")
                                                {{ number_format($PaymentHistory->Card_Amount)}}
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->PayPay_Amount!=="")
                                                {{ number_format($PaymentHistory->PayPay_Amount)}}
                                            @endif
                                        </td>
                                        {{-- 
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->Cash_Split!=="")
                                                {{ number_format($PaymentHistory->Cash_Split)}}
                                            @endif
                                        </td>
                                        --}} 
                                    
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->Cash_Amount!=="")
                                                {{number_format($PaymentHistory->Cash_Amount)}}
                                            @endif
                                        </td>
                                        {{--  
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->Cash_Total!=="" )
                                                {{ number_format($PaymentHistory->CashTotal)}}
                                            @endif
                                        </td>
                                        --}}
                                        <td class="border px-4 py-2" style="text-align: right;">
                                            @if($PaymentHistory->amount_payment!=="")
                                                {{number_format($PaymentHistory->amount_payment)}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="border px-4 py-2" colspan="3" style="text-align: right;">合計</td>
                                    <td class="border px-4 py-2" style="text-align: right;">
                                        @if($Sum['card']!=="")
                                            {{ number_format($Sum['card'])}}
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2" style="text-align: right;">
                                        @if($Sum['card']!=="")
                                            {{ number_format($Sum['paypay'])}}
                                        @endif
                                    </td>
                                    {{-- 
                                    <td class="border px-4 py-2" style="text-align: right;">
                                        @if($Sum['CashSplit']!=="")
                                            {{ number_format($Sum['CashSplit'])}}
                                        @endif
                                    </td>
                                    --}}
                                    <td class="border px-4 py-2" style="text-align: right;">
                                        @if($Sum['cash']!=="")
                                            {{ number_format($Sum['cash'])}}
                                        @endif
                                    </td>
                                    {{-- 
                                    <td class="border px-4 py-2" style="text-align: right;">
                                        @if($Sum['total_cash']!=="")
                                            {!! number_format($Sum['total_cash'])!!}
                                        @endif
                                    </td>
                                     --}}
                                    <td class="border px-4 py-2" style="text-align: right;">{{ number_format($Sum['total'])}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    {{--{!!$users->appends(request()->query())->links('pagination::bootstrap-4')!!}--}}
                    {{ $PaymentHistories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>