# Laravel Clockwork SMS Notifications

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

Add your API Key options to your `services.php` 

```php
'clockwork-sms' => [
    'key' => env('CLOCKWORK_SMS_KEY')
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

Finally, personalise the message that should be sent.

*If you wish, you can also return an object that implements the* `__toString()` magic method.

```php
 /**
  * Get the Clockwork SMS representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return string
  */
 public function toClockworkSms($notifiable)
 {
     return sprintf(
         "Hello %s, Your activation code is: %s",
         $notifiable->name,
         $notifiable->activation_code
     );
 }
```

Send your notification, done!