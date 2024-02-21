const { Component, Mixin, State } = Shopware;

import template from './crehler-advice-detail.html.twig';

Component.register('crehler-advice-detail', {
    template,

    inject: ['repositoryFactory', 'context'],

    mixins: [
        Mixin.getByName('notification'),
        Mixin.getByName('placeholder')
    ],

    data() {
        return {
            item: {},
            isLoading: false,
            isSaveSuccessful: false
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier)
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.item, 'id');
        },

        entityName() {
            return this.placeholder(
                this.item,
                'name',
                this.$tc('crehler-advice.detail.placeholderNew'),
            );
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.repository = this.repositoryFactory.create('crehler_advice');
            this.getEntity();
        },

        getEntity() {
            this.repository
                .get(this.$route.params.id, Shopware.Context.api)
                .then((entity) => {
                    this.item = entity;
                });
        },

        saveFinish() {
            this.isSaveSuccessful = false;
        },

        onSave() {
            const titleSaveError = this.$tc('crehler-advice.detail.notificationSaveErrorTitle');
            const messageSaveError = this.$tc(
                'crehler-advice.detail.notificationSaveErrorMessage', 0, { name: this.item.name }
            );
            const titleSaveSuccess = this.$tc('crehler-advice.detail.notificationSaveSuccessTitle');
            const messageSaveSuccess = this.$tc(
                'crehler-advice.detail.notificationSaveSuccessMessage', 0, { name: this.item.name }
            );

            this.isSaveSuccessful = false;
            this.isLoading = true;

            return this.repository.save(this.item, Shopware.Context.api).then(() => {
                this.createNotificationSuccess({
                    title: titleSaveSuccess,
                    message: messageSaveSuccess
                });

                this.isLoading = false;
                this.isSaveSuccessful = true;
            }).catch((exception) => {
                this.createNotificationError({
                    title: titleSaveError,
                    message: messageSaveError
                });
                this.isLoading = false;
                throw exception;
            });
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        abortOnLanguageChange() {
            return this.repository.hasChanges(this.item);
        },

        onChangeLanguage(languageId) {
            State.commit('context/setApiLanguageId', languageId);
            this.createdComponent();
        },
    }
});