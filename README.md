# Laravel Pending

**andresdevr/laravel-approvals** allows to edit models adding to pending changes 

## Installation

Install this package via [Composer](https://getcomposer.org/)

`
composer require andresdevr/laravel-approvals to your model
`

## Usage

Add the trait `Andresdevr\LaravelApprovals\Traits\HasApprovals` then you can call these methods to add to pending changes

```php
	$foo->addToPending(); //restore all the dirty attributes and saved into pending

    $foo->approveChange('attribute'); //approve change for an attribute

    $foo->approveAll(); //approve all the pending changes

    $foo->denyChange('attribute'); //deny all the pending changes

    $foo->denyAll();
```

### Timestamps
by default `andresdevr/laravel-approvals` save the timestamp when was the change requested, the change approved and the the change denied.
you can change the `APPROVALS_USE_TIMESTAMP` variable in your `.env`.  
Instead you can give format to the timestamp changing the `format` property of your model, or you can call the method `setApprovalTimestamp('format')`
before call `addToPending()`

```php

    $foo->setApprovalTimestamp('y-m-d')->addToPending();

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)