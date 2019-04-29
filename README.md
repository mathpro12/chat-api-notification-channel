# ChatAPI notification channel for Laravel 5.3+

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send WhatsApp notifications using [ChatAPI](https://chat-api.com) with Laravel 5.3+.

## Contents

- [Installation](#installation)
    - [Setting up the Chat API service](#setting-up-the-Chat-API-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
`composer require pedrommone/chat-api-notification-channel`

Add the service provider to `config/app.php`:

```php
// config/app.php
'providers' => [
    ...
    Pedrommone\ChatAPINotificationChannel\ChatAPIChannelServiceProvider::class,
],
```

PRO-TIP: Laravel 5.8 added an auto-discovery service, this is not needed anymore.

### Setting up the Chat API service
Log in to your [Chat API dashboard](https://https://app.chat-api.com//) and grab your Instance Id and Auth Token. Add them to `config/services.php`.  

```php
// config/services.php
...

'chat_api' => [
    'instance_id' => env('CHAT_API_INSTANCE_ID'),
    'token' => env('CHAT_API_TOKEN'),
],
```

## Usage

Follow Laravel's documentation to add the channel into your Notification class:

```php
use Illuminate\Notifications\Notification;
use Pedrommone\ChatAPINotificationChannel\Channels\ChatAPIChannel;
use Pedrommone\ChatAPINotificationChannel\Channels\WhatsAppMessage;

public function via($notifiable)
{
    return [ChatAPIChannel::class];
}

public function toChatAPI($notifiable)
{
    return (new WhatsAppMessage())
        ->content('This is a WhatsApp message via ChatAPI using Laravel Notifications!');
}
```  

Add a `routeNotificationForChatAPI` method to your Notifiable model to return the phone number:  

```php
public function routeNotificationForChatAPI()
{
    // Country code, area code and number without symbols or spaces
    return preg_replace('/\D+/', '', $this->phone_number);
}
```    

### Available Message methods

* `content()` - (string), WhatsApp notification body

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

Special thanks to [Laravel Notification Channels](http://laravel-notification-channels.com/) guys, this library is mainly based on their approach.

- [Pedro Maia](https://github.com/pedrommone)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see the [License File](LICENSE) for more information.
