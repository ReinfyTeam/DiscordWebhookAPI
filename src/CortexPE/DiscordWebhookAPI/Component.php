<?php

/**
 *
 *  _____      __    _   ___ ___
 * |   \ \    / /__ /_\ | _ \_ _|
 * | |) \ \/\/ /___/ _ \|  _/| |
 * |___/ \_/\_/   /_/ \_\_| |___|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * Written by @CortexPE <https://CortexPE.xyz>
 * Intended for use on SynicadeNetwork <https://synicade.com>
 */

declare(strict_types=1);

namespace CortexPE\DiscordWebhookAPI;

/**
 * TODO:
 * - Add Buttons instead only for links.
 * - Discord Button Interact -> Plugin Action if needed.
 * - Button Colors for not discord button link.
 */
class Component implements \JsonSerializable
{
    /** @var array{type?: int, components?: array{type?: int, label?: string, url?: string}} */
    protected $data = [];

    /** @return array<string, mixed> */
    public function asArray(): array
    {
        // Why doesn't PHP have a `__toArray()` magic method??? This would've been better.
        return $this->data;
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }

    /**
     * Add Link Button from the message.
     * @param string $text
     * @param string $link
     */
    public function addLinkButton(string $text, string $link): void
    {
        if (!isset($this->data["type"])) {
            $this->data["type"] = 1; // container for other components
        }
        if (!isset($this->data["components"])) {
            $this->data["components"] = [];
        }

        $this->data["components"]["type"] = 5;
        $this->data["components"]["label"] = $text;
        $this->data["components"]["url"] = $link;
    }
}
