<?php
$telegram_ip_ranges = [
    ['lower' => '149.154.160.0', 'upper' => '149.154.175.255'],
    ['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],
];
$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok=false;
foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok) {
    $lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
    $upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
    if ($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok=true;
}
if (!$ok) die("why?");
error_reporting(0);
$token = ""; //توکن
define('API_KEY', $token);
$admin = ""; //ایدی ادمین
$channel = ""; //چنل جوین اجباری

$json = file_get_contents("php://input");
$update = json_decode ($json, true);
$text       = $update["message"]["text"];
$chat_id    = $update["message"]["chat"]["id"];
$from_id    = $update["message"]["from"]["id"];
$message_id = $update["message"]["message_id"];
$first_name = $update["message"]["from"]["first_name"];
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$truechannel = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$channel&user_id=$from_id"));
$tch = $truechannel->result->status;
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function SendMessage($chat_id, $text){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$text,
        'disable_web_page_preview' => true,
        'parse_mode'=>'MarkDown']);
}

function Forward($berekoja,$azchejaei,$kodompayam) {
    bot('forwardMessage',[
        'chat_id'=>$berekoja,
        'from_chat_id'=>$azchejaei,
        'message_id'=>$kodompayam
    ]);
}

function Ziper($folder_to_zip_path, $destination_zip_file_path){
    $rootPath = realpath($folder_to_zip_path);
    $zip = new ZipArchive();
    $zip->open($destination_zip_file_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $name => $file){
        if(!$file->isDir()){
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }
    $zip->close();
}
if (!is_dir("data")) {
    mkdir("data");
}

if (!file_exists("data/start.txt")) {
    touch("data/start.txt");
}

if (!file_exists("data/support.txt")) {
    touch("data/support.txt");
}

if (!file_exists("data/help.txt")) {
    touch("data/help.txt");
}

if (!file_exists("data/info.txt")) {
    touch("data/info.txt");
}

if (!file_exists("data/mem.txt")) {
    touch("data/mem.txt");
}

if (!file_exists("data/sazande.txt")) {
    touch("data/sazande.txt");
}

elseif($tch != 'member' && $tch != 'creator' && $tch != 'administrator'){
 bot('sendmessage',[
                'chat_id'=>$chat_id,
                'text'=>"🙂با سلام و درود خدمت شما کاربر عزیز 
 $first_name

برای ساخت فونت در ربات ما باید اول عضو کانال ما بشید
$channel
 و سپس به ربات برگشت و دستور 👇
| /start | 
رو ارسال کنید😉",
]);
return false;
}
$main_menu = json_encode(['keyboard' => [
    [['text' => "🧸 ساخت فونت 🧸"]],
    [['text' => "کانال ما | ℂℍ𝔸ℕℕ𝔼𝕃📌"],['text' => "⁉️ راهنما | ʜᴇʟᴘ"]],
    [['text' => "ˢᵘᵖᵒʳᵗ | پشتیبانی 🛎"],['text' => "سازنده"]],
],'resize_keyboard' => true,
]);

$back_button = json_encode(['keyboard' => [
    [['text' => "برگشت | ʙᴀᴄᴋ =>"]],
],'resize_keyboard' => true,
]);

$admin_main = json_encode(['keyboard' => [
    [['text' => "تغییر متن ها"],['text' => "آمار"]],
    [['text' => "فروارد همگانی"],['text' => "ارسال همگانی"]],
    [['text' => "برگشت | ʙᴀᴄᴋ =>"]],
],'resize_keyboard' => true,
]);

$back_to_panel = json_encode(['keyboard' => [
    [['text' => "🔙 بازگشت به پنل 🔙"]],
],'resize_keyboard' => true,
]);

$matn_button = json_encode(['keyboard' => [
    [['text' => "متن استارت"],['text' => "متن پشتیبانی"]],
    [['text' => "متن کانال ما"],['text' => "متن راهنما"]],
    [['text' => "متن سازنده"]],
    [['text' => "🔙 بازگشت به پنل 🔙"]],
],'resize_keyboard' => true,
]);
$step = file_get_contents("data/$from_id/step.txt");
$start_text = file_get_contents("data/start.txt");
$support_text = file_get_contents("data/support.txt");
$help_text = file_get_contents("data/help.txt");
$info_text = file_get_contents("data/info.txt");
$sazande_txt = file_get_contents("data/sazande.txt");
if ($text == "/start") {

    if (!file_exists("data/$from_id/step.txt")) {
        mkdir("data/$from_id");
        file_put_contents("data/$from_id/step.txt", "none");

        $file = fopen("data/mem.txt", "a") or die("Unable to open file!");
        fwrite($file, "$from_id\n");
        fclose($file);
    }

    file_put_contents("data/$from_id/step.txt", "none");

    if ($start_text == null) {
        bot('sendMessage',[
            'chat_id' => $from_id,
            'text' => "متنی برای استارت تنظیم نشده",
            'reply_markup' => $main_menu,
        ]);
    }else{
        bot('sendMessage',[
            'chat_id' => $from_id,
            'text' => "$start_text",
            'reply_markup' => $main_menu,
        ]);
    }
}

elseif ($text == "برگشت | ʙᴀᴄᴋ =>") {

    file_put_contents("data/$from_id/step.txt", "none");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "به منوی اصلی برگشتیم 😙",
        'parse_mode' => "Markdown",
        'reply_markup' => $main_menu
    ]);
}

