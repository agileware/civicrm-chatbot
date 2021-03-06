<?php
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Interfaces\Middleware\Sending;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Users\User;
use BotMan\BotMan\BotMan;

class CRM_Chat_Middleware_Identify implements Received, Sending {

  public function received(IncomingMessage $message, $next, BotMan $bot) {

    $driver = $bot->getDriver();
    $user = $bot->getDriver()->getUser($message);

    $this->identify($message, $driver, $user);

    return $next($message);

  }

  // Used to identifiy server originated messages
  public function sending($payload, $next, BotMan $bot) {

    // The server fakes an incoming message from the user
    // Use this to identify the recipient

    $message = $bot->getMessage();
    $driver = $bot->getDriver();
    $user = $bot->getDriver()->getUser($message);

    if($user->getId() == null){
      $user = new User($message->getSender());
    }

    $this->identify($message, $driver, $user);

    return $next($payload);

  }

  function identify($message, $driver, $user){

    $service = CRM_Chat_Driver::getServiceName($driver);
    $params = [
      'service' => $service,
      'user_id' => $user->getId()
    ];

    try {
      $chatUser = civicrm_api3('ChatUser', 'getsingle', [
        'service' => $service,
        'user_id' => $user->getId()
      ]);
      $contactId = $chatUser['contact_id'];
    } catch (Exception $e) {

      if(defined(get_class($driver).'::KNOWS_CONTACT_ID') && $driver::KNOWS_CONTACT_ID){

        $this->createUser($service, $user->getId(), $user->getId());
        $contactId = $user->getId();
      }else{

        $contactId = $this->createContact($user, $service);
        $this->createUser($service, $user->getId(), $contactId);
      }
    }

    $message->addExtras('contact_id', $contactId);

  }

  function createContact($user, $service){
    $contact = civicrm_api3('Contact', 'create', [
      'contact_type' => 'Individual',
      'source' => 'Chatbot',
      'first_name' => $user->getFirstName(),
      'last_name' => $user->getLastName()
    ]);

    $result = civicrm_api3('EntityTag', 'create', array(
      'contact_id' => $contact['id'],
      'tag_id' => "Chatbot"
    ));

    $extraInfoClass = "addExtra{$service}Info";
    if(method_exists($this, $extraInfoClass)){
      $this->$extraInfoClass($user, $contact['id']);
    }

    return $contact['id'];
  }

  function createUser($service, $userId, $contactId){
    $result = civicrm_api3('ChatUser', 'create', [
      'service' => $service,
      'user_id' => $userId,
      'contact_id' => $contactId
    ]);
  }

  function addExtraFacebookInfo($user, $contactId) {

    $info = $user->getInfo();

    // Download photo from Facebook
    $imageName = md5($user->getId().$contactId) . '.jpg';
    $path = Civi::paths()->getPath(Civi::settings()->get('customFileUploadDir')) . $imageName;
    file_put_contents($path, file_get_contents($info['profile_pic']));

    civicrm_api3('Contact', 'create', [
      'id' => $contactId,
      'image_URL' => CRM_Utils_System::url('civicrm/contact/imagefile', ['photo' => $imageName], true),
      'gender' => $info['gender']
    ]);

  }

}
