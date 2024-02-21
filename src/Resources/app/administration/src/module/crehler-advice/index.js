import './page/crehler-advice-list';
import './page/crehler-advice-detail';
import './page/crehler-advice-create';

import './blocks/commerce/advice';

import plPL from './snippet/pl-PL.json';
import enGB from './snippet/en-GB.json';

Shopware.Module.register('crehler-advice', {
    type: 'plugin',
    name: 'CrehlerAdvice',
    title: 'crehler-advice.general.mainMenuItemGeneral',
    description: 'crehler-advice.general.descriptionTextModule',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#9AA8B5',
    icon: 'regular-table',
    entity: 'crehler_advice',

    snippets: {
        'pl-PL': plPL,
        'en-GB': enGB
    },

    routes: {
        index: {
            component: 'crehler-advice-list',
            path: 'index',
            meta: {
                parentPath: 'sw.settings.index'
            }
        },
        detail: {
            component: 'crehler-advice-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'crehler.advice.index'
            }
        },
        create: {
            component: 'crehler-advice-create',
            path: 'create',
            meta: {
                parentPath: 'crehler.advice.index'
            }
        }
    },

    settingsItem: [
        {
            name:   'crehler-advice-index',
            to:     'crehler.advice.index',
            label:  'crehler-advice.general.mainMenuItemGeneral',
            group:  'plugins',
            icon:   'regular-table'
        }
    ]
});