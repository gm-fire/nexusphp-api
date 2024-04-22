<?php

/*
 * This file is part of gm-fire/nexusphp-api.
 *
 * Copyright (c) 2024 Fire.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GmFire\\NexusphpApi;

use Flarum\Extend;

return [
    
    (new Extend\Frontend('admin'))
        
        
    new Extend\Locales(__DIR__.'/locale'),
];
