# htmler

A PHP library for building HTML formatted emails.

## Installation

Add this to your `composer.json`. See [the releases on this repository](https://github.com/Brainlabs-Digital/htmler/releases) for the latest version.

```
{
	"require": {
		"brainlabs/htmler": vX.X.X,
	},

	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/Brainlabs-Digital/htmler"
		}
	]
}
```

## Usage

See `tests` for full usage.

### Example

#### Code

```php
$renderer = new Renderer(
	StyleSheet::standard('Blue')
);

$doc = new Document();
$doc->addChild(
	new Table([[1, 2], [3, 4]], ['Foo', 'Bar'])
);

$html = $renderer->render($doc);
```

#### HTML

```html
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
    <body style="font-family: arial; font-size: 16px;">
        <table style="margin-left: 40px; border-collapse: collapse; border: 2px solid #009fe3;">
            <tr style="background-color: aliceblue;">
                <th style="text-align: left; color: white; background-color: #009fe3; padding: 10px;">Foo</th>
                <th style="text-align: left; color: white; background-color: #009fe3; padding: 10px;">Bar</th>
            </tr>
            <tr style="background-color: white;">
                <td style="padding: 10px; text-align: left;">1</td>
                <td style="padding: 10px; text-align: left;">2</td>
            </tr>
            <tr style="background-color: aliceblue;">
                <td style="padding: 10px; text-align: left;">3</td>
                <td style="padding: 10px; text-align: left;">4</td>
            </tr>
        </table>
    </body>
</html>
```

## Development

### Unit tests

Run `make unit`.

If you have [XDebug](https://xdebug.org/) installed, run `make unit-coverage` to also generate a code coverage report.

### Linting

Run [Phan](https://github.com/phan/phan) with `make phan`, and [CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with `make phpcs`.

## Contributing

See the [contribution guide](CONTRIBUTING.md).

## Versioning

See [SemVer](http://semver.org/) for versioning. For the versions available, see the [releases on this repository](https://github.com/Brainlabs-Digital/htmler/releases). 
