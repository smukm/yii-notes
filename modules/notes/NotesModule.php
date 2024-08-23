<?php

declare(strict_types=1);

namespace modules\notes;

use yii\base\BootstrapInterface;
use yii\base\Module;

class NotesModule extends Module implements BootstrapInterface
{

    public function bootstrap($app): void
    {
        $module = $this->id;

        // Add module I18N category.
        if (!isset($app->i18n->translations[$module]) && !isset($app->i18n->translations['modules/*'])) {
            $app->i18n->translations[$module] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@modules/' . $module . '/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'modules/' . $module => $module . '.php',
                ]
            ];
        }
    }
}