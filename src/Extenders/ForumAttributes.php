<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\NexusphpApi\Extenders;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;

class ForumAttributes
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    public function __construct(Translator $translator, SettingsRepositoryInterface $settings)
    {
        $this->translator = $translator;
        $this->settings = $settings;
    }

    public function __invoke(ForumSerializer $serializer): array
    {
        $attributes['gm-fire-nexusphp-api.apiurl'] = $this->settings->get('gm-fire-nexusphp-api.apiurl') ?: '';
        $attributes['gm-fire-nexusphp-api.secret'] = $this->settings->get('gm-fire-nexusphp-api.secret') ?: '';
        $attributes['gm-fire-nexusphp-api.seedbonusOpen'] = $this->settings->get('gm-fire-nexusphp-api.seedbonus_open') ?: false;
        $attributes['gm-fire-nexusphp-api.seedbonusLabel'] = $this->settings->get('gm-fire-nexusphp-api.seedbonus_label') ?: $this->translator->trans('gm-fire-nexusphp-api.ref.seedbonus_label');

        return $attributes;
    }
}
