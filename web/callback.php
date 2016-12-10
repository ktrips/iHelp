<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}
//Res image
$res_img = "https://ktribot.herokuapp.com/IMG_" . rand(1426,1468) . ".PNG";
  //. $_SERVER['SERVER_NAME'] 
$res_img_url = "<img src=" . $res_img . ">";

//返信データ作成
if ($text == 'dream') {
  $response_format_text = [
    "type" => "template",
    "altText" => "あなた様の夢を教えて下さい",
    "template" => [
      "type" => "buttons",
      //"thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
	"thumbnailImageUrl" => "$res_img",
      "title" => "あなた様の夢を教えて下さい",
      "text" => "いつかこんな一戸建ての家を建てたい",
      "actions" => [
          [
            "type" => "message",
            "label" => "資金プランを見てみる",
            "text" => "資金プラン"
          ],
          [
            "type" => "postback",
            "label" => "とりあえず電話する",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "uri",
            "label" => "詳しく見る",
            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
          ],
          [
            "type" => "message",
            "label" => "もっと大それた夢？",
            "text" => "次も見てみる"
          ]
      ]
    ]
  ];
} else if (preg_match('/(Kobo|コボ|Hello|はろ|Hi)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "Hello Kobot World",
    "template" => [
      "type" => "buttons",
	"thumbnailImageUrl" => "$res_img",
      "title" => "はろーコボットだよ！",
      "text" => "ご主人様、いかがいたしましょうか。",
      "actions" => [
          [
            "type" => "message",
            "label" => "天気予報チェック",
            "text" => "お天気は曇り、気温は15度です。",
	    "uri" => "https://us.wio.seeed.io/v1/node/GroveServoD0/angle/90?access_token=8a0b706c8b4fe6160278d7f72e764614"
          ],
          [
            "type" => "message",
            "label" => "お部屋チェック",
            "text" => "お部屋チェック",
	    "uri" => "https://us.wio.seeed.io/v1/node/GroveAirqualityA0/quality?access_token=eecdb61def9790e172d1ad2a63aed257"
	  ],
          [
            "type" => "postback",
            "label" => "今日の予定チェック",
            "text" => "今日の予定チェック",
	    "data" => "action=buy&itemid=111"
          ],
          [
            "type" => "uri",
            "label" => "今日の運勢",
            "text" => "今日の運勢は、、、ラッキーなことがあるでしょう！",
	    "uri" => "http://ktribot.herokuapp.com/random.php"
          ]
      ]
    ]
  ];
} else if (preg_match('/(温度|クオリティ)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "エアコンつけますか？（はい／いいえ）",
    "template" => [
	"thumbnailImageUrl" => "$res_img",
        "type" => "confirm",
        "text" => "エアコンつけますか？",
        "actions" => [
            [
              "type" => "uri",
              "label" => "つける！",
              "text" => "エアコンつける！",
	      "uri" => "https://us.wio.seeed.io/v1/node/GroveServoD0/angle/90?access_token=8a0b706c8b4fe6160278d7f72e764614"
            ],
            [
              "type" => "uri",
              "label" => "つけない！",
              "text" => "エアコンつけない",	  
	      "uri" => "https://us.wio.seeed.io/v1/node/GroveServoD1/angle/90?access_token=8a0b706c8b4fe6160278d7f72e764614"
            ]
        ]
    ]
  ];
} else if (preg_match('/(お部屋|room|IFTTT)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "お部屋の状況",
    "template" => [
      "type" => "buttons",
	"thumbnailImageUrl" => "$res_img",
      "title" => "お部屋の何をチェックしたいですか？",
      "text" => "お部屋のチェック",
      "actions" => [
          [
            "type" => "message",
            "label" => "部屋の温度、湿度",
            "text" => "お部屋の温度は20度、湿度は30%です。",
	    "uri" => "https://us.wio.seeed.io/v1/node/GroveTempHumD1/temperature?access_token=eecdb61def9790e172d1ad2a63aed257"
          ],
          [
            "type" => "message",
            "label" => "エア・クオリティ",
            "text" => "エアクオリティは30です。",
	    "uri" => "https://us.wio.seeed.io/v1/node/GroveAirqualityA0/quality?access_token=eecdb61def9790e172d1ad2a63aed257"
	  ],
          [
            "type" => "message",
            "label" => "誰かいるかチェック",
            "text" => "誰かいるかチェック",
	    "uri" => "https://us.wio.seeed.io/v1/node/GrovePIRMotionD0/approach?access_token=eecdb61def9790e172d1ad2a63aed257"
  	  ],
          [
            "type" => "message",
            "label" => "ワンちゃんの状況チェック",
            "text" => "ワンちゃんチェック",
	    "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
          ]
      ]
    ]
  ];	
} else if ($text == '誰かいるかチェック') {
  $response_format_text = [
    "type" => "template",
    "altText" => "誰かいる！",
    "template" => [
      "type" => "buttons",
	"thumbnailImageUrl" => "$res_img",
      "title" => "誰かいるみたい！",
      "text" => "そこにいるのはどなた？？",
      "actions" => [
          [
            "type" => "uri",
            "label" => "話しかけてみる",
            "text" => "話しかけてみる",
	    "uri" => "https://us.wio.seeed.io/v1/node/GroveTempHumD1/temperature?access_token=eecdb61def9790e172d1ad2a63aed257"
          ],
          [
            "type" => "message",
            "label" => "威嚇音を出す！",
            "text" => "ぶーーーん！",
	    "uri" => "https://maker.ifttt.com/trigger/ktribot/with/key/dSWLYz6_m8AY6x-nMrdkJ1"
	  ],
          [
            "type" => "uri",
            "label" => "友達になる",
            "text" => "友達になる",
	    "uri" => "https://us.wio.seeed.io/v1/node/GrovePIRMotionD0/approach?access_token=eecdb61def9790e172d1ad2a63aed257"
  	  ],
          [
            "type" => "message",
            "label" => "知らんぷり。。",
            "text" => "知らんぷり。。",
	    "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
          ]
      ]
    ]
  ];
} else if (preg_match('/(知らんぷり|スタンプ)/i', $text)) {
  $response_format_text = [
	"type" => "sticker",
	"packageId" => "85883",
	"stickerId" => "10",
  ];
} else if ($text == 'ワンちゃんチェック') {
  $response_format_text = [
    "type" => "template",
    "altText" => "ワンちゃんの映像見る？（はい／いいえ）",
    "template" => [
	"thumbnailImageUrl" => "$res_img",
        "type" => "confirm",
        "text" => "ワンちゃんの状況知りたいよね？",
        "actions" => [
            [
              "type" => "uri",
              "label" => "映像見る",
              "text" => "ワンちゃん映像",
	      "uri" => "https://www.youtube.com/watch?v=6qA7YTK4kgA"
            ],
            [
              "type" => "message",
              "label" => "興味ない",
              "text" => "ワンちゃん興味なし"
            ]
        ]
    ]
  ];
} else if ($text == '資金プラン') {
  $response_format_text = [
    "type" => "template",
    "altText" => "今、おいくつですか？",
    "template" => [
      "type" => "buttons",
	"thumbnailImageUrl" => "$res_img",
      "title" => "年齢を教えて下さい",
      "text" => "今、おいくつですか？",
      "actions" => [
          [
            "type" => "message",
            "label" => "20代？",
            "text" => "20"
          ],
          [
            "type" => "message",
            "label" => "30代？",
            "text" => "30"
          ],
          [
            "type" => "message",
            "label" => "40代？",
            "text" => "40"
          ],
          [
            "type" => "message",
            "label" => "50代以上？",
            "text" => "50"
          ]
      ]
    ]
  ];
} else if ($text == '20') {
  $response_format_text = [
    "type" => "template",
    "altText" => "若いっていいですね！",
    "template" => [
	"thumbnailImageUrl" => "$res_img",
        "type" => "confirm",
        "text" => "若いっていいですね！がんばって働いてください！",
	"actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "はい"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "いいえ"
            ]
        ]
    ]
  ];
} else if ($text == '次も見てみる') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こんな夢でしょうか？",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "ささやかな夢",
            "text" => "年に一回は海外旅行にいく余裕を持つ",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "資金プランを見てみる",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=111"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "堅実な夢",
            "text" => "お子様に素晴しい教育環境を用意する",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "資金プランを見てみる",
                  "data" => "action=rsv&itemid=222"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=222"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "はたまたこんな夢",
            "text" => "50歳でアーリーリタイアして田舎暮らし",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "資金プランを見てみる",
                  "data" => "action=rsv&itemid=333"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=333"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
} else if (preg_match('/(お金|夢|資産|運用)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "こんにちは あなた様の夢をお聞かせ下さい。（はい／いいえ）",
    "template" => [
	"thumbnailImageUrl" => "$res_img",
        "type" => "confirm",
        "text" => "こんにちは あなた様の夢をお聞かせ下さい。",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "dream"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "no"
            ]
        ]
    ]
  ];
} else if (preg_match('/(いいえ|No|さよなら)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "またお声がけください",
    "template" => [
	"thumbnailImageUrl" => "$res_img",
        "type" => "confirm",
        "text" => "またお声がけください！",
	"actions" => [
            [
              "type" => "message",
              "label" => "続ける",
	      "text" => "コボット",
	      "uri" => "https://us.wio.seeed.io/v1/node/GroveTempHumD1/temperature?access_token=eecdb61def9790e172d1ad2a63aed257"
            ],
            [
              "type" => "message",
              "label" => "終了する",
              "text" => "今日もいい一日を！"
            ]
	]
    ]
  ];
}


$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);
