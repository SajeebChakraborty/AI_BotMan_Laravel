<?php
  
namespace App\Http\Controllers;
  
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Action\ButtonTemplate;
use BotMan\BotMan\Messages\Outgoing\Question;
use Mpociot\BotMan\Messages\Message;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
  
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
  
        $botman->hears('{message}', function($botman, $message) {
  
            if ($message == 'hi' || $message == 'hello') {
                // $this->askName($botman);

                $botman->reply('hello');

            }
            else if ($message == 'age' || $message== "what is your age?") {
                
                $botman->reply('23');
            }
            else if ($message == 'name' || $message== "what is your name?") {
                
                $botman->reply('Allexa');
            }
            else if ($message == 'image' || $message== "how do you look?") {
                
                $attachment = new Image('http://image-url-here.jpg');

                $reply_out = OutgoingMessage::create('My Image is')
                ->withAttachment($attachment);

   
                // Reply message object
                $botman->reply($reply_out);


            }
            else if ($message == 'location' || $message== "where am I?" || $message== "my location") {
                

                
               // Create attachment
                $attachment = new Location(61.766130, -6.822510, [
                    'custom_payload' => true,
                ]);

                $botman->reply(Question::create('are you sure')->addButtons([
                    Button::create('yes !')->additionalParameters([
                        'url' => 'https://google.com',
                  ]),
                ]));

            

                /*
                $question = Question::create('Great. Can you give me your location?')
            ->addAction(QuickReplyButton::create('test')->type('location'));

                $this->ask($question, function (Answer $answer) {
                    $this->botman->reply('Latitude: '.$answer->getMessage()->getLocation()
                            ->getLatitude().' Longitude: '.$answer->getMessage()->getLocation()->getLongitude());
                });

                */

               

                /*
                // Build message object
                $reply_out = OutgoingMessage::create('Your location is -')
                            ->withAttachment($attachment);

               
                // Reply message object
                $botman->reply($reply_out);

                */
              
                //Redirect::action('App\Http\Controllers\BotManController@index');

            }
            else{

                $botman->reply('Please say again !');

            }
  
        });
  
        $botman->listen();
    }
  
    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
  
            $name = $answer->getText();
  
            $this->say('Nice to meet you '.$name);
        });
    }
   
}