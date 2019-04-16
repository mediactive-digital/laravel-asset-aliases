# Link CSS / JS files in Laravel Blade templates

This package makes it easier to link CSS / JS files in Laravel Blade templates.

## Installation

#### Require the package using Composer.

```bash
composer require mediactive-digital/laravel-asset-aliases
```

#### Laravel < 5.5

Add the service provider to /config/app.php file.

```php
'providers' => [
    // ...
	MediactiveDigital\LaravelAssetAliases\LaravelAssetAliasesServiceProvider::class,
],
```

Add the AssetManager facade to /config/app.php file.

```php
'aliases' => [
    // ...
    'MDAsset' => MediactiveDigital\LaravelAssetAliases\LaravelAssetAliasesFacade::class,
],
```


## Htaccess changes

In order to avoid cache issues, especially with nginx, this package add specific timestamp in the filename of js & css files. `home.js` will be called as `home.{timestamp}.js`. You will need to add the following rule to your `.htaccess` file.

```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)\.[0-9]+\.(css|js)$ /$1.$2 [L]
</IfModule>

```

## Usage

You can link either an internal resource or an external URL.

#### Link CSS files.

simple file

```
	{!! MDAsset::addCss('stylesheet.css') !!}
```

or array of files

```
	{!! MDAsset::addCss(['stylesheet.css', 'stylesheet2.css']) !!}
```

#### Link JS files.

simple file

```
	{!! MDAsset::addJs('script.js') !!}
```

or array of files

```
	{!! MDAsset::addJs(['script.js', 'script2.js']) !!}
```

#### Link CSS / JS files by aliases.

Add aliases to the configutation file located at /config/laravel-asset-aliases/alias.php.

```php
// Example
return [
	'css' => [
		'stylesheet' => 'stylesheet.css'
	],
	'js' => [
		'script' => 'script.js'
	]
];
```

Then link files by aliases, for example :

```
	{!! MDAsset::addCss('stylesheet') !!}
```

#### Support for HTML attributes.

You can pass any number of HTML attributes along with your file definition.\
It can be done both in configuration file and / or Blade templates.\
Attributes defined in Blade templates override configuration ones.

If you do so, you must use an associative array with the mandatory keys "file" and "attributes".\
"file" being your file (string) and "attributes" being your HTML attribute(s) (array).

```php
// Examples

// Inside configuration file : 
return [
	'css' => [
		'stylesheet' => [
			'file' => 'stylesheet.css',
			'attributes' => [
				'media' => 'print',
				'title' => 'title'
			]
		],
		'other-stylesheet' => [
			'file' => 'other-stylesheet.css',
			'attributes' => [
				'media' => 'screen'
			]
		]
	],
	'js' => [
		'script' => [
			'file' => 'script.js',
			'attributes' => [
				'integrity' => 'sha384-rAnDoMkeY',
        		'crossorigin' => 'anonymous'
			]
		],
		'other-script' => [
			'file' => 'other-script.js',
			'attributes' => [
				'async' => null
			]
		]
	]
];

// Inside Blade template : 
{!! MDAsset::addCss([
	[
		'file' => 'stylesheet', 
		'attributes' => [
			'media' => 'print',
			'title' => 'title'
		]
	], 
	[
		'file' => 'other-stylesheet', 
		'attributes' => [
			'media' => 'screen'
		]
	]
]) !!}

{!! MDAsset::addJs([
	[
		'file' => 'script.js', 
		'attributes' => [
			'integrity' => 'sha384-rAnDoMkeY', 
			'crossorigin' => 'anonymous'
		]
	], 
	'other-script' => [
		'file' => 'other-script.js',
		'attributes' => [
			'async' => null
		]
	]
]) !!}
```