elseif ($text == "🧸 ساخت فونت 🧸") {

    file_put_contents("data/$from_id/step.txt", "newfont");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "اسم یا هر متنی رو که دوست دارید فونت دار بشه، ارسال کنید 🤍

⚠️ متن شما حتما به انگلیسی ارسال شود!",
        'parse_mode' => "Markdown",
        'reply_markup' => $back_button
    ]);
}

elseif ($text == "⁉️ راهنما | ʜᴇʟᴘ") {

    if ($help_text == null) {
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "تنظیم نشده :/",
            'reply_markup' => $back_button
        ]);
    }else{
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "$help_text",
            'reply_markup' => $back_button
        ]);
    }

}

elseif ($text == "ˢᵘᵖᵒʳᵗ | پشتیبانی 🛎") {

    if ($support_text == null) {
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "تنظیم نشده :/",
            'reply_markup' => $back_button
        ]);
    }else{
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "$support_text",
            'reply_markup' => $back_button
        ]);
    }

}

elseif ($text == "سازنده") {

    if ($sazande_txt == null) {
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "تنظیم نشده :/",
            'reply_markup' => $back_button
        ]);
    }else{
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "$sazande_txt",
            'reply_markup' => $back_button
        ]);
    }

}

elseif ($text == "کانال ما | ℂℍ𝔸ℕℕ𝔼𝕃📌") {

    if ($info_text == null) {
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "تنظیم نشده :/",
            'reply_markup' => $back_button
        ]);
    }else{
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => "$info_text",
            'reply_markup' => $back_button
        ]);
    }

}

