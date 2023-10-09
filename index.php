<?php
ob_start();
error_reporting(0);
define('API_KEY','توکن'); //توکن شما
$admin = 267785153; // ایدی عددی تون
//======================فانکشن ها===============//
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RTURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    if (mysqli_num_rows($result) == 1) {
    $_SESSION['username'] = $username;
     header('location: dashboard.php');
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}function EditMsg($chatid, $msgid, $text, $keyboard = null){
    bot('EditMessageText', [
    'chat_id'=>$chatid,
    'message_id'=>$msgid,
    'text'=>$text,
    'reply_markup'=>$keyboard
    ]);
}
function Forward($chat_id,$from_id,$massege_id){
    bot('ForwardMessage',[
    'chat_id'=>$chat_id,
    'from_chat_id'=>$from_id,
    'message_id'=>$massege_i
    ]);
}
function SendMessage($chat_id, $text, $mode = "html", $reply = null, $keyboard = null){
  bot('SendMessage',[
  'chat_id'=>$chat_id,
  'text'=>$text,
  'parse_mode'=>$mode,
  'reply_to_message_id'=>$reply,
  'reply_markup'=>$keyboard
  ]);
}function objectToArrays($object){
    if (!is_object($object) && !is_array($object)) {
        return $object;
    }
    if (is_object($object)) {
    $object = get_object_vars($object);
    }
    return array_map("objectToArrays", $object);
}
function ping($domain){ $starttime = microtime(true); $file = fsockopen ($domain, 80, $errno, $errstr, 10); $stoptime = microtime(true); $status = 0; if (!$file) $status = -1;
 else { fclose($file); $status = ($stoptime - $starttime) * 1000; $status = floor($status); } return $status; }
 function LeaveChat($chat_id){
        bot('LeaveChat',[
        'chat_id'=>$chat_id
     ]);
}

//===================متقیر ها=============//
$update = json_decode(file_get_contents('php://input'));
$message = $update->message; 
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $update->message->message_id;
$from_id = $message->from->id;
$name = $message->from->first_name;
$lastname = $message->from->last_name;
$username = $message->from->username;
$type = $message->chat->type;
$users = json_decode(file_get_contents("data/data.json"),true);
$step = $users['step'];
$All = $users['userlist'];
$gp = $users['userlist']['gp'];
$pv = $users['userlist']['pv'];
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
$mid = $update->message->reply_to_message->message_id;
$rep = $update->message->reply_to_message;
$newchatmemberid = $update->message->new_chat_member->id;
//=============راهنمای بات==========//
if($text=="راهنما"or $text=="help"&&$from_id==$admin){
sendmessage($chat_id, "📄 Help Tapchi Bot

💡 Notify the bot Online
-آنلاینی

🚀 Notify the bot ping
-پینگ

📊 Notify the bot statistics
-آمار

✏️ Send Pv
-ارسال پیوی

📚 For Pv
-فروارد پیوی

🔸 For gap
-فروارد گروه

🔹 Send Gap
-ارسال گروه

 🔚 Left Bot The Gap
-خروج

🌹 Tabchi Bot Hami Team ve 1.1🌹

📢 @Source_Home","html",$message_id);
}
//=============پینگ============//
if($text=="پینگ" && $from_id==$admin){
$ping=ping($_SERVER['HTTP_HOST']);
$load=sys_getloadavg()[0];
sendmessage($chat_id, "🌙Ping information Tabchi🌙","html",$message_id,json_encode(['inline_keyboard' => [
[['text' => "☘️پینگ☘️ $ping ", 'callback_data' => "none"]],
[['text' => " ☘️لود☘️ $load", 'callback_data' => "none"]],
]]));}
//=======انلاینی=====//
elseif ($text == 'آنلاینی' && $from_id==$admin) {
sendmessage($chat_id,"🎋Im Online Sir🎋","html",$message_id);
}
//======لفت=====//
if($text=="خروج" && $from_id==$admin){
sendmessage($chat_id,"Ok sir bye ✋");
LeaveChat($chat_id);}
//=============سازنده============//
elseif ($text == 'سازنده') {
sendmessage($chat_id,"@Source_Home","html",$message_id);
    }

//=============آمار============//
elseif($text == 'آمار' and $from_id == $admin){
  $ppv = count($users['userlist']['pv']);
  $ggp = count($users['userlist']['gp']);
    <?php
$token = 'YOUR_BOT_TOKEN';
$chat_id = 'TARGET_CHAT_ID';
$message = 'Choose an option:';

$keyboard = array(
    'inline_keyboard' => array(
        array(
            array('text' => 'Option 1', 'callback_data' => 'option1'),
            array('text' => 'Option 2', 'callback_data' => 'option2')
        )
    )
);

$url = "https://api.telegram.org/bot$token/sendMessage";
$data = array(
    'chat_id' => $chat_id,
    'text' => $message,
    'reply_markup' => json_encode($keyboard)
);

file_get_contents($url . '?' . http_build_query($data));
?>

SendMessage($chat_id,"💫Statistics Tapchi Bot💫

⛈Gap: $ggp
🌨Pv: $ppv 

📢 @Source_Home ", 'MarkDown', $message_id);
}
//=======ارسال کاربران=======//
if($text=="ارسال پیوی" && $update->message->reply_to_message->text != null && $from_id == $admin){
$data=json_decode(file_get_contents("data/data.json"),true);
foreach($data['userlist']['pv'] as $user){
bot('sendmessage',['chat_id'=>$user,'text'=>$update->message->reply_to_message->text]);
}
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"🌙Successfully sent🌙"]);
}
//======فروارد به پیوی =====//
if($text=="فروارد پیوی" && $update->message->reply_to_message != null && $from_id == $admin){
$data=json_decode(file_get_contents("data/data.json"),true);
foreach($data['userlist']['pv'] as $user){
bot('ForwardMessage',[
'chat_id'=>$user,
'from_chat_id'=>$chat_id,
'message_id'=>$update->message->reply_to_message->message_id
]);
}
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"🍁For successfully🍁"]);
}

//========فور واردگپ=======//
if($text=="فروارد گروه" && $update->message->reply_to_message != null && $from_id == $admin){
$data=json_decode(file_get_contents("data/data.json"),true);
foreach($data['userlist']['gp'] as $user){
bot('ForwardMessage',[
'chat_id'=>$user,
'from_chat_id'=>$chat_id,
'message_id'=>$update->message->reply_to_message->message_id
]);
}
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ Successfully For ✅"]);
}
//===========ارسال گپ========//
if($text=="ارسال گروه" && $update->message->reply_to_message->text != null && $from_id == $admin){
$data=json_decode(file_get_contents("data/data.json"),true);
foreach($data['userlist']['gp'] as $user){
bot('sendmessage',['chat_id'=>$user,'text'=>$update->message->reply_to_message->text]);
}
bot('sendmessage',['chat_id'=>$chat_id,'text'=>"✅ Successfully sent ✅"]);
}
//=============افزودن آیدی عددی ها============//
if($type == "private"&&!in_array($chat_id,$pv)){
    $users['userlist']['pv'][] = "$chat_id";
    file_put_contents("data/data.json",json_encode($users));
}
if($type !== "private"&&!in_array($chat_id,$gp)){
$users['userlist']['gp'][] = "$chat_id";
file_put_contents("data/data.json",json_encode($users));
}
?>
