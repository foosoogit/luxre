<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configration;
use App\Models\Staff;
use App\Models\TreatmentContent;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		$admins =[ 
			[
				'name' => 'fsuzuki',
				'serial_admin' => 'A_000',
				'email' => 'awa@szemi-gp.com',
				'password' => Hash::make('0000'),
			],
			[
				'name' => 'ksuzuki',
				'serial_admin' => 'A_001',
				'email' => 'moezbeauty.ts@gmail.com',
				'password' => Hash::make('0101'),
			],
		];
		foreach($admins as $admin){
            Admin::create($admin);
        }

		$treatmentcontents = [
			[
				'serial_treatment_contents'=> "Tr_00003",
				'name_treatment_contents' => '全顔脱毛',
				'name_treatment_contents_kana'=> 'カオ',
				'treatment_details'=> '顔全体し',
            ],
			[
				'serial_treatment_contents'=> "Tr_00005",
				'name_treatment_contents' => '脇',
				'name_treatment_contents_kana'=> 'ワキ',
				'treatment_details'=> '脇',
            ],
			[
				'serial_treatment_contents'=> "Tr_00008",
				'name_treatment_contents' => 'VIO',
				'name_treatment_contents_kana'=> 'VIO',
				'treatment_details'=> 'VIO',
            ],
			[
				'serial_treatment_contents'=> "Tr_00014",
				'name_treatment_contents' => 'パーツ',
				'name_treatment_contents_kana'=> 'パーツ',
				'treatment_details'=> 'パーツ',
            ],
			[
				'serial_treatment_contents'=> "Tr_00017",
				'name_treatment_contents' => 'ひざ上下・ひじ上下',
				'name_treatment_contents_kana'=> 'ヒザジョウゲ',
				'treatment_details'=> 'ひざ上下・ひじ上下',
			],
			[
				'serial_treatment_contents'=> "Tr_00018",
				'name_treatment_contents' => 'ひざ下',
				'name_treatment_contents_kana'=> 'ヒザシタ',
				'treatment_details'=> 'ひざ下',
			],
			[
				'serial_treatment_contents'=> "Tr_00019",
				'name_treatment_contents' => 'ひじ下',
				'name_treatment_contents_kana'=> 'ヒジシタ',
				'treatment_details'=> 'ひじ下',
			],
			[
				'serial_treatment_contents'=> "Tr_00020",
				'name_treatment_contents' => 'ひじ下ワキ',
				'name_treatment_contents_kana'=> 'ヒジワキ',
				'treatment_details'=> 'ひじ下ワキ',
			],
			[
				'serial_treatment_contents'=> "Tr_00021",
				'name_treatment_contents' => 'フェイシャル',
				'name_treatment_contents_kana'=> 'フェイシャル',
				'treatment_details'=> 'フェイシャル',
			],
			[
				'serial_treatment_contents'=> "Tr_00022",
				'name_treatment_contents' => 'マツエク',
				'name_treatment_contents_kana'=> 'マツエク',
				'treatment_details'=> 'マツエク',
			],
			[
				'serial_treatment_contents'=> "Tr_00024",
				'name_treatment_contents' => 'マッサージ',
				'name_treatment_contents_kana'=> 'マッサージ',
				'treatment_details'=> 'マッサージ',
			],
			[
				'serial_treatment_contents'=> "Tr_00025",
				'name_treatment_contents' => 'メイクアップ',
				'name_treatment_contents_kana'=> 'メイクアップ',
				'treatment_details'=> 'メイクアップ',
			],
			[
				'serial_treatment_contents'=> "Tr_00027",
				'name_treatment_contents' => '全身脱毛　顔VIO除く',
				'name_treatment_contents_kana'=> 'ゼンシンダツモウ',
				'treatment_details'=> '全身脱毛　顔VIO除く',
			],
			[
				'serial_treatment_contents'=> "Tr_00028",
				'name_treatment_contents' => '全身脱毛＋顔＋VIO',
				'name_treatment_contents_kana'=> 'ゼンシンダツモウ',
				'treatment_details'=> '全全身脱毛＋顔＋VIO',
			],
			[
				'serial_treatment_contents'=> "Tr_00029",
				'name_treatment_contents' => '全身脱毛10回コース（顔・VIO込）',
				'name_treatment_contents_kana'=> NULL,
				'treatment_details'=> NULL,
			],
			[
				'serial_treatment_contents'=> "Tr_00030",
				'name_treatment_contents' => 'キャビテーション',
				'name_treatment_contents_kana'=> 'キャビテーション',
				'treatment_details'=> NULL,
			],
			[
				'serial_treatment_contents'=> "Tr_00031",
				'name_treatment_contents' => '脱毛・キャビ・フェイシャル24回',
				'name_treatment_contents_kana'=> 'ダツモウ',
				'treatment_details'=> NULL,
			],
			[
				'serial_treatment_contents'=> "Tr_00033",
				'name_treatment_contents' => 'エリアシ',
				'name_treatment_contents_kana'=> NULL,
				'treatment_details'=> NULL,
			],
			[
				'serial_treatment_contents'=> "Tr_00035",
				'name_treatment_contents' => 'オールメニュー',
				'name_treatment_contents_kana'=> 'オー',
				'treatment_details'=> NULL,
			],
			[
				'serial_treatment_contents'=> "Tr_00036",
				'name_treatment_contents' => 'ステラ痩身',
				'name_treatment_contents_kana'=> 'ステラソウシン',
				'treatment_details'=> '電磁パルス痩身',
			],
		];

		foreach($treatmentcontents as $treatmentcontent){
            TreatmentContent::create($treatmentcontent);
        }

		$staffs = [
			[
				'serial_staff'=> "SF_002",
				'last_name_kanji' => '川島',
				'first_name_kanji'=> '花乃',
				'last_name_kana'=> 'かわしま',
				'first_name_kana'=> 'かの',
            ],
        ];

		foreach($staffs as $staff){
            Staff::create($staff);
        }

		$configrations = [
			[
				'subject'=> "KeiyakuNumMax",
				'value1' => "24",
				'setumei' => '最大契約回数',
            ],
			[
				'subject'=> "Card Company",
				'value1' => "VISA,Master,AMEX",
				'setumei' => "クレジット会社",
            ],
			[
				'subject'=> "DdisplayLineNumCustomerList",
				'value1' => "15",
				'setumei' => "顧客リストの表示行数",
            ],
			[
				'subject'=> "DdisplayLineNumContractList",
				'value1' => "15",
				'setumei' => "契約リストの表示行数",
			],
			[
				'subject'=> "ReasonComing",
				'value1' => "ホットペッパー,Instagram,美シャインホームページ,知人の紹介,チラシ,その他",
				'setumei' => "来院のきっかけｹ",
			],
			[
				'subject'=> "MaxTreatmentsTimes",
				'value1' => "24",
				'setumei' => "最大施術回",
			],
			[
				'subject'=> "PaymentNumMax",
				'value1' => "12",
				'setumei' => "分割支払最大回数",
			],
			[
				'subject'=> "KesanMonth",
				'value1' => "8",
				'setumei' => "決算月",
			],
			[
				'subject'=> "TargetContractMoney",
				'value1' => "2022-05-3000000,2022-06-3000000,2022-08-1500000,2022-07-3500000,2022-02-200000,2022-04-3000000,2022-09-2000000,2022-03-3000000,2022-10-1500000,2022-11-1500000,2022-12-1500000,2023-01-1500000,2023-02-1500000,2023-03-1500000,2023-04-1500000,2023-05-1500000,2023-06-1500000,2023-07-1500000,2023-08-1500000,2023-09-1500000,2023-10-1000000,2023-11-1500000,2023-12-1500000,2024-01-1000000",
				'setumei' => "契約目標金額",
			],
			[
				'subject'=> "PageInf",
				'value1' => "top,メニュー,admin.top;ContractList,契約リスト,customers.ContractList.post;CustomersList,顧客リスト,customers.CustomersList.show.post;DailyReport,日報,admin.DailyReport.post;MonthlyReport,月報,admin.MonthlyReport.post;TreatmentList,施術一覧,admin.TreatmentList.post",
				'setumei' => "URLから対応ページ設定",
			],
			[
				'subject'=> "UserPointVisit",
				'value1' => "10",
				'setumei' => "来店時ポイント",
			],
			[
				'subject'=> "UserPointReferral",
				'value1' => "20",
				'setumei' => "紹介時ポイント",
			],
			[
				'subject'=> "PointValidityTerm",
				'value1' => "1",
				'setumei' => "ポイント有効期間(年数)",
			],
			[
				'subject'=> "BookingDisplayPeriod",
				'value1' => "7",
				'setumei' => "予約連絡表示期間(日)",
			],
			[
				'subject'=> "BirthdayDisplayPeriod",
				'value1' => "7",
				'setumei' => "誕生日表示期間(日)",
			],
        ];

		foreach($configrations as $configration){
            Configration::create($configration);
        }

    }
}
