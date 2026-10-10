# DiscordWebhookAPI

DiscordWebhookAPI is a PocketMine-MP Virion for sending messages, embeds and link components to Discord webhooks from a plugin.

This repository is a ReinfyTeam-maintained fork of [CortexPE's DiscordWebhookAPI](https://github.com/CortexPE/DiscordWebhookAPI). The public namespace remains `CortexPE\DiscordWebhookAPI` for compatibility with existing consumers.

## Requirements

- PocketMine-MP API 5.
- PHP 8.2 or newer.
- PHP cURL extension enabled on the server and on the asynchronous worker runtime.
- A Discord webhook URL with permission to post to the target channel.

The library queues delivery through PocketMine-MP's asynchronous task pool. It does not provide a Discord bot client, interaction handler or delivery retry queue.

## Installation

Use the repository as a Virion dependency in the consumer plugin's build configuration. The consumer is responsible for packaging the library into its plugin PHAR and for providing the PocketMine-MP runtime.

The repository's `virion.yml` contains the Antigen metadata and namespace root. Build and validate the consumer with the current pinned DevTools configuration; the user-facing documentation intentionally refers to DevTools by name rather than copying a CI tool version.

The current source release is [2.0.1](https://github.com/ReinfyTeam/DiscordWebhookAPI/releases/tag/2.0.1). The release contains the library source and metadata; consumers remain responsible for bundling and validating the resulting plugin PHAR through their own Virion-compatible build pipeline. Do not use the historical Poggit link as evidence of a current build.

## Basic usage

```php
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;

$webhook = new Webhook('https://discord.com/api/webhooks/...');
$message = new Message();
$message->setUsername('My plugin');
$message->setContent('Hello from PocketMine-MP.');

$webhook->send($message);
```

`send()` schedules an asynchronous task and returns immediately. The task posts JSON to Discord and reports non-successful HTTP responses through the PocketMine-MP logger. A message must contain content or another Discord-supported payload component.

## Embeds

```php
use CortexPE\DiscordWebhookAPI\Embed;

$embed = new Embed();
$embed->setTitle('Build completed');
$embed->setDescription('The plugin was packaged successfully.');
$embed->setColor(0x2ECC71);

$message->addEmbed($embed);
$webhook->send($message);
```

The library also supports authors, footers, thumbnails, images, fields, timestamps and text-to-speech flags through the corresponding `Embed` and `Message` methods.

## Mentions

Use `AllowedMentions` when a message must restrict or suppress Discord mentions:

```php
$message->getAllowedMentions()->suppressAll();
// Or allow only specific users and roles.
$message->getAllowedMentions()->addUser('123456789012345678');
$message->getAllowedMentions()->addRole('234567890123456789');
```

## Components

`Component` currently supports link buttons. Component support is intentionally limited to the payloads implemented by this library; it is not a complete Discord interactions framework.

```php
use CortexPE\DiscordWebhookAPI\Component;

$component = new Component();
$component->addLinkButton('Open documentation', 'https://github.com/ReinfyTeam/DiscordWebhookAPI');
$message->addComponent($component);
```

## Development checks

From the repository root:

```text
composer validate --strict
composer install --no-interaction --no-progress
composer run format:check
composer run analyze
```

The build workflow belongs to the consumer plugin because this repository is a Virion library. Keep dependency pins and build-tool revisions in machine-readable project configuration so documentation does not become stale whenever the toolchain is updated.

## Attribution and license

This project preserves the original CortexPE implementation, attribution and public namespace. It also retains the original SynicadeNetwork notice in source headers where present.

DiscordWebhookAPI is available under the [GNU Lesser General Public License v3.0 or later](LICENSE). Contributions must preserve the upstream copyright notices, license obligations and compatibility expectations of existing consumers.

## Support

For a bug in the library, open an issue in [ReinfyTeam/DiscordWebhookAPI](https://github.com/ReinfyTeam/DiscordWebhookAPI). For Discord API behavior, webhook permissions or Discord service failures, consult the [Discord webhook documentation](https://discord.com/developers/docs/resources/webhook) and provide the HTTP status observed by the consumer.
