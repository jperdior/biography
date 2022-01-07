import ProductApi from '../api/product.js';

const GETTING_PRODUCTS = 'GETTING_PRODUCTS',
    GETTING_PRODUCTS_SUCCESS = 'GETTING_PRODUCTS_SUCCESS',
    GETTING_PRODUCTS_ERROR = 'GETTING_PRODUCTS_ERROR',
    GETTING_MAINTENANCE_PRODUCT = 'GETTING_MAINTENANCE_PRODUCT',
    GETTING_MAINTENANCE_PRODUCT_SUCCESS = 'GETTING_MAINTENANCE_PRODUCT_SUCCESS',
    GETTING_MAINTENANCE_PRODUCT_ERROR = 'GETTING_MAINTENANCE_PRODUCT_ERROR',
    GETTING_ECOMMERCE_LABELS = 'GETTING_ECOMMERCE_LABELS',
    GETTING_ECOMMERCE_LABELS_SUCCESS = 'GETTING_ECOMMERCE_LABELS_SUCCESS',
    GETTING_ECOMMERCE_LABELS_ERROR = 'GETTING_ECOMMERCE_LABELS_ERROR';

export default {
    namespaced: true,
    state: {
        products: [],
        labels: {},
        maintenanceProduct: null,
        loading: false,
        error: null
    },
    getters: {
        products: state => state.products,
        loading: state => state.loading,
        error: state => state.error,
        productLabels: state => state.labels,
        maintenanceProduct: state => state.maintenanceProduct
    },
    mutations: {
        [GETTING_PRODUCTS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_PRODUCTS_SUCCESS](state, products) {
            state.loading = false;
            state.products = products.data;
        },
        [GETTING_PRODUCTS_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_MAINTENANCE_PRODUCT](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_MAINTENANCE_PRODUCT_SUCCESS](state, product) {
            state.loading = false;
            state.maintenanceProduct = product.data;
        },
        [GETTING_MAINTENANCE_PRODUCT_ERROR](state, error) {
            state.loading = false;
            state.error = error;
        },
        [GETTING_ECOMMERCE_LABELS](state) {
            state.loading = true;
            state.error = null;
        },
        [GETTING_ECOMMERCE_LABELS_SUCCESS](state, labels) {
            state.loading = false;
            state.labels = labels.data;
        }
    },
    actions: {
        async getProducts({ commit }) {
            commit(GETTING_PRODUCTS);
            try {
                const products = await ProductApi.getProducts();
                commit(GETTING_PRODUCTS_SUCCESS, products);
            } catch (error) {
                commit(GETTING_PRODUCTS_ERROR, error);
            }
        },
        async getMaintenanceProduct({ commit }) {
            commit(GETTING_MAINTENANCE_PRODUCT);
            try {
                const products = await ProductApi.getMaintenanceProduct();
                commit(GETTING_MAINTENANCE_PRODUCT_SUCCESS, products);
            } catch (error) {
                commit(GETTING_MAINTENANCE_PRODUCT_ERROR, error);
            }
        },
        async getEcommerceLabels({ commit }) {
            commit(GETTING_ECOMMERCE_LABELS);
            try {
                const labels = await ProductApi.getEcommerceLabels();
                commit(GETTING_ECOMMERCE_LABELS_SUCCESS, labels);
            } catch (error) {
                commit(GETTING_ECOMMERCE_LABELS_ERROR, error);
            }
        },

    }
};
