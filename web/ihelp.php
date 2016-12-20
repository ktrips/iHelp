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

//$content      = $json_object->result{0}->content;
//$from         = $content->from;
//$message_id   = $content->id;
//$content_type = $content->contentType;

$proxy         = getenv('FIXIE_URL');
$docomoApiKey  = getenv('DOCOMO_API_KEY');
$redisUrl      = getenv('REDIS_URL');

// $contextの設定
//$redis   = new Predis\Client($redisUrl);
//$context = $redis->get($from);

//$dialog = new Dialogue($docomoApiKey);

//Docomo  送信パラメータの準備
//$dialog->parameter->reset();
//$dialog->parameter->utt = $text;
//$dialog->parameter->t = 20;
//$dialog->parameter->context = $context;
//$dialog->parameter->mode = $mode;

//$ret = $dialog->request();

//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}
//Res image
$res_img = "https://ktribot.herokuapp.com/IMG_" . rand(1426,1468) . ".PNG";
  //. $_SERVER['SERVER_NAME'] 
$res_img_url = "<img src=" . $res_img . ">";

//返信データ作成
if (preg_match('/(携帯|mobile|iPhone|電話)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "携帯電話ですね！",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
	//"thumbnailImageUrl" => "$res_img",
      "title" => "携帯電話ですね！",
      "text" => "携帯でどうしたいですか？",
      "actions" => [
          [
            "type" => "message",
            "label" => "新しい携帯電話の注文",
            "text" => "new mobile"
          ],
          [
            "type" => "postback",
            "label" => "携帯電話の設定",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "uri",
            "label" => "携帯電話を海外で使えるようにする",
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
} else if (preg_match('/(new mobile)/i', $text)) {
  $response_format_text = [
    "type" => "template",
    "altText" => "そんなあなたにはこちら！",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "iPhone?",
            "text" => "iPhoneを選ぶ",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "このファンドを買う！",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話で相談する",
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
            "title" => "リート・ファンド",
            "text" => "国内不動産に投資するリート",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "このファンドを買う！",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話で相談する",
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
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "ETFファンド",
            "text" => "上場投信ETF",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "このファンドを買う！",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話で相談する",
                  "data" => "action=pcall&itemid=111"
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
} else if ($text == '0s') {
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
} else if (preg_match('/(金|夢|資産|運用|家|money|asset|house})/i', $text)) {
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
} else if (preg_match('/(いいえ|No|さよなら|なし|つけない)/i', $text)) {
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
