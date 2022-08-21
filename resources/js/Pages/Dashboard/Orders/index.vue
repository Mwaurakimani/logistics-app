<template>
    <h1 class="page-header">Orders</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link v-if="['Admin','Sales'].includes($attrs.user.account_type)" :href="route('dashboard_add_order')" as="li">
                    <p class="rep-btn">Add Order</p>
                </Link>
            </ul>
        </div>
        <div class="search-section">
            <input
                type="text"
                placeholder="Search by ID..."
                v-model="filterData.search_by_ID">
        </div>
    </div>

    <div v-if="display_table" class="filter-bar">
        <div class="filters">
            <div class="input-group">
                <label for="">Date Created</label>
                <input type="date" v-model="filterData.date_created">
            </div>

            <div class="input-group">
                <label for="">Status</label>
                <select name="" id="" v-model="filterData.status">
                    <option value="All">All</option>
                    <option value="Fulfilled">Fulfilled</option>
                </select>
            </div>
        </div>
        <div class="actions">
            <button v-if="filterData.filters_applies" @click="clear_filters">Clear Filters</button>
            <button @click="filter_orders">Apply Filters</button>
        </div>
    </div>

    <div v-if="display_table" class="table-section">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Sales Rep</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Delivery Date</th>
                    <th scope="col">Procurement Status</th>
                    <th scope="col">Finance Status</th>
                    <th scope="col">Delivery Status</th>
                </tr>
            </thead>
            <tbody>
                <Link as="tr" v-for="(order,index) of orders.data" :href="route('dashboard_select_order',[order.id])">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ order.id }}</td>
                    <td>{{ order.user_id }}</td>
                    <td>{{ order.customer_name }}</td>
                    <td>{{ order.created_at }}</td>
                    <td>{{ order.proposed_delivery_date }}</td>
                    <td>{{ order.procurements ? order.procurements.status : '-' }}</td>
                    <td>{{ order.finance ? order.finance.status : '-' }}</td>
                    <td>{{ order.delivery_status }}</td>
                </Link>
            </tbody>
        </table>

        <div class="flex align-middle justify-center pb-[10px] text-red-500">
            <Pagination :data="orders" @pagination-change-page="getResults" />
        </div>

    </div>

    <div v-else class="no_orders_found">
        <p>No orders found...</p>
    </div>

</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
import {mapMutations, mapState} from "vuex";
import {isStringNullOrWhiteSpace} from "../../../functions";


export default {
    name: "index.vue",
    props: ['orders'],
    components:{
      'Pagination':LaravelVuePagination
    },
    computed: {
        display_table() {
            if ( this.orders != null && this.orders != 'undefined' && Object.keys(this.orders).length > 0) {
                return true;
            }else {
                return  false;
            }
        },
        ...mapState({
            filterData: state => state.ordersModule,
        })
},

    methods:{
        filter_orders(){
            this.$store.state.ordersModule.filters_applies = true;
            this.getResults();
        },
        clear_filters(){
            this.$store.state.ordersModule.date_created = null;
            this.$store.state.ordersModule.filters_applies = false;
            this.$store.state.ordersModule.search_by_ID = null;
            this.$store.state.ordersModule.status = 'All';

            this.getResults();
        },
        getResults(page = 1) {
            let form_data = this.$inertia.form(this.filterData);

            form_data.post(route('dashboard_orders')+'?page=' + page)
        },
        get_path_name(text){
            let el = document.createElement("a");
            el.href = text;
            return el.pathname;
        },
    },

}
</script>

<style lang='scss' scoped>

.action-bar {
  width: 100%;
  height: 45px;
  background-color: white;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0px 10px;

  .button-section {
    width: 300px;
    height: 100%;

    ul {
      display: flex;
      align-items: center;
      height: 100%;

      li {
        background-color: red;
        width: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        border-radius: 5px;

        p {
          width: auto;
          height: auto;
          color: white;
          padding: 5px 8px;
          font-size: 0.95em;
        }
      }
    }
  }

  .search-section {
    width: 300px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    input {
      height: 32px;
      border-radius: 8px;
    }
  }
}

.table-section {
  margin: auto;
  width: 98%;
  box-shadow: 0 0 6px grey;
  background-color: white;

  thead {
    background-color: red;
    color: white;

    tr:first-of-type {
      border-left: none;
    }

    th {
    }
  }

  tbody {
    tr {
      cursor: pointer;
    }
  }
}

.no_orders_found {
  width: 98%;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  box-shadow: 0 0 6px #9F9696;
  margin-bottom: 10px;

}

.filter-bar{
  width: 98%;
  margin:auto;
  height: 50px;
  background-color: white;
  margin-bottom: 10px;
  box-shadow: 0 0 3px lightgrey;
  display: flex;
  align-items: center;
  justify-content: space-between;

  .filters{
    width: 550px;
    height: 100%;
    display: flex;


    .input-group{
      height: 100%;
      display: flex;
      align-items: center;
      margin-right: 5px;
      label{
        margin-left: 10px;
        margin-right: 10px;
      }

      select, input{
        display: block;
        height: 30px;
        padding: 5px;
        width: 150px;
        margin-left: 4px;
        border-radius: 8px !important;
      }
    }
  }
  .actions{
    width: 250px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    margin-right: 5px;
    button{
      background-color: red;
      height: 30px;
      line-height: 30px;
      color: white;
      padding: 0 10px;
      border-radius: 8px;

    }
  }
}


</style>
