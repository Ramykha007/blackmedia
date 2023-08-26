    <?php
    /*
    جميع الحقوق محفوظة ل رامي خالد ومحاولة التعديل هيؤدي لتوقف البوت
    */
    ob_start();
    $token = '6568474124:AAE-0Vu9EU73WUwlB1ChUqO2QXViG_7BTuQ';
    define('API_KEY',$token);//add_token
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
    $update = json_decode(file_get_contents('php://input'));
    $message = $update->message;
    $id = $message->from->id;
    $chat_id = $message->chat->id;
    $text = $message->text;
    $user = $message->from->username;
    if(isset($update->callback_query)){
      $chat_id = $update->callback_query->message->chat->id;
      $message_id = $update->callback_query->message->message_id;
      $data     = $update->callback_query->data;
    $user = $update->callback_query->from->username;
    $sales = json_decode(file_get_contents('sales.txt'),true);
    $buttons = json_decode(file_get_contents('button.json'),true);
    }
    function save($array){
        file_put_contents('sales.txt', json_encode($array));
    }
    $admin = 984241750;
    $ban1 = 1230472469;
    $me = bot('getme',['bot'])->result->username;
    $sales = json_decode(file_get_contents('sales.txt'),1);
    
    if($data == "pointsfile"){
    $user = (file_get_contents("sales.txt"));
    file_put_contents("backup.txt",$user);
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    ▪ تم عمل نسخة احتياطية بنجاح",
    ]);
    }
    if($data == 'c'){
      bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"- - - - - - - - - - - - - - - - - - - - - - - - -
    - مرحباً مطوري @$user
    
    شبيك لبيك بوت تفاصيل بين يديك... فقط أرسل طلبك وستتم تلبيته فورا...😎
    
    - - - - - - - - - - - - - - - - - - - - - - - - -
    بعض الأوامر اللازمة...👇
    
    - - - - - - - - - - - - - - - - - - - - - - - - -",
       'reply_markup'=>json_encode([
         'inline_keyboard'=>[
           [['text'=>'* حذف عرض','callback_data'=>'del'],['text'=>'* اضافة عرض','callback_data'=>'add']],[['text'=>'ارسال نقاط مجانا ','callback_data'=>'sendcoin']],
           [['text'=>'* ارسال رسالة لمستخدم','callback_data'=>'sendmessageuser'],['text'=>'* ارسال تحذير','callback_data'=>'sendwarning']],           
            [['text'=>'عدد المشتركين 👥 ','callback_data'=>'users'],['text'=>'رسالة للكل 📩 ','callback_data'=>'set']],
        [['text'=>'حذف نقاط - ','callback_data'=>'takecoin'],['text'=>'حالة البوت 🔋 ','callback_data'=>'stats']]
          ]
        ])
      ]);
    $sales['mode'] = null;
      save($sales);
    }
    
    if($chat_id == $admin){
    if($text == '/start'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
       'text'=>"- - - - - - - - - - - - - - - - - - - - - - - - -
    - مرحباً مطوري @$user
    
    شبيك لبيك بوت تفاصيل بين يديك... فقط أرسل طلبك وستتم تلبيته فورا...😎
    
    بعض الأوامر اللازمة...👇
    
    
    - - - - - - - - - - - - - - - - - - - - - - - - -",
       'reply_markup'=>json_encode([
         'inline_keyboard'=>[
            [['text'=>'* حذف عرض','callback_data'=>'del'],['text'=>'* اضافة عرض','callback_data'=>'add']],[['text'=>'ارسال نقاط مجانا ','callback_data'=>'sendcoin']],
           [['text'=>'* ارسال رسالة لمستخدم','callback_data'=>'sendmessageuser'],['text'=>'* ارسال تحذير','callback_data'=>'sendwarning']],           
            [['text'=>'عدد المشتركين 👥 ','callback_data'=>'users'],['text'=>'رسالة للكل 📩 ','callback_data'=>'set']],
       [['text'=>'حذف نقاط - ','callback_data'=>'takecoin'],['text'=>'حالة البوت 🔋 ','callback_data'=>'stats']]
          ]
        ])
      ]);
    $sales['mode'] = null;
      save($sales);
    }
    
    if($data == 'sendcoin'){
      bot('sendmessage',[
       'chat_id'=>$chat_id,
       'text'=>"
    أرسل أيدي الشخص الذي تريد إرسال النقاط له
    ",
    ]);
       $sales['mode'] = 'chat';
      save($sales);
      exit;
    }
       if($text != '/start' and $text != null and $sales['mode'] == 'chat'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=> "أرسل الكمية التي تريد إرسالها",
    ]);
       $sales['mode'] = 'poi';
       $sales['idd'] = $text;
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'poi'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=>"تم إضافة $text نقطة إلى حساب ".$sales['idd']." بنجاح ",
    ]);
      bot('sendmessage',[
       'chat_id'=>$sales['idd'],
      'text'=>"تمت إضافة $text نقطة إلى حسابك في البوت من قبل المطور ",
      ]);
      $sales['mode'] = null;
      $sales[$sales['idd']]['collect'] += $text;
      $sales['idd'] = null;
      save($sales);
      exit;
    }
    if($data == 'takecoin'){
      bot('sendmessage',[
       'chat_id'=>$chat_id,
       'text'=>"
    أرسل أيدي الشخص الذي تريد خصم النقاط منه
    ",
    'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>' الغاء 🚫. ','callback_data'=>'c']]   
                ]
            ])
    ]);
      $sales['mode'] = 'chat1';
      save($sales);
      exit;
      }
       if($text != '/start' and $text != null and $sales['mode'] == 'chat1'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=> "أرسل الكمية التي تريد خصمها",
    ]);
       $sales['mode'] = 'poi1';
       $sales['idd'] = $text;
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'poi1'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=>"تم خصم $text نقطة من حساب ".$sales['idd']." بنجاح ",
    ]);
      bot('sendmessage',[
       'chat_id'=>$sales['idd'],
      'text'=>"تمت خصم $text نقطة من حسابك في البوت من قبل المطور ",
      ]);
      $sales['mode'] = null;
      $sales[$sales['idd']]['collect'] -= $text;
      $sales['idd'] = null;
      save($sales);
      exit;
    }
    if($text == "/sendnumber"){
      bot('sendmessage',[
       'chat_id'=>$chat_id,
       'text'=>"
    أرسل أيدي الشخص الذي تريد تسليم الرقم له
    ",
    ]);
      $sales['mode'] = 'chat2';
      save($sales);
      exit;
      }
       if($text != '/start' and $text != null and $sales['mode'] == 'chat2'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=> "
    أرسل الرقم مع الكود",
    ]);
       $sales['mode'] = 'poi2';
       $sales['idd'] = $text;
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'poi2'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرقم إلى ".$sales['idd']." بنجاح ",
    ]);
      bot('sendmessage',[
       'chat_id'=>$sales['idd'],
      'text'=>"إيصال طلب...✅
    
    رقم الكارت هو : $text
    
    شكرا لاستخدامك هذه الخدمة ومبروك ♥
    ",
      ]);
      $sales['mode'] = null;
      $sales['idd'] = null;
      save($sales);
      exit;
    }
    if($data == 'sendmessageuser'){
      bot('sendmessage',[
       'chat_id'=>$chat_id,
       'text'=>"
    أرسل أيدي الشخص الذي تريد إرسال الرسالة له
    ",
    'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>' الغاء 🚫. ','callback_data'=>'c']]   
                ]
            ])
    ]);
      $sales['mode'] = 'chat3';
      save($sales);
      exit;
      }
       if($text != '/start' and $text != null and $sales['mode'] == 'chat3'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=> "
    أرسل رسالتك",
    ]);
       $sales['mode'] = 'poi3';
       $sales['idd'] = $text;
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'poi3'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة إلى ".$sales['idd']." بنجاح ",
    ]);
      bot('sendmessage',[
       'chat_id'=>$sales['idd'],
      'text'=>"رسالة من الإدارة:
    
    $text",
      ]);
      $sales['mode'] = null;
      $sales['idd'] = null;
      save($sales);
      exit;
    }
    if($data == 'sendwarning'){
      bot('sendmessage',[
       'chat_id'=>$chat_id,
       'text'=>"
    أرسل أيدي الشخص الذي تريد إرسال التحذير له
    ",
    'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>' الغاء 🚫. ','callback_data'=>'c']]   
                ]
            ])
    ]);
    
      $sales['mode'] = 'chat4';
      save($sales);
      exit;
      }
       if($text != '/start' and $text != null and $sales['mode'] == 'chat4'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=> "
    إضغط /Confirm لتأكيد إرسال التحذير",
    ]);
       $sales['mode'] = 'poi4';
       $sales['idd'] = $text;
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'poi4'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
    'text'=>"تم إرسال التحذير إلى ".$sales['idd']." بنجاح ",
    ]);
      bot('sendmessage',[
       'chat_id'=>$sales['idd'],
      'text'=>"تحذير من الإدارة!
    إستعمال حسابات وهمية الدخول لرابطك بها يؤدي إلى حظر حسابك 👉
    في حال إستعمال الوهمي سينحظر حسابك... إنتبه... شكرا على تفهمك للموضوع",
      ]);
      $sales['mode'] = null;
      $sales['idd'] = null;
      save($sales);
      exit;
    }
    
    if($data == 'add'){
      bot('editMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>'أرسل إسم السلعة؟!
    مثال:
    10l.E',
        'reply_markup'=>json_encode([
         'inline_keyboard'=>[
          [['text'=>'- إلغاء الأمر 🚫','callback_data'=>'c']]
          ]
        ])
      ]);
      $sales['mode'] = 'add';
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'add'){
      bot('sendMessage',[
       'chat_id'=>$chat_id,
       'text'=>'- تم حفظ إسم السلعة (الرقم)
    أرسل الآن سعرها ( كم نقطة؟ )
    مثال:
    25'
      ]);
      $sales['n'] = $text;
      $sales['mode'] = 'addm';
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'addm'){
      $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz12345689807'),1,7);
      bot('sendMessage',[
       'chat_id'=>$chat_id,
       'text'=>'تم حفظ الإسم والسعر...✅
       إسم السلعة: '.$sales['n'].'
    السعر: '.$text.'
    الكود: '.$code
      ]);
     
      $sales['sales'][$code]['name'] = $sales['n'];
      $sales['sales'][$code]['price'] = $text;
      $sales['n'] = null;
      $sales['mode'] = null;
      save($sales);
      exit;
    }
    if($data == 'del'){
      bot('editMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>'أرسل كود السلعة للتأكيد',
     
        'reply_markup'=>json_encode([
         'inline_keyboard'=>[    
         [['text'=>'💸 السعر بالنقاط','callback_data'=>'s'],['text'=>'🍃 كارت بقمية','callback_data'=>'s']]
          ]
        ])
      ]);
      $sales['mode'] = 'del';
      save($sales);
      exit;
    }
    if($text != '/start' and $text != null and $sales['mode'] == 'del'){
      if($sales['sales'][$text] != null){
       bot('sendMessage',[
       'chat_id'=>$chat_id,
       'text'=>'تم الحذف بنجاح...✅
       إسم السلعة: '.$sales['sales'][$text]['name'].'
    السعر: '.$sales['sales'][$text]['price'].'
    الكود: '.$text
      ]);
      unset($sales['sales'][$text]);
      $sales['mode'] = null;
      save($sales);
      exit;
      } else {
       bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>'خطأ - الكود غير صحيح'
       ]);
      }
    }
    } else {
    if(preg_match('/\/(start)(.*)/', $text)){
      $ex = explode(' ', $text);
      if(isset($ex[1])){
       if(!in_array($chat_id, $sales[$chat_id]['id'])){
        $sales[$ex[1]]['collect'] += 1;
        save($sales);
        bot('sendMessage',[
         'chat_id'=>$ex[1] ,
         'text'=>"قام @$user بالدخول لرابطك الخاص وتمت إضافة نقطة واحدة في حسابك✨\n~ عدد نقاطك الآن:".$sales[$ex[1]]['collect'],
        ]);
        $sales[$chat_id]['id'][] = $chat_id;
        save($sales);
       }
      }
    /*
    إستبدل @elmasry016 بمعرف قناتك
    وتأكد أن البوت أدمن في القناة
    */
     
        $status = bot('getChatMember',['chat_id'=>'@DetailsApp','user_id'=>$chat_id])->result->status;
      if($status == 'left'){
       bot('sendMessage',[
           'chat_id'=>$chat_id,
           'text'=>"
       عزيزي العميل ❤
       
     - يجب عليك اولا للاستمتاع بالخدمة
           
     - الاشتراك في القناة الخاصة بالتطبيق 
           
     - اشترك ثم عاود الضغط علي Start 
    
    --------------👉{ /start }👈--------------",
     
           'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"اشتراك",'url'=>"https://t.me/DetailsApp"]],
        ]
       ])
       ]);
       exit();
      }
     
      $status = bot('getChatMember',['chat_id'=>'@stop0077','user_id'=>$chat_id])->result->status;
      if($status == 'left'){
       bot('sendMessage',[
           'chat_id'=>$chat_id,
           'text'=>"
           تنبيه!! 🚫
    البوت تحت الإنشاء هيتم اطلاقه باذن الله يوم ٣/٦/٢٠٢٠ توزيع 10 نقاط مجانا لكل من يسجل ف هذا اليوم
    متنساش تتواصل عبر القناة الخاصة هتعرفها اول اما البوت يشتغل وتطلب ال١٠ نقط 💋👌
    شكرا لتفهمكم ♥
    انت الان مشترك نورتنا ❤️",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"العودة الى الموقع",'url'=>"elmasry-online.com"]],
        ]
       ])
    
       ]);
       exit();
      }
    
      /*
      $status = bot('getChatMember',['chat_id'=>'@stop0077','user_id'=>$chat_id])->result->status;
      if($status == 'left'){
       bot('sendMessage',[
           'chat_id'=>$chat_id,
           'text'=>"
           تنبيه!! 🚫
    قد تم ايقاف البوت مؤقتا تلقائيا لانه في حالة صيانة الان وسيتم اخباركم حالة اعادة تشغيله ... شكرا لتفهمكم ♥",
    
       ]);
       exit();
      }
    */
      if($sales[$chat_id]['collect'] == null){
       $sales[$chat_id]['collect'] = 0;
       save($sales);
      }
     
     
      bot('sendmessage',[
       'chat_id'=>$chat_id,
        'text'=>'
 -----------اهلا بك عزيز العمليل----------
  
- في اول بوت لتطبيق يساعد مستخدميه علي تحقيق الارباح 🔥
  
- يساعدك البوت علي جني المال مقابل النقاط عن طريق تنفيذ بعض المهام
  
- عدد نقاطك الآن : $ '.$sales[$chat_id]['collect'],
  
    
       'reply_markup'=>json_encode([
       'inline_keyboard'=>[
         [['text'=>'العروض المقدمة من تفاصيل 📲','callback_data'=>'sales']],
         [['text'=>'جمع النقاط ✨','callback_data'=>'col'],['text'=>'شرح البوت ⁉️','callback_data'=>'about']],[['text'=>'تحميل الابليكيشن مباشر 📲','callback_data'=>'downloadapp'],['text'=>'الموقع الرسمي لتفاصيل ♥','url'=>"http://ramykhaled404.000webhostapp.com/Details.php"]],[['text'=>'لو عاوز بوت زي ده و بطريقتك دوس هنا 🤗','callback_data'=>'botsales']],
        ]
       ])
      ]);
    }
    if($data == 'back'){
    if($sales[$chat_id]['collect'] == null){
       $sales[$chat_id]['collect'] = 0;
       save($sales);
      }
    
      bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
       'text'=>'
  -----------اهلا بك عزيز العمليل----------
  
- في اول بوت لتطبيق يساعد مستخدميه علي تحقيق الارباح 🔥
  
- يساعدك البوت علي جني المال مقابل النقاط عن طريق تنفيذ بعض المهام
  
- عدد نقاطك الآن : $ '.$sales[$chat_id]['collect'],
   
       'reply_markup'=>json_encode([
        'inline_keyboard'=>[
         [['text'=>'العروض المقدمة من تفاصيل 📲','callback_data'=>'sales']],
         [['text'=>'جمع النقاط ✨','callback_data'=>'col'],['text'=>'شرح البوت ⁉️','callback_data'=>'about']],[['text'=>'تحميل الابليكيشن مباشر 📲','callback_data'=>'downloadapp'],['text'=>'الموقع الرسمي لتفاصيل ♥','url'=>"http://ramykhaled404.000webhostapp.com/Details.php"]],[['text'=>'لو عاوز بوت زي ده و بطريقتك دوس هنا 🤗','callback_data'=>'botsales']],
        ]
       ])
      ]);
    }
    
    
    if($data == "botsales"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    
    
  - لو عاوز بوت زي ده برجاء التواصل مع دعم التطبيق وطلبه 😉
    
  - او حتي لو محتاج بوت مثيل بيه بس بطريقتك او تعدل عليه 🤔
    
  - بردو اتواصل مع الدعم وبلغهم باحتياجك وتففاصيل البوت 👌
    
    وهيتم تلبية طلبك في اسرع وقت 🙌
    
    
---[ جميع حقوق البوت محفوظة لـ ]----
 ------------[Ramy Khaled]------------
  
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>'القائمة الرئيسية','callback_data'=>'back']],
        ]
       ])
      ]);
    }
    
    
    
    if($data == "downloadapp"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    
    يمكنك تحميل الابليكيشن برابك مباشر 👌
    
    لو عاوز تحمله اضغط علي نعم اريد التحميل ؟
    
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"نعم اريد التحميل ؟ 🤙 ",'url'=>"https://download1646.mediafire.com/24anch74rztg/2315yoaj82ni2fa/Details.apk"],['text'=>"لا اريد ❌",'callback_data'=>"back"]],[['text'=>'القائمة الرئيسية ↪','callback_data'=>'back']],
        ]
       ])
      ]);
    }
    
    
    
    if($data == 'buy'){
      bot('editMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>'للشراء إضغط على زر شراء النقاط 💰
    وسيحولك البوت إلى بوت التواصل مع المشرف قم بمراسلته للشراء فقط...💸',
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"شراء النقاط 💰",'url'=>"t.me/معرفك بدون @"],['text'=>"القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    
    
    
    if($data == "about"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    البوت بسيط ولا يحتاج لشرح أصلا...🗣
    
    ولكن على كل حال هذا شرح سريع
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"الخطوة الأولى",'callback_data'=>"k1"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    if($data == "k1"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    بعد الدخول للبوت إضغط على زر تجميع النقاط وبعدها سيرسل البوت لك رابط خاص بك فقط قم بنشره وأي شخص يدخل على الرابط تحصل على 1 نقطة
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"الخطوة الثانية",'callback_data'=>"k2"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],[['text'=>'شرح  جمع نقاط اكثر من طريقة ✌️','callback_data'=>'pointco']],
        ]
       ])
      ]);
    }
    
    
    if($data == "pointco"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    
    
    بص ياصديقي 🥰
    
    الامر بسيط جدا بس محتاج تركيز بسيط
    
    في اكتر من طريقة تقدر تجمع بيها النقط وهنقسمها كالتالي :
      
         1- الطريقة الاسهل وهي انك تنشر لينك الدعوة الخاص بيك بين اصحابك وهتاخد بوينت مقابل كل حد هيقبل الدعوة ❤
         
         2- الطريقة المتوسطة وهي انك تنتظر العروض اليومية الى بتنزل كل يوم مقدمة من التطبيق وهتاخد 10 بوينت لكل مهمة تنفذها حسب مهنزلها 🤟
         
         3- الطريقة الاصعب وهي وانك تنصح اصحابك بتحميل الابليكشن والانضمام للبوت وهتاخد قصاده الواحد 20 بوينت وسميت بالاصعب لانك هتحتاج تبعتلنا اثباتات بتنفيذ المهمة وطبعا هنقولهالك في ساعتها عشان بتتغير كل فترة زي الاي بي مثلا ❤🤙
         
         وبس ياصديقي الامر بسيط وجادي 100% نفذ وشوف بنفسك 💪❤
    
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"الرجوع للخلف 👉 ",'callback_data'=>"k1"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    
    
    if($data == "k2"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    بعد جمع عدد جيد من النقاط إضغط علي زر طلب العرض
    
    وبعدها اختار قيمة الكارت المناسب لعدد نقاطك
    
    ستصلك رسالة انتظار لمدة تصل الى 48 ساعة وهيتم ارسال لك الكارت في خلال المدة المذكورة
    
    ملحوظة : يرجي الاحتفاظ برقم العملية لانك ممكن تحتاجها عند استلامك للكارت ",
    
    
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"الخطوة الثالثة",'callback_data'=>"k3"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    if($data == "k3"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    سيصل طلبك لنا وسنرسل الكارت لك في غضون 48 (طبعا 48 ساعة أقصى مدة نتأخر فيها وذلك لكثرة الطلبات) وفي حال كانت الطلبات قليلة يصلك الرقم في نفس اليوم وربما في نفس الساعة
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    if($data == "k4"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    إذا لا تستطيع جمع النقاط يمكنك شراؤها...💸
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"شراء نقاط 💸",'callback_data'=>"buy"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    if($data == "numberfree"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    أرقام بدون نقاط تعتمد على السرعة
    حيث أننا نقوم بتوزيع أرقام في القناة وكل كود يعمل مع أول شخص فقط...🍃
    لو نشرنا رقم مغربي 🇲🇦 مع الكود بالطبع سيعمل مع أول شخص يدخله ولن يعمل مع البقية - فالأرقام بدون نقاط تعتمد على السرعة
    يمكنك الإشتراك بالقناة عن طريق الضغط على زر إشتراك 📢 في الأسفل…!
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"إشتراك 📢",'url'=>"http://t.me/Number3322"],['text'=>" القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    if($data == "bot"){
    bot('EditMessageText',[
    'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"
    لتحميل ملف البوت إضغط على تحميل - Download
    ",
    'reply_markup'=>json_encode([
        'inline_keyboard'=>[
    [['text'=>"تحميل - Download 🤖",'url'=>"https://t.me/C_DevM17/537"],['text'=>"العودة الي القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    
    
    if($data == 'col'){
      bot('editMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
        'text'=>'
     
        
  - قم بنشر الرابط الخاص بك بين الأصدقاء
  
  - وكل شخص يشترك في البوت من خلال هذا الرابط
  
  - [ سوف تحصل على 1 نقطة ]
  
  - هذا هو الرابط الخاص بك : 
    
  https://t.me/'.$me.'?start='.$chat_id.'
    
  - الاي دي الخاص بك : '.$chat_id.'
  
  - عدد نقاطك الان : $ '.$sales[$chat_id]['collect'],
  
    'reply_markup'=>json_encode([
         'inline_keyboard'=>[
    [['text'=>"شرح  جمع نقاط اكثر من طريقة ✌️",'callback_data'=>"pointco"]],[['text'=>"القائمة الرئيسية 🔙",'callback_data'=>"back"]],
        ]
       ])
      ]);
    }
    
    
    elseif($data == 'sales'){
      $reply_markup = [];
      $reply_markup['inline_keyboard'][] = [['text'=>'💸 السعر بالنقاط','callback_data'=>'s'],['text'=>'🍃 كارت بقمية','callback_data'=>'s']];
      foreach($sales['sales'] as $code => $sale){
       $reply_markup['inline_keyboard'][] = [['text'=>$sale['price'],'callback_data'=>$code],['text'=>$sale['name'],'callback_data'=>$code]];
      }
    if($sales[$chat_id]['collect'] == null){
       $sales[$chat_id]['collect'] = 0;
       save($sales);
      }
    $reply_markup['inline_keyboard'][] = [['text'=>'العودة إلى القائمة الرئيسية 🔙 ','callback_data'=>'back']];
      $reply_markup = json_encode($reply_markup);
      bot('editMessageText',[
       'chat_id'=>$chat_id,
       'message_id'=>$message_id,
       'text'=>'
    To purchase a Cart , click on the name of the Cart you want
    لشراء رقم إضغط على إسم االكارت التي تريدها
    ~ عدد نقاطك الآن: '.$sales[$chat_id]['collect'],
       'reply_markup'=>($reply_markup)
      ]);
      $sales[$chat_id]['mode'] = null;
       save($sales);
       exit;
    } elseif($data == 'yes'){
      $price = $sales['sales'][$sales[$chat_id]['mode']]['price'];
    $name = $sales['sales'][$sales[$chat_id]['mode']]['name'];
      bot('editMessageText',[
       'chat_id'=>$chat_id,
       'message_id'=>$message_id,
       'text'=>"تم إستلام طلبك...✅
      
    سيتم تسليم الرقم لك في مدة أقصاها 48 ساعة
    
    إذا قمت بحذف المحادثة لن تستلم الرقم"
    
      ]);
      bot('sendmessage',[
       'chat_id'=>$admin,
       'text'=>"- - - - - - - - - - - - - - - - - - - - - - - - -
    الأيدي: $chat_id
    المعرف إن وجد: @$user
    - - - - - - - - - - - - - - - - - - - - - - - - -
    قم بشراء $name بسعر $price كود
    
    - - - - - - - - - - - - - - - - - -
    لتسليم الطلب إضغط 👈 /sendnumber
    - - - - - - - - - - - - - - - - - - - - - - - - -"
      ]);
      $sales[$chat_id]['mode'] = null;
      $sales[$chat_id]['collect'] -= $price;
      save($sales);
      exit;
    } else {
       if($data == 's') { exit; }
       $price = $sales['sales'][$data]['price'];
       $name = $sales['sales'][$data]['name'];
       $code = $sales['sales'][$data]['code'];
       if($price != null){
        if($price <= $sales[$chat_id]['collect']){
         bot('editMessageText',[
          'chat_id'=>$chat_id,
          'message_id'=>$message_id,
          'text'=>"
    هل أنت متأكد وتريد إتمام الطلب...؟
    
    طلبك هو:
      
    شراء كارت بـ $name بسعر $price نقطة 👉", 
          'reply_markup'=>json_encode([
           'inline_keyboard'=>[
            [['text'=>'نعم - أنا متأكد','callback_data'=>'yes'],['text'=>'لا - إلغاء الشراء','callback_data'=>'sales']]
           ]
          ])
         ]);
         $sales[$chat_id]['mode'] = $data;
         save($sales);
         exit;
        } else {
         bot('answercallbackquery',[
          'callback_query_id' => $update->callback_query->id,
          'text'=>'نقاطك غير كافية لشراء هذا الرقم',
          'show_alert'=>true
         ]);
        }
       }
    }
    }
    
    $ary = array($admin);
    $id = $message->from->id;
    $admins = in_array($id,$ary);
    $data = $update->callback_query->data;
    $from_id = $message->from->id;
    $chat_id = $message->chat->id;
    $chat_id2 = $update->callback_query->message->chat->id;
    $cut = explode("\n",file_get_contents("stats/users.txt"));
    $users = count($cut)-1;
    $mode = file_get_contents("stats/bc.txt");
    #Start code
    
    if ($update && !in_array($id, $cut)) {
        mkdir('stats');
        file_put_contents("stats/users.txt", $id."\n",FILE_APPEND);
      }
    
        if(preg_match("/(admin)/",$text) && $admins) {
            bot('sendMessage',[
                'chat_id'=>$chat_id,
              'text'=>"
    أهلا مطوري...
    
    شبيك لبيك البوت بين يديك
    
    إضغط على طلبك في القائمة وستتم تلبية الطلب تلقائيا...🌚
    
    -",
        'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
        [['text'=>'عدد المشتركين 👥 ','callback_data'=>'users'],['text'=>'رسالة للكل 📩 ','callback_data'=>'c']],
        [['text'=>'حالة البوت 🔋 ','callback_data'=>'stats']],
                    ]
                    ])
                ]);
        }
        if($data == 'homestats'){
        bot('editMessageText',[
        'chat_id'=>$chat_id2,
        'message_id'=>$message_id,
        'text'=>"
    أهلا مطوري...
    
    شبيك لبيك البوت بين يديك
    
    إضغط على طلبك في القائمة وستتم تلبية الطلب تلقائيا...🌚
    
    -",
        'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
        [['text'=>'عدد المشتركين 👥 ','callback_data'=>'users'],['text'=>'رسالة للكل 📩 ','callback_data'=>'c']],
        [['text'=>'حالة البوت 🔋 ','callback_data'=>'stats']],
                    ]
                    ])
        ]);
        file_put_contents('stats/bc.txt', 'no');
        }
       
        if($data == "users"){
            bot('answercallbackquery',[
                'callback_query_id'=>$update->callback_query->id,
                'text'=>"
    المشتركين $users
    -",
                'show_alert'=>true,
        ]);
        }
       
        if($data == "set"){
            file_put_contents("stats/bc.txt","yas");
            bot('EditMessageText',[
            'chat_id'=>$chat_id2,
            'message_id'=>$update->callback_query->message->message_id,
            'text'=>"
    أرسل رسالتك ليتم إرسالها إلى $users مشترك 👥
    
    كتابة فقط...🌚
    -
        ",
        'reply_to_message_id'=>$message->message_id,
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>' الغاء 🚫. ','callback_data'=>'c']]   
                ]
            ])
            ]);
        }
        if($text and $mode == "yas" && $admins){
            bot('sendMessage',[
                  'chat_id'=>$chat_id,
                  'text'=>"
    تم قبول رسالتك!
    
    ويتم إرسالها إلى $users مشترك 👥
    
    -",
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>'رجوع ','callback_data'=>'c']]   
                ]
            ])
        ]);
        for ($i=0; $i < count($cut); $i++) {
         bot('sendMessage',[
        'chat_id'=>$cut[$i],
        'text'=>"$text",
        'parse_mode'=>"MarkDown",
        'disable_web_page_preview'=>true,
        ]);
        file_put_contents("stats/bc.txt","no");
        }
        }
        date_default_timezone_set("Asia/Baghdad");
        $getMe = bot('getMe')->result;
        $date = $message->date;
        $gettime = time();
        $sppedtime = $gettime - $date;
        $time = date('h:i');
        $date = date('y/m/d');
        $userbot = "{$getMe->username}";
        $userb = strtoupper($userbot);
        if($data == "stats"){
        if ($sppedtime == 3  or $sppedtime < 3) {
        $f = "ممتازة";
        }
        if ($sppedtime == 9 or $sppedtime > 9 ) {
        $f = "لا بأس";
        }
        if ($sppedtime == 10 or $sppedtime > 10) {
        $f = " سيئة جدا";
        }
         bot('EditMessageText',[
            'chat_id'=>$chat_id2,
            'message_id'=>$update->callback_query->message->message_id,
            'text' =>"
    معلومات البوت:
    
    معرف البوت @$userb
    
    حالة البوت $f
    
    الوقت الآن: 20$date | $time
    
    -",
    'parse_mode'=>"MarkDown",
    'disable_web_page_preview'=>true,
        'reply_markup'=>json_encode([
        'inline_keyboard'=>[
        [['text'=>'رجوع ','callback_data'=>'c']]   
                ]
            ])
           ]);
        }
    
    
        ?>
    
    
     