elseif ($step == "newfont") {

    file_put_contents("data/$from_id/step.txt", "null");

    $fontt = file_get_contents("http://api.neman.ir/zibanevis?text=$text");
    $get = file_get_contents("http://api.novateamco.ir/font/?text=".urlencode($text));
    $result = json_decode($get, true);
    $font1 = $result['result']['1'];
    $font2 = $result['result']['2'];
    $font3 = $result['result']['3'];
    $font4 = $result['result']['4'];
    $font5 = $result['result']['5'];
    $font6 = $result['result']['6'];
    $font7 = $result['result']['7'];
    $font8 = $result['result']['8'];
    $text2 = str_replace(' ','+',$text);
    $link = json_decode(file_get_contents("http://api.codebazan.ir/font/?text=$text2"),true);
$link2 = $link["result"];
$and1 = $link2['1'];
$and2 = $link2['2'];
$and3 = $link2['3'];
$and4 = $link2['4'];
$and5 = $link2['5'];
$and6 = $link2['6'];
$and7 = $link2['7'];
$and8 = $link2['8'];
$and9 = $link2['9'];
$and10 = $link2['10'];
$and11 = $link2['11'];
$and12 = $link2['12'];
$and13 = $link2['13'];
$and14 = $link2['14'];
$and15 = $link2['15'];
$and16 = $link2['16'];
$and17 = $link2['17'];
$and18 = $link2['18'];
$and19 = $link2['19'];
$and20 = $link2['20'];
$and21 = $link2['21'];
$and22 = $link2['22'];
$and23 = $link2['23'];
$and24 = $link2['24'];
$and25 = $link2['25'];
$and26 = $link2['26'];
$and27 = $link2['27'];
$and28 = $link2['28'];
$and29 = $link2['29'];
$and30 = $link2['30'];
$and31 = $link2['31'];
$and32 = $link2['32'];
$and33 = $link2['33'];
$and34 = $link2['34'];
$and35 = $link2['35'];
$and36 = $link2['36'];
$and37 = $link2['37'];
$and38 = $link2['38'];
$and39 = $link2['39'];
$and40 = $link2['40'];
$and41 = $link2['41'];
$and42 = $link2['42'];
$and43 = $link2['43'];
$and44 = $link2['44'];
$and45 = $link2['45'];
$and46 = $link2['46'];
$and47 = $link2['47'];
$and48 = $link2['48'];
$and49 = $link2['49'];
$and50 = $link2['50'];
$and51 = $link2['51'];
$and52 = $link2['52'];
$and53 = $link2['53'];
$and54 = $link2['54'];
$and55 = $link2['55'];
$and56 = $link2['56'];
$and57 = $link2['57'];
$and58 = $link2['58'];
$and59 = $link2['59'];
$and60 = $link2['60'];
$and61 = $link2['61'];
$and62 = $link2['62'];
$and63 = $link2['63'];
$and64 = $link2['64'];
$and65 = $link2['65'];
$and66 = $link2['66'];
$and67 = $link2['67'];
$and68 = $link2['68'];
$and69 = $link2['69'];
$and70 = $link2['70'];
$and71 = $link2['71'];
$and72 = $link2['72'];
$and73 = $link2['73'];
$and74 = $link2['74'];
$and75 = $link2['75'];
$and76 = $link2['76'];
$and77 = $link2['77'];
$and78 = $link2['78'];
$and79 = $link2['79'];
$and80 = $link2['80'];
$and81 = $link2['81'];
$and82 = $link2['82'];
$and83 = $link2['83'];
$and84 = $link2['84'];
$and85 = $link2['85'];
$and86 = $link2['86'];
$and87 = $link2['87'];
$and88 = $link2['88'];
$and89 = $link2['89'];
$and90 = $link2['90'];
$and91 = $link2['91'];
$and92 = $link2['92'];
$and93 = $link2['93'];
$and94 = $link2['94'];
$and95 = $link2['95'];
$and96 = $link2['96'];
$and97 = $link2['97'];
$and98 = $link2['98'];
$and99 = $link2['99'];
$and100 = $link2['100'];
$and101 = $link2['101'];
$and102 = $link2['102'];
$and103 = $link2['103'];
$and104 = $link2['104'];
$and105 = $link2['105'];
$and106 = $link2['106'];
$and107 = $link2['107'];
$and108 = $link2['108'];
$and109 = $link2['109'];
$and110 = $link2['110'];
$and111 = $link2['111'];
$and112 = $link2['112'];
$and113 = $link2['113'];
$and114 = $link2['114'];
$and115 = $link2['115'];
$and116 = $link2['116'];
$and117 = $link2['117'];
$and118 = $link2['118'];
$and119 = $link2['119'];
$and120 = $link2['120'];
$and121 = $link2['121'];
$and122 = $link2['122'];
$and123 = $link2['123'];
$and124 = $link2['124'];
$and125 = $link2['125'];
$and126 = $link2['126'];
$and127 = $link2['127'];
$and128 = $link2['128'];
$and129 = $link2['129'];
$and130 = $link2['130'];
$and131 = $link2['131'];
$and132 = $link2['132'];
$and133 = $link2['133'];
$and134 = $link2['134'];
$and135 = $link2['135'];
$and136 = $link2['136'];
$and137 = $link2['137'];
$and138 = $link2['138'];
    $matn = strtoupper("$text");
    $Eng = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'];
    $Font_0 = ['𝐐','𝐖','𝐄','𝐑','𝐓','𝐘','𝐔','𝐈','𝐎','𝐏','𝐀','𝐒','𝐃','𝐅','𝐆','𝐇','𝐉','𝐊','𝐋','𝐙','𝐗','𝐂','𝐕','𝐁','𝐍','𝐌'];
    $Font_1 = ['𝑸','𝑾','𝑬','𝑹','𝑻','𝒀','𝑼','𝑰','𝑶','𝑷','𝑨','𝑺','𝑫','𝑭','𝑮','𝑯','𝑱','𝑲','𝑳','𝒁','𝑿','𝑪','𝑽','𝑩','𝑵','𝑴'];
    $Font_2 = ['𝑄','𝑊','𝐸','𝑅','𝑇','𝑌','𝑈','𝐼','𝑂','𝑃','𝐴','𝑆','𝐷','𝐹','𝐺','𝐻','𝐽','𝐾','𝐿','𝑍','𝑋','𝐶','𝑉','𝐵','𝑁','𝑀'];
    $Font_3 = ['𝗤','𝗪','𝗘','𝗥','𝗧','𝗬','𝗨','𝗜','𝗢','𝗣','𝗔','𝗦','𝗗','𝗙','𝗚','𝗛','𝗝','𝗞','𝗟','𝗭','𝗫','𝗖','𝗩','𝗕','𝗡','𝗠'];
    $Font_4 = ['𝖰','𝖶','𝖤','𝖱','𝖳','𝖸','𝖴','𝖨','𝖮','𝖯','𝖠','𝖲','𝖣','𝖥','𝖦','𝖧','𝖩','𝖪','𝖫','𝖹','𝖷','𝖢','𝖵','𝖡','𝖭','𝖬'];
    $Font_5 = ['𝕼','𝖂','𝕰','𝕽','𝕵','𝚼','𝖀','𝕿','𝕺','𝕻','𝕬','𝕾','𝕯','𝕱','𝕲','𝕳','𝕴','𝕶','𝕷','𝖅','𝖃','𝕮','𝖁','𝕭','𝕹','𝕸'];
    $Font_6 = ['𝔔','𝔚','𝔈','ℜ','𝔍','ϒ','𝔘','𝔗','𝔒','𝔓','𝔄','𝔖','𝔇','𝔉','𝔊','ℌ','ℑ','𝔎','𝔏','ℨ','𝔛','ℭ','𝔙','𝔅','𝔑','??'];
    $Font_7 = ['𝙌','𝙒','𝙀','𝙍','𝙏','𝙔','𝙐','𝙄','𝙊','𝙋','𝘼','𝙎','𝘿','𝙁','𝙂','𝙃','𝙅','𝙆','𝙇','𝙕','𝙓','𝘾','𝙑','𝘽','𝙉','𝙈'];
    $Font_8 = ['𝘘','𝘞','𝘌','𝘙','𝘛','𝘠','𝘜','??','𝘖','𝘗','𝘈','𝘚','𝘋','𝘍','𝘎','𝘏','𝘑','𝘒','𝘓','𝘡','𝘟','𝘊','𝘝','𝘉','𝘕','𝘔'];
    $Font_9 = ['Q̶̶','W̶̶','E̶̶','R̶̶','T̶̶','Y̶̶','U̶̶','I̶̶','O̶̶','P̶̶','A̶̶','S̶̶','D̶̶','F̶̶','G̶̶','H̶̶','J̶̶','K̶̶','L̶̶','Z̶̶','X̶̶','C̶̶','V̶̶','B̶̶','N̶̶','M̶̶'];
    $Font_10 = ['Q̷̷̶̶','W̷̷̶̶','E̷̷̶̶','R̷̷̶̶','T̷̷̶̶','Y̷̷̶̶','U̷̷̶̶','I̷̷̶̶','O̷̷̶̶','P̷̷̶̶','A̷̷̶̶','S̷̷̶̶','D̷̷̶̶','F̷̷̶̶','G̷̷̶̶','H̷̷̶̶','J̷̷̶̶','K̷̷̶̶','L̷̷̶̶','Z̷̷̶̶','X̷̷̶̶','C̷̷̶̶','V̷̷̶̶','B̷̷̶̶','N̷̷̶̶','M̷̷̶̶'];
    $Font_11 = ['Q͟͟','W͟͟','E͟͟','R͟͟','T͟͟','Y͟͟','U͟͟','I͟͟','O͟͟','P͟͟','A͟͟','S͟͟','D͟͟','F͟͟','G͟͟','H͟͟','J͟͟','K͟͟','L͟͟','Z͟͟','X͟͟','C͟͟','V͟͟','B͟͟','N͟͟','M͟͟'];
    $Font_12 = ['Q͇͇','W͇͇','E͇͇','R͇͇','T͇͇','Y͇͇','U͇͇','I͇͇','O͇͇','P͇͇','A͇͇','S͇͇','D͇͇','F͇͇','G͇͇','H͇͇','J͇͇','K͇͇','L͇͇','Z͇͇','X͇͇','C͇͇','V͇͇','B͇͇','N͇͇','M͇͇'];
    $Font_13 = ['Q̤̤','W̤̤','E̤̤','R̤̤','T̤̤','Y̤̤','Ṳ̤','I̤̤','O̤̤','P̤̤','A̤̤','S̤̤','D̤̤','F̤̤','G̤̤','H̤̤','J̤̤','K̤̤','L̤̤','Z̤̤','X̤̤','C̤̤','V̤̤','B̤̤','N̤̤','M̤̤'];
    $Font_14 = ['Q̰̰','W̰̰','Ḛ̰','R̰̰','T̰̰','Y̰̰','Ṵ̰','Ḭ̰','O̰̰','P̰̰','A̰̰','S̰̰','D̰̰','F̰̰','G̰̰','H̰̰','J̰̰','K̰̰','L̰̰','Z̰̰','X̰̰','C̰̰','V̰̰','B̰̰','N̰̰','M̰̰'];
    $Font_15 = ['디','山','乇','尺','亇','丫','凵','工','口','ㄗ','闩','丂','刀','下','彑','⼶','亅','片','乚','乙','乂','亡','ム','乃','力','从'];
    $Font_16= ['ዓ','ሠ','ይ','ዩ','ፐ','ሃ','ሀ','ፗ','ዐ','የ','ል','ና','ሏ','ፑ','ፘ','ዘ','ጋ','ኸ','ረ','ጓ','ጰ','ር','ህ','ፎ','በ','ጠ'];
    $Font_17= ['Ꭷ','Ꮃ','Ꭼ','Ꮢ','Ꭲ','Ꭹ','Ꮜ','Ꮖ','Ꮻ','Ꮲ','Ꭺ','Ꮪ','Ꭰ','Ꮀ','Ꮐ','Ꮋ','Ꭻ','Ꮶ','Ꮮ','Ꮓ','Ꮱ','Ꮯ','Ꮩ','Ᏼ','N','Ꮇ'];
    $Font_18= ['Ǫ','Ѡ','Σ','Ʀ','Ϯ','Ƴ','Ʋ','Ϊ','Ѳ','Ƥ','Ѧ','Ƽ','Δ','Ӻ','Ǥ','ⴼ','Ɉ','Ҟ','Ɫ','Ⱬ','Ӽ','Ҁ','Ѵ','Ɓ','Ɲ','ᛖ'];
    $Font_19= ['ꐎ','ꅐ','ꂅ','ꉸ','ꉢ','ꌦ','ꏵ','ꀤ','ꏿ','ꉣ','ꁲ','ꌗ','ꅓ','ꊰ','ꁅ','ꍬ','ꀭ','ꂪ','꒒','ꏣ','ꉧ','ꊐ','ꏝ','ꃃ','ꊮ','ꂵ'];
    $Font_20= ['ᘯ','ᗯ','ᕮ','ᖇ','ᙢ','ᖻ','ᑌ','ᖗ','ᗝ','ᑭ','ᗩ','ᔕ','ᗪ','ᖴ','ᘜ','ᕼ','ᒍ','ᖉ','ᒐ','ᘔ','᙭','ᑕ','ᕓ','ᗷ','ᘉ','ᗰ'];
    $Font_21= ['ᑫ','ᗯ','ᗴ','ᖇ','Ꭲ','Ꭹ','ᑌ','Ꮖ','ᝪ','ᑭ','ᗩ','ᔑ','ᗞ','ᖴ','Ꮐ','ᕼ','ᒍ','Ꮶ','Ꮮ','Ꮓ','᙭','ᑕ','ᐯ','ᗷ','ᑎ','ᗰ'];
    $Font_22= ['ℚ','Ꮤ','℮','ℜ','Ƭ','Ꮍ','Ʋ','Ꮠ','Ꮎ','⅌','Ꭿ','Ꮥ','ⅅ','ℱ','Ꮹ','ℋ','ℐ','Ӄ','ℒ','ℤ','ℵ','ℭ','Ꮙ','Ᏸ','ℕ','ℳ'];
    $Font_23= ['Ԛ','ᚠ','ᛊ','ᚱ','ᛠ','ᚴ','ᛘ','ᛨ','θ','ᚹ','ᚣ','ᛢ','ᚦ','ᚫ','ᛩ','ᚻ','ᛇ','ᛕ','ᚳ','Z','ᚷ','ᛈ','ᛉ','ᛒ','ᚺ','ᚥ'];
    $Font_24= ['𝓠','𝓦','𝓔','𝓡','𝓣','𝓨','𝓤','𝓘','𝓞','𝓟','𝓐','𝓢','𝓓','𝓕','𝓖','𝓗','𝓙','𝓚','𝓛','𝓩','𝓧','𝓒','𝓥','𝓑','𝓝','𝓜'];
    $Font_25= ['𝒬','𝒲','ℰ','ℛ','𝒯','𝒴','𝒰','ℐ','𝒪','𝒫','𝒜','𝒮','𝒟','ℱ','𝒢','ℋ','𝒥','𝒦','ℒ','??','𝒳','𝒞','𝒱','ℬ','𝒩','ℳ'];
    $Font_26= ['ℚ','𝕎','𝔼','ℝ','𝕋','𝕐','𝕌','𝕀','𝕆','ℙ','𝔸','𝕊','𝔻','𝔽','𝔾','ℍ','𝕁','𝕂','𝕃','ℤ','𝕏','ℂ','𝕍','𝔹','ℕ','𝕄'];
    $Font_27= ['Ｑ','Ｗ','Ｅ','Ｒ','Ｔ','Ｙ','Ｕ','Ｉ','Ｏ','Ｐ','Ａ','Ｓ','Ｄ','Ｆ','Ｇ','Ｈ','Ｊ','Ｋ','Ｌ','Ｚ','Ｘ','Ｃ','Ｖ','Ｂ','Ｎ','Ｍ'];
    $Font_28= ['ǫ','ᴡ','ᴇ','ʀ','ᴛ','ʏ','ᴜ','ɪ','ᴏ','ᴘ','ᴀ','s','ᴅ','ғ','ɢ','ʜ','ᴊ','ᴋ','ʟ','ᴢ','x','ᴄ','ᴠ','ʙ','ɴ','ᴍ'];
    $Font_29= ['𝚀','𝚆','𝙴','𝚁','𝚃','𝚈','𝚄','𝙸','𝙾','??','𝙰','??','𝙳','𝙵','𝙶','𝙷','𝙹','𝙺','𝙻','??','𝚇','𝙲','𝚅','𝙱','𝙽','𝙼'];
    $Font_30= ['ᵟ','ᵂ','ᴱ','ᴿ','ᵀ','ᵞ','ᵁ','ᴵ','ᴼ','ᴾ','ᴬ','ˢ','ᴰ','ᶠ','ᴳ','ᴴ','ᴶ','ᴷ','ᴸ','ᶻ','ˣ','ᶜ','ⱽ','ᴮ','ᴺ','ᴹ'];
    $Font_31= ['Ⓠ','Ⓦ','Ⓔ','Ⓡ','Ⓣ','Ⓨ','Ⓤ','Ⓘ','Ⓞ','Ⓟ','Ⓐ','Ⓢ','Ⓓ','Ⓕ','Ⓖ','Ⓗ','Ⓙ','Ⓚ','Ⓛ','Ⓩ','Ⓧ','Ⓒ','Ⓥ','Ⓑ','Ⓝ','Ⓜ'];
    $Font_32= ['🅀','🅆','🄴','🅁','🅃','🅈','🅄','🄸','🄾','🄿','🄰','🅂','🄳','🄵','🄶','🄷','🄹','🄺','🄻','🅉','🅇','🄲','🅅','🄱','🄽','🄼'];
    $Font_33= ['🅠','🅦','🅔','🅡','🅣','🅨','🅤','🅘','🅞','🅟','🅐','🅢','🅓','🅕','🅖','🅗','🅙','🅚','🅛','🅩​','🅧','🅒','🅥','🅑','🅝','🅜'];
    $Font_34= ['🆀','??','🅴','🆁','🆃','🆈','🆄','🅸','🅾','🅿','🅰','🆂','🅳','🅵','🅶','🅷','🅹','🅺','🅻','🆉','🆇','🅲','🆅','🅱','🅽','🅼'];
    $Font_36 = ['Ø','w','E','Ґ','τ','y','υ','Ї','Θ','Ƿ','Æ','Š','Ð','F','ζ','Ħ','¿','ズ','ᄂ','շ','χ','©','¥','þ','Ñ','M'];
    $Font_37 = ['Q','W','£','®','T','¥','µ','Ï','Ø','þ','Æ','§','Ð','F','G','H','J','K','|','Z','X','©','V','ß','Ñ','M'];
    $Font_38 = ['p','w','ɘ','я','т','γ','υ','i','o','q','ɒ','ƨ','b','ʇ','ϱ','н','į','ʞ','l','z','x','ɔ','v','d','и','м'];
    $Font_39 = ['Ҩ','Щ','Є','R','ƚ','￥','Ц','Ī','Ø','P','Â','$','Ð','Ŧ','Ǥ','Ħ','ʖ','Қ','Ŀ','Ẕ','X','Ĉ','V','ß','И','♏'];
    $Font_40 = ['๑','ຟ','ē','r','t','ฯ','น','i','໐','p','ค','Ş','໓','f','ງ','h','ว','k','l','ຊ','x','¢','ง','๖','ຖ','๓'];
    $Font_41 = ['Ⴓ','Ш','Σ','Γ','Ƭ','Ψ','Ʊ','I','Θ','Ƥ','Δ','Ѕ','D','F','G','H','J','Ƙ','L','Z','Ж','C','Ʋ','Ɓ','∏','Μ'];
    $Font_42 = ['ợ','ฬ','є','г','t','ץ','ย','เ','๏','թ','ค','ร','๔','Ŧ','ɠ','ђ','ן','к','l','z','x','ς','v','๒','ภ','๓'];
    $Font_44 = ['Ҩ','Ѡ','Ɛ','Ŕ','Ƭ','Y','Ʊ','Ī','♡','Ṗ','Λ','S','D','F','Ɠ','Ĥ','Ĵ','Ҡ','Ŀ','Z','Ӿ','Ƈ','Ѵ','ß','И','M'];
    $Font_45 = ['Ҩ','Щ','Є','Г','Ҭ','ү','Ա','і','Ѻ','թ','Ѧ','Տ','Ԁ','Ғ','Ԍ','Ӊ','ј','Ҡ','L','Հ','Ӽ','С','Ѷ','ѣ','И','Ӎ'];
    $Font_46 = ['𝓠','𝓦','𝓔','𝓡','𝓣','𝓨','𝓤','??','𝓞','𝓟','𝓐','??','𝓓','𝓕','𝓖','𝓗','𝓙','𝓚','𝓛','𝓩','𝓧','𝓒','𝓥','𝓑','𝓝','𝓜'];
    $Font_47 = ['Q','Щ','乇','尺','ｲ','ﾘ','Ц','ﾉ','Ծ','ｱ','ﾑ','ㄎ','Ð','ｷ','Ǥ','ん','ﾌ','ズ','ﾚ','乙','ﾒ','ζ','Џ','乃','刀','ᄊ'];
    $Font_48 = ['Ø','w','E','Ґ','τ','y','υ','Ї','Θ','Ƿ','Æ','Š','Ð','F','ζ','Ħ','¿','ズ','ᄂ','շ','χ','©','¥','þ','Ñ','M'];
    $Font_49 = ['b','ʍ','ǝ','ɹ','ʇ','ʎ','n','ı','o','d','ɐ','s','p','ɟ','ɓ','ɥ','ſ','ʞ','ๅ','z','x','ɔ','ʌ','q','u','ɯ'];

    $nn = str_replace($Eng,$Font_0,$matn);
    $a = str_replace($Eng,$Font_1,$matn);
    $b = str_replace($Eng,$Font_2,$matn);
    $c = trim(str_replace($Eng,$Font_3,$matn));
    $d = str_replace($Eng,$Font_4,$matn);
    $e = str_replace($Eng,$Font_5,$matn);
    $f = str_replace($Eng,$Font_6,$matn);
    $g = str_replace($Eng,$Font_7,$matn);
    $h = str_replace($Eng,$Font_8,$matn);
    $i = str_replace($Eng,$Font_9,$matn);
    $j = str_replace($Eng,$Font_10,$matn);
    $k = str_replace($Eng,$Font_11,$matn);
    $l = str_replace($Eng,$Font_12,$matn);
    $m = str_replace($Eng,$Font_13,$matn);
    $n = str_replace($Eng,$Font_14,$matn);
    $o = str_replace($Eng,$Font_15,$matn);
    $p= str_replace($Eng,$Font_16,$matn);
    $q= str_replace($Eng,$Font_17,$matn);
    $r= str_replace($Eng,$Font_18,$matn);
    $s= str_replace($Eng,$Font_19,$matn);
    $t= str_replace($Eng,$Font_20,$matn);
    $u= str_replace($Eng,$Font_21,$matn);
    $v= str_replace($Eng,$Font_22,$matn);
    $w= str_replace($Eng,$Font_23,$matn);
    $x= str_replace($Eng,$Font_24,$matn);
    $y= str_replace($Eng,$Font_25,$matn);
    $z= str_replace($Eng,$Font_26,$matn);
    $aa= str_replace($Eng,$Font_27,$matn);
    $ac= str_replace($Eng,$Font_28,$matn);
    $ad= str_replace($Eng,$Font_29,$matn);
    $af= str_replace($Eng,$Font_30,$matn);
    $ag= str_replace($Eng,$Font_31,$matn);
    $ah= str_replace($Eng,$Font_32,$matn);
    $am= str_replace($Eng,$Font_33,$matn);
    $as= str_replace($Eng,$Font_34,$matn);
    $a2= str_replace($Eng,$Font_36,$matn);
    $a3= str_replace($Eng,$Font_37,$matn);
    $a4= str_replace($Eng,$Font_38,$matn);
    $a5= str_replace($Eng,$Font_39,$matn);
    $a6= str_replace($Eng,$Font_40,$matn);
    $a7= str_replace($Eng,$Font_41,$matn);
    $a8= str_replace($Eng,$Font_42,$matn);
    $a9= str_replace($Eng,$Font_44,$matn);
    $a10= str_replace($Eng,$Font_45,$matn);
    $a11= str_replace($Eng,$Font_46,$matn);
    $a12= str_replace($Eng,$Font_47,$matn);
    $a13= str_replace($Eng,$Font_48,$matn);
    $a14= str_replace($Eng,$Font_49,$matn);
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"🥳 فونت شما ایجاد شد :)
        
$font1
$font3
$font4
$font5
$font6
$font7
$font8

جهت مشاهده بیشتر فونت های متن شما، به فایل زیر مراجعه کنید! 👇
",
    ]);

    file_put_contents("data/$from_id/fonts.txt", "ادامه لیست فونت ها :
    
$font1
$font3
$font4
$font5
$font6
$font7
$font8
$nn
$a
$b
$c
$d
$e
$f
$g
$h
$i
$j
$k
$l
$m
$n
$o
$p
$q
$r
$s
$t
$u
$v
$w
$x
$y
$z
$aa
$ac
$ad
$af
$ag
$ah
$am
$as
$a2
$a3
$a4
$a5
$a6
$a7
$a8
$a9
$a10
$a11
$a12
$a13
$a14
$and1
$and2
$and3
$and4
$and5
$and6
$and7
$and8
$and9
$and10
$and11
$and12
$and13
$and14
$and15
$and16
$and17
$and18
$and19
$and20
$and21
$and22
$and23
$and24
$and25
$and26
$and27
$and28
$and29
$and30
$and31
$and32
$and33
$and34
$and35
$and36
$and37
$and38
$and39
$and40
$and41
$and42
$and43
$and44
$and45
$and46
$and47
$and48
$and49
$and50
$and51
$and52
$and53
$and54
$and55
$and56
$and57
$and58
$and59
$and60
$and61
$and62
$and63
$and64
$and65
$and66
$and67
$and68
$and69
$and70
$and71
$and72
$and73
$and74
$and75
$and76
$and77
$and78
$and79
$and80
$and81
$and82
$and83
$and84
$and85
$and86
$and87
$and88
$and89
$and90
$and91
$and92
$and93
$and94
$and95
$and96
$and97
$and98
$and99
$and100
$and101
$and102
$and103
$and104
$and105
$and106
$and107
$and108
$and109
$and110
$and111
$and112
$and113
$and114
$and115
$and116
$and117
$and118
$and119
$and120
$and121
$and122
$and123
$and124
$and125
$and126
$and127
$and128
$and129
$and130
$and131
$and132
$and133
$and134
$and135
$and136
$and137
$and138");

    $file = new CURLFile("data/$from_id/fonts.txt");

    bot('SendDocument',[
        'chat_id' => $from_id,
        'document' => $file,
        'caption' => "دیگر فونت های متن شما، در این فایل قابل مشاهده می‌باشد 🙃",
    ]);

    unlink("data/$from_id/fonts.txt");

    sleep('1');

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "به منوی اصلی برگشتیم 😙",
        'parse_mode' => "Markdown",
        'reply_markup' => $main_menu
    ]);


}
if ($text == "/panel" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "به پنل مدیریت خوش آمدید",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "🔙 بازگشت به پنل 🔙" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "برگشتیم به پنل",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "آمار" and $from_id == $admin) {

    $user = file_get_contents("data/mem.txt");
    $user_id = explode("\n", $user);
    $user_count = count($user_id) -1;

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "تعداد کاربران ربات تا این لحظه : $user_count",
        'parse_mode' => "Markdown",
        'reply_markup' => $back_to_panel,
    ]);

}


