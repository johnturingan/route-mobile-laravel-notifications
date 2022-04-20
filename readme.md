# [route-mobile](https://routemobile.com/)-laravel-notifications

> A laravel package for sending notifications via [route-mobile](https://routemobile.com/) service.

Installation :traffic_light:
-------
Add the package to your composer.json

```
"require": {
    ... 
    "johnturingan/route-mobile-laravel-notifications": "{version}"
},
```

Or just run composer require

```bash
$ composer require johnturingan/route-mobile-laravel-notifications
```

## Config :page_facing_up:

To use this plugin, you need to add the following configuration to your config/services.php file

```
'route-mobile-notifications' => [
    'host' => 'https://apis.rmlconnect.net',
    'gateway' => \Snp\Notifications\Rml\Services\RouteMobileGateway::class,
    'username' => 'username',
    'password' => 'password',
]
```

## Usage :white_check_mark:

For full documentation, please refer to [Laravel Notification Docs](https://laravel.com/docs/9.x/notifications)

### Sending Notification

To send notification you can use the Laravel Notification Facade and pass the viber mobile number as the first parameter

```
public function send () 
{
    Notification::send('639057654321', new LeadAddedNotification());
    Notification::send(['639067654321', '639077654321'], new LeadAddedNotification());
}
```

### Formatting Viber Notification
If a notification supports being sent as a Routemobile Viber message, you should define a toRMLViber method on the notification class. This method will receive a $notifiable entity and should return an Snp\Notifications\Rml\Messages\ViberMessage instance. Let's take a look at a basic toRMLViber example:

```
use Snp\Notifications\Rml\Constants\MessagingMethod;
use Snp\Notifications\Rml\Constants\MessagingType;
use Snp\Notifications\Rml\Messages\ViberMessage;
...

/**
 * Get the Viber representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return Snp\Notifications\Rml\Messages\ViberMessage
 */
public function toRMLViber($notifiable)
{
    return (new ViberMessage('This is a viber message from Laravel'))
            ->setRecipient($recipient)
            ->setType(MessagingType::SINGLE_TEXT)
            ->setMethod(MessagingMethod::ONE_WAY)
            ;
}
```

----
**`NOTE:`**

If you find any bugs or you have some ideas in mind that would make this better. Please don't hesitate to create a pull request.

If you find this package helpful, a simple star is very much appreciated.

----
**[MIT](LICENSE) LICENSE** <br>
copyright &copy; 2022 Scripts and Pixels.