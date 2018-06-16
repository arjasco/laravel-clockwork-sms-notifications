# Laravel Clockwork SMS Notifications

[![Build Status](https://travis-ci.org/arjasco/laravel-clockwork-sms-notifications.svg?branch=master)](https://travis-ci.org/arjasco/laravel-clockwork-sms-notifications)

This package extends the laravel notification system to add the UK based [Clockwork SMS](https://wwww.clockworksms.com) as an additional delivery method.

## Installation

Install with composer:

    composer require arjasco/laravel-clockwork-sms-notifications

Add the service provider to your `app.php` configuration

```php
'providers' => [
    ...
    Arjasco\ClockworkSms\ClockworkSmsServiceProvider::class,
],
```

Add your API Key & default from number options to your `services.php` 

```php
'clockwork-sms' => [
    'key' => env('CLOCKWORK_SMS_KEY'),
    'from' => env('CLOCKWORK_SMS_FROM')
],
```

## Usage

Within your notifiable class, implement the route method to return the number that should receive the SMS.

```php
 /**
  * Route notifications for the clockwork sms channel
  *
  * @param  \Illuminate\Notifications\Notification  $notification
  * @return string
  */
 public function routeNotificationForClockworkSms($notification)
 {
     return $this->mobile_number;
 }
```

Within your notification class use `clockwork-sms` as one of the delivery channels.

```php
 /**
  * Get the notification's delivery channels.
  *
  * @param  mixed  $notifiable
  * @return array
  */
 public function via($notifiable)
 {
     return ['clockwork-sms'];
 }
```

Finally, personalise the message that should be sent. Return a string or a `ClockworkSmsMessage` instance as shown below.

*Only use the long method if you intend on sending a long message that should be combined into a single message as opposed to multiple messages of 160 characters.*

```php
 /**
  * Get the Clockwork SMS representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return string
  */
 public function toClockworkSms($notifiable)
 {
     $content = sprintf(
         "Hello %s, Your activation code is: %s",
         $notifiable->name,
         $notifiable->activation_code
     );

     return (new ClockworkSmsMessage)
               ->from('Einstein')
               ->content($content)
               ->long(false);
 }
```

Send your notification, done!