elseif ($text == "ارسال همگانی" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "send2all");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "پیامتون رو در قالب متن بفرستید تا اون رو برای تمام ممبر ها ارسال کنم !",
        'parse_mpde' => "Markdown",
        'reply_markup' => $back_to_panel,
    ]);

}

elseif ($step == "send2all" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "ربات درحال ارسال پیام شما به تمام اعضا میباشد
بعد از ارسال پیام همگانی ، اتمام کار رو بهت اعلام میکنم :)

لطفا تا پایان عملیات دستوری ارسال نکنید !"
    ]);

    $all_member = fopen( "data/mem.txt", "r");
    while( !feof( $all_member)) {
    $user = fgets( $all_member);

    bot('sendMessage',[
        'chat_id' => $user,
        'text' => $text,
        'parse_mode' => "Markdown"
    ]);
    }

    sleep('3');

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "عملیات ارسال پیام همگانی با موفقیت به پایان رسید ✅

پیام شما به تمامی اعضای ربات ارسال شد 🎈"
    ]);

}

elseif ($text == "فروارد همگانی" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "for2all");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "پیامتون رو در قالب دلخواه برای من فروارد کنید تا اون رو برای تمام ممبر ها فروارد کنم !",
        'parse_mpde' => "Markdown",
        'reply_markup' => $back_to_panel,
    ]);

}

