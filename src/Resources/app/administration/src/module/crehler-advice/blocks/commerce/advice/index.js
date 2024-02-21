import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'advice',
    category: 'commerce',
    label: 'Advice',
    component: 'sw-cms-block-advice',
    previewComponent: 'sw-cms-preview-advice',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        left: {
            type: 'text',
            default: {
                config: {
                    content: {
                        source: 'static',
                        value: `
                        <div>Advice</div>
                        `.trim(),
                    },
                },
            },
        },
    }
});