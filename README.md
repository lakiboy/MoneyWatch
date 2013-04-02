# MoneyWatch

The purpose of this application is to play around with _Silex_ (I was bored one night and found nothing else to do).
However, it does some useful stuff too. Useful for my case, of course.

## How it works 

- You select the currency;
- fill in your email;
- choose a compare operator (equal to, not equal to, etc);
- specify a value to compare to.

Currency exchange rates are compared to Latvian Lat - LVL.

#### Example

- Currency: USD
- Compare operator: greater than
- Compare value: 0.5

__Result__: Subscriber will receive an email notification in case currency exchange rate of USD to LVL exceeds 0.5.

You can omit comparison/value alltogether and receive daily notification about selected currency. You can subscribe
as many times as you want.

Currency exchange rates are downloaded from the Bank of Latvia.

## Installation

Create a database and then run:

```bash
$ git clone https://github.com/lakiboy/MoneyWatch.git moneywatch
$ cd moneywatch
$ composer.phar install
$ mkdir app/cache
$ setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache
$ setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache
$ mysql -u moneywatch -D moneywatch < app/Resources/schema/schema.sql
$ php app/console.php currency:load
$ php app/console.php currency:exchange:load
```

## Notifications

At the moment there is no generic notification mechanism for all users. You can notify a single user instead.

```bash
php app/console.php notify:subscriber lakiboy83@gmail.com
```

## Cron

You can put something like this in cron.

```cron
0 2 * * * php /var/www/moneywatch/app/console.php currency:exchange:load
5 2 * * * php /var/www/moneywatch/app/console.php notify:subscriber lakiboy83@gmail.com
```