elseif ($step == "for2all" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "ربات درحال فروراد پیام شما به تمام اعضا میباشد
بعد از ارسال فروارد همگانی ، اتمام کار رو بهت اعلام میکنم :)

لطفا تا پایان عملیات دستوری ارسال نکنید !"
    ]);

    $forp = fopen( "data/mem.txt", 'r');
    while( !feof( $forp)) {
        $users = fgets($forp);
        Forward($users, $chat_id, $message_id);
    }

    sleep('3');

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "عملیات ارسال فروراد همگانی با موفقیت به پایان رسید ✅

پیام شما به تمامی اعضای ربات فروراد شد 🎈"
    ]);

}

elseif ($text == "تغییر متن ها" and $from_id == $admin) {

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "قصد تغییر متن کدام دکمه را دارید . . . ؟",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($text == "متن استارت" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "setstart");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "بسیار خب ، متنی که میخواهید پس از استارت نمایش داده شود را برای من ارسال کنید :)",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($step == "setstart" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");
    file_put_contents("data/start.txt", "$text");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "متن شما تنظیم شد !
🙃",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "متن پشتیبانی" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "setsupport");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "بسیار خب ، متنی که میخواهید برای پشتیبانی نمایش داده شود را برای من ارسال کنید :)",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($step == "setsupport" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");
    file_put_contents("data/support.txt", "$text");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "متن شما تنظیم شد !
