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

## Usage

You can link either an internal resource or an external URL.

#### Link CSS files.

simple file

```
	{!! MDAsset::addCss('stylesheet.css') !!}
```

or array of files

```
	{!! MDAsset::addCss(['stylesheet.css','stylesheet2.css']) !!}
```

#### Link JS files.

simple file

```
	{!! MDAsset::addJs('script.js') !!}
```

or array of files

```
	{!! MDAsset::addJs(['script.js','script2.js']) !!}
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

#### Support for SRI relative to resources loaded from CDN.

Instead of passing an external URL only, you can pass an array of values for SRI support.\
Three parameters are taken into account :

1. External URL.
2. Subresource integrity hash key.
3. Cross-origin resource sharing setting ("use-credentials" if true, "anonymous" if false or unspecified).

```php
// Example
return [
	'css' => [
		'stylesheet' => [
			'https://cdn.com/stylesheet.css',
			'hashKey'
		],
		'other-stylesheet' => [
			'https://other-cdn.com/stylesheet.css',
			'hashKey',
			true
		]
	],
	'js' => [
		'script' => [
			'https://cdn.com/script.js',
			'hashKey'
		],
		'other-script' => [
			'https://other-cdn.com/script.js',
			'hashKey',
			true
		]
	]
];
```