# People Generator

A PHP library for generating random people; name, email, gender, photo etc.

It differs from libraries such as Faker in that in maintains some consistency - e.g. the email address resembles the person's name - as well as using 
gendered names and photos.

## Usage

Include the generator and create an instance:

```php
use Lukaswhite\PeopleGenerator\Generator;

$generator = new Generator();
```

To generate a single person:

```php
$person = $generator->generate();
```

> This returns an instance of the `Person` class, which has a number of GETters for fields such as forename/surname/name, gender, date of birth and photo.

To specify their gender:

```php
$person = $generator->male();
// or
$person = $generator->female();
```

To generate a number of people in bulk:

```php
$people = $generator->bulk(100);
```

## Names

The library generates forenames and surnames independently; this can be retrieved using `getForename()` and `getSurname()` respectively.

The full name is available via `getName()` and the initials via `getInitials()`.

## Emails

By default, the generator keeps track of generated emails and tries wherever possible to ensure their uniqueness. 

You can disable this:

```php
$generator->disableUniqueEmails();
```

If it cannot generate a unique email, it throws an instance of `CannotGenerateUniqueEmailException`.

Note that in order to see a conflict in the email address, the name would have to exactly match, and it would have to exhaust over 3,500 email domains. 

## Photos

The photos are designed to appear to match the generated gender for consistency, and are AI generated. Note that the `getPhoto()` method returns the full path to the file, to use as required.