🙃",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "متن سازنده" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "setsazande");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "بسیار خب ، متنی که میخواهید برای سازنده نمایش داده شود را برای من ارسال کنید :)",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($step == "setsazande" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");
    file_put_contents("data/sazande.txt", "$text");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "متن شما تنظیم شد !
🙃",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "متن کانال ما" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "setinfo");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "بسیار خب ، متنی که میخواهید برای قسمت کانال ما نمایش داده شود را برای من ارسال کنید :)",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($step == "setinfo" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");
    file_put_contents("data/info.txt", "$text");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "متن شما تنظیم شد !
🙃",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

elseif ($text == "متن راهنما" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "sethelp");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "بسیار خب ، متنی که میخواهید برای قسمت راهنما نمایش داده شود را برای من ارسال کنید :)",
        'parse_mode' => "Markdown",
        'reply_markup' => $matn_button,
    ]);

}

elseif ($step == "sethelp" and $from_id == $admin) {

    file_put_contents("data/$from_id/step.txt", "none");
    file_put_contents("data/help.txt", "$text");

    bot('sendMessage',[
        'chat_id' => $from_id,
        'text' => "متن شما تنظیم شد !
🙃",
        'parse_mode' => "Markdown",
        'reply_markup' => $admin_main,
    ]);

}

unlink('error_log');
?>