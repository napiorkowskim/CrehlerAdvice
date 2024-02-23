const { Component } = Shopware;
const utils = Shopware.Utils;


Component.extend('crehler-advice-create', 'crehler-advice-detail', {

    beforeRouteEnter(to, from, next) {
        if (to.name.includes('crehler.advice.create') && !to.params.id) {
            to.params.id = utils.createId();
        }

        next();
    },

    methods: {
        createdComponent() {
            if (!Shopware.State.getters['context/isSystemDefaultLanguage']) {
                Shopware.State.commit('context/resetLanguageToDefault');
            }

            this.$super('createdComponent');
        },

        getEntity() {
            this.item = this.repository.create(Shopware.Context.api);
        },

        saveFinish() {
            this.isSaveSuccessful = false;
            this.$router.push({ name: 'crehler.advice.detail', params: { id: this.item.id } });
        },

        onSave() {
            this.$super('onSave');
        }
    }
});