# php-v8
PHP extension for V8 JavaScript engine

[![Build Status](https://travis-ci.org/pinepain/php-v8.svg)](https://travis-ci.org/pinepain/php-v8)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/pinepain/php-v8/master/LICENSE)

This extension is for PHP 7 only.

**This extension is still under heavy development and its public API may change without any warning. Use at your own risk.**


## About
[php-v8](https://github.com/pinepain/php-v8) is a PHP 7.x extension
that brings [V8](https://developers.google.com/v8/intro) JavaScript engine API to PHP with some abstraction in mind and
provides an accurate native V8 C++ API implementation available from PHP.

**Key features:**
 - provides up-to-date JavaScript engine with recent [ECMA](http://kangax.github.io/compat-table) features supported;
 - accurate native V8 C++ API implementation available from PHP;
 - solid experience between native V8 C++ API and V8 API in PHP;
 - no magic; no assumptions;
 - does what it is asked to do;
 - hides complexity by isolation and contexts scope management under the hood;
 - provides a both-way interaction with PHP and V8 objects, arrays and functions;
 - execution time and memory limits;
 - multiple isolates and contexts at the same time;
 - it works;

With this extension almost everything that the native V8 C++ API provides can be used. It provides a way to pass PHP scalars,
objects and functions to the V8 runtime and specify interactions with passed values (objects and functions only, as scalars
become js scalars too). While specific functionality will be done in PHP userland rather than in this C/C++ extension,
it lets you get into V8 hacking faster, reduces time costs and gives you a more maintainable solution. And it doesn't
make any assumptions for you, so you stay in control, it does exactly what you ask it to do.

With php-v8 you can even implement nodejs in PHP. Not sure whether anyone should/will do this anyway, but it's doable.

*NOTE: Most, if not all, methods are named like in the V8 API - starting from capital letter. This PSR violation is done
intentionally with the purpose to provide a more solid experience between the native V8 C++ API and the V8 PHP API.*


## Demo

Here is a [Hello World][v8-hello-world]
from V8 [Getting Started][v8-intro] developers guide page implemented in PHP with php-v8:

```php
<?php
$isolate = new \V8\Isolate();
$context = new \V8\Context($isolate);
$source = new \V8\StringValue($isolate, "'Hello' + ', World!'");

$script = new \V8\Script($context, $source);
$result = $script->Run($context);

echo $result->ToString($context)->Value(), PHP_EOL;
```

which will output `Hello, World!`. See how it's shorter and more readable than [that C++ version]([v8-hello-world])?
And it also doesn't limit you from V8 API utilizing to implement more amazing stuff.

## Installation

### Requirements

#### V8
You will need a recent v8 Google JavaScript engine version installed. At this time the extension is tested on 5.4.420.

 - For Ubuntu there is the [pinepain/libv8-5.4](https://launchpad.net/~pinepain/+archive/ubuntu/libv8-5.4) PPA.
   To install libv8:

   ```
   $ sudo add-apt-repository -y ppa:pinepain/libv8-5.4
   $ sudo apt-get update -y
   $ sudo apt-get install -y libv8-5.4-dev
   ```
 - For OS X there is the [v8.rb](https://github.com/pinepain/php-v8/blob/master/scripts/homebrew/v8.rb) homebrew formula.
   To install libv8:

   ```
   $ brew install https://raw.githubusercontent.com/pinepain/php-v8/master/scripts/homebrew/v8.rb
   ```

#### PHP 7

 - For Ubuntu there is the [ondrej/php](https://launchpad.net/~ondrej/+archive/ubuntu/php) PPA by [Ondřej Surý](https://deb.sury.org).

   To install `php7.0`:

   ```
   $ sudo add-apt-repository -y ppa:ondrej/php
   $ sudo apt-get update -y
   $ sudo apt-get install -y php7.0
   ```
 - For OS X there is the [homebrew/homebrew-php](https://github.com/Homebrew/homebrew-php) tap with php70, php71 and a large
   variety extensions for them.

   To install `php70`:

   ```
   $ brew tap homebrew/homebrew-php
   $ brew install php70
   ```


### Installing php-v8 from packages

 - For Ubuntu there is the [pinepain/php-v8](https://launchpad.net/~pinepain/+archive/ubuntu/php-v8) PPA.

   To install `php-v8`:

   ```
   $ sudo add-apt-repository -y ppa:pinepain/php-v8
   $ sudo apt-get update -y
   $ sudo apt-get install -y php-v8
   ```
 - For OS X there are the [php70-v8.rb][php70-v8.rb] and [php71-v8.rb][php71-v8.rb] homebrew formulas.

   To install `php70-v8` do:

   ```
   $ brew install https://raw.githubusercontent.com/pinepain/php-v8/master/scripts/homebrew/php70-v8.rb
   ```

### Building php-v8 from sources

```
git clone https://github.com/pinepain/php-v8.git
cd php-v8
phpize && ./configure && make
make test
```

To install extension globally run

```
$ sudo make install
```

## Developers note
 - to be able to customize some tests make sure you have `variables_order = "EGPCS"` in your php.ini
 - `export DEV_TESTS=1` allows to run tests that are made for development reasons (e.g. test some weird behavior or for debugging)
 - To prevent the test suite from asking you to send results to the PHP QA team do `export NO_INTERACTION=1`

 - To track memory usage you may want to use `smem`, `pmem` or even `lsof` to see what shared object are loaded
   and `free` to display free and used memory in the system.

## License

Copyright (c) 2015-2016 Bogdan Padalko &lt;pinepain@gmail.com&gt;

[php-v8](https://github.com/pinepain/php-v8) PHP extension is licensed under the [MIT license](http://opensource.org/licenses/MIT).


[v8-hello-world]: https://chromium.googlesource.com/v8/v8/+/master/samples/hello-world.cc
[v8-intro]: https://developers.google.com/v8/intro
[php70-v8.rb]: https://github.com/pinepain/php-v8/blob/master/scripts/homebrew/php70-v8.rb
[php71-v8.rb]: https://github.com/pinepain/php-v8/blob/master/scripts/homebrew/php71-v8.rb
