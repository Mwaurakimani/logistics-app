const ordersModule = {
    state: () => {
        return {
            search_by_ID: null,
            date_created: null,
            status: 'All',
            filters_applies: false
        }
    },
    // mutations: {
    //     update_order_search_by_ID(state, payload) {
    //         state.search_by_ID = payload
    //     },
    //     update_order_date_created(state, payload) {
    //         state.date_created = payload
    //     },
    //     update_order_status(state, payload) {
    //         state.status = payload
    //     },
    //     update_order_filter_applies(state, payload) {
    //         state.filters_applies = payload
    //     }
    // }
}

export default ordersModule;
