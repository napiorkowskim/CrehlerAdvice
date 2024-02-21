const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

import template from './crehler-advice-list.html.twig';

Component.register('crehler-advice-list', {
    template,

    inject: ['repositoryFactory'],

    mixins: [
        Mixin.getByName('listing'),
        Mixin.getByName('notification'),
        Mixin.getByName('placeholder')
    ],

    data() {
        return {
            repository: null,
            items: null,
            total: 0,
            sortBy: 'createdAt',
            sortDirection: 'ASC',
            naturalSorting: false,
            isLoading: false,
            showDeleteModal: false,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    computed: {
        entityRepository() {
            return this.repositoryFactory.create('crehler_advice');
        },

        columns() {
            return this.getColumns();
        },

        dateFilter() {
            return Shopware.Filter.getByName('date');
        },
    },

    methods: {
        getList() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            criteria.setTerm(this.term);
            criteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            this.entityRepository.search(criteria, Shopware.Context.api).then((items) => {
                this.total = items.total;
                this.items = items;
                this.isLoading = false;

                return items;
            }).catch(() => {
                this.isLoading = false;
            });
        },

        onDelete(id) {
            this.showDeleteModal = id;
        },

        onCloseDeleteModal() {
            this.showDeleteModal = false;
        },

        getColumns() {
            return [{
                property: 'name',
                routerLink: 'crehler.advice.detail',
                label: 'crehler-advice.list.columnName',
                width: '400px',
                allowResize: true,
                primary: true
            }, {
                property: 'createdAt',
                label: 'crehler-advice.list.columnCreatedAt',
                allowResize: true
            }, {
                property: 'updatedAt',
                label: 'crehler-advice.list.columnUpdatedAt',
                allowResize: true
            }]
        },

        onChangeLanguage(languageId) {
            Shopware.State.commit('context/setApiLanguageId', languageId);
            this.getList();
        },

        onColumnSort(column) {
            this.onSortColumn(column);
        },
    }
});