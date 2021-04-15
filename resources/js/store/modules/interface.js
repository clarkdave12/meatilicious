export default {

    namespaced: true,

    state: {
        drawer: true,
        page: 'Dashboard'
    },

    getters: {
        getDrawer: state => state.drawer,

        getPage: state => state.page,
    },

    mutations: {

        setDrawer: state => state.drawer = !state.drawer,

        setPage: (state, page) => state.page = page,

    }
}
