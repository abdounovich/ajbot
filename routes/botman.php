<?php
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use App\Http\Controllers\BotManController;
use BotMan\Drivers\Facebook\FacebookDriver;

$config = [
    'facebook' => [
        'token' => 'EAAW2ZByvfRBsBANnfr63dBsmFMpNk1tBMhI3S3BrPRh1wUvkk4M8GiqFZCNl28UWBs7hbbk2OvpEUbLTZBm5glaYS3vmmNaGcmgeqvdVkJvzCskm30zelwCxin2F9N2X5QNtoCoZCTxRaZArkev2ZCsmBXP11T7wMrkSapHhbozngrdhOvbztnQjnM3LqvN1gZD',
      'app_secret' => '98196f7535e14eedec6689df3cbd06b9',
      'verification'=>'ask_123',
  ]
];

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

// Create an instance
$botman = BotManFactory::create($config);

$botman = resolve('botman');

$botman->hears('5', function($bot) {
  
    $a=[];
    $total=Product::all()->count();
    $bot->reply($total);
    for ($i=1; $i<$total ; $i++) { 
    $prod = Product::where('categorie_id',$i)->get();
    if($prod->count() == 0){
       }
    else{
        $bot->typesAndWaits(1);
    
    foreach($prod as $pro){
    
       
        $b= Element::create($pro->nom)
        ->subtitle('dd')
        ->image($pro->photo)
        ->addButton(ElementButton::create('احجز')
            ->payload('p'.$pro->id)
            ->type('postback'));
           $a[]=$b;
        
    } 
    
    $n=GenericTemplate::create()
    ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
    ->addElements($a);
    
    
    
        $bot->reply($n);
    
        $a=[];
        
     }
    }
    });
    
    $botman->hears('p([0-9]+)', function ($bot, $number) {
        $bot->startConversation(new ExampleConversation($number));
    
    });
    
    $botman->hears('1', function ($bot) {
        $bot->typesAndWaits(1);
        $user = $bot->getUser();
    // Access first name
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    
    $bot->reply($firstname . "-".$lastname. ' : مرحبا بك');
    /* $bot->reply( 'تشرفنا زيارتك لصفحة AJMODA كيف يمكننا خدمتك');
     */
    
    
    
    
    
    
    
        
    });
    
    
    
    $botman->fallback(function($bot) {
        $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
    });
    $botman->hears('Start conversation', BotManController::class.'@startConversation');
    $botman->hears('العربية', BotManController::class.'@SetLanguageToAr');
    $botman->hears('francais', BotManController::class.'@SetLanguageToFr');
    
    
    