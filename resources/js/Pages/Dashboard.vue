<template>
    <h1 class="page-header">Dashboard</h1>

    <div class="top-section">
        <Link as="div" :href="route('dashboard_ordersReceived')" id="orders-received" class="card-holder rep-btn">
            <h6>Orders Received</h6>
            <div class="domain-holder">
                <div class="icon-holder">
                    <img src="/storage/icons/cart1.png" alt="">
                </div>
                <h4>{{ top_data.orders_received.length }}</h4>
            </div>
            <p>This Month</p>
        </Link>
        <Link as="div" :href="route('dashboard_ordersFulfilled')" id="total-deliveries" class="card-holder rep-btn">
            <h6>Orders Fulfilled</h6>
            <div class="domain-holder">
                <div class="icon-holder">
                    <img src="/storage/icons/tag.png" alt="">
                </div>
                <h4>{{ top_data.orders_fulfilled.length }}</h4>
            </div>
            <p>This Month</p>
        </Link>
        <Link as="div" :href="route('dashboard_ordersPending')" id="pending-deliveries" class="card-holder rep-btn">
            <h6>Orders Pending</h6>
            <div class="domain-holder">
                <div class="icon-holder">
                    <img src="/storage/icons/pending.png" alt="">
                </div>
                <h4>{{ top_data.orders_pending.length }}</h4>
            </div>
            <p>This Month</p>
        </Link>
        <Link as="div" :href="route('dashboard_issues')" id="issues" class="card-holder rep-btn">
            <h6>Issues</h6>
            <div class="domain-holder">
                <div class="icon-holder">
                    <img src="/storage/icons/alert.png" alt="">
                </div>
                <h4>{{ top_data.issues.length }}</h4>
            </div>
            <p>This Month</p>
        </Link>
    </div>

    <div v-if="!['Sales'].includes($attrs.user.account_type)" class="chart-section">
        <div class="line-chart">
            <h4>Statistics</h4>
                <div id="area-chart" class="chart-area">

                </div>
        </div>
        <div class="doughnut-chart">
            <h4>Statistics</h4>
            <div class="chart-holder">
                <div id="doughnut-chart" class="chart-area">

                </div>
            </div>
        </div>
    </div>

    <h2 v-if="['Admin','Sales'].includes($attrs.user.account_type)" >Order Section</h2>

    <div v-if="['Admin','Sales'].includes($attrs.user.account_type)" class="sales-rep-section">
        <div class="order-list">
            <div class="search-section">
                <input type="text" placeholder="Search by order id" @keyup="search_order">
            </div>
            <ul>
                <li v-for="order in recent_data" @click="changing_form_data(order.id)">
                    <p><span>Order ID : </span> {{ order.id }}</p>
                    <p><span>LPO No. :</span> {{ order.lpo_number }}</p>
                </li>
            </ul>
        </div>
        <div class="order-form-holder">
            <div class="header-tag">
                <h4>Order Form</h4>
            </div>
            <div class="order-form">
                <order-display-form
                    :order_form="order_form_holder"
                    :procurement = "procurement"
                    :key="this.order_data.id ?? 1"
                    :errors="errors"
                    :user="$attrs.user"
                    :mode="'dashboard'"
                ></order-display-form>
                <div class="action-section">
                    <button v-if="order_form_holder && order_form_holder.id !=  null" @click="update_order(order_data.id)" >Update</button>
                    <button v-else @click="create_order">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import orderDisplayForm from "./Dashboard/Orders/Form/orderDisplayForm.vue";
import { get_order_by_id } from "../Helpers/functions";

export default {
    name:'DashboardIndex',
    props:{
        order:{
            type: Object,
            default: null
        },
        recent_orders:{
          type: Object,
          default: null
      },
        top_data:{
            type: Object,
            default:{
                orders_received: [],
                orders_fulfilled: [],
                orders_pending: [],
                issues: []
            }
        },
        bar_chart_data:{
            type:Object
        }
    },
    components: {
        orderDisplayForm
    },
    data(){
        return {
            order_data: {...this.order},
            order_form_holder: this.$inertia.form({
                id:this.order_data ? this.order_data : null,
                customer_name: this.order_data ? this.order_data.customer_name : null,
                contact_name: this.order_data ? this.order_data.contact_name : null,
                contact_phone: this.order_data ? this.order_data.contact_phone : null,
                contact_address: this.order_data ? this.order_data.contact_address : null,
                user_id: this.$attrs.user.username,
                proposed_delivery_date: this.order_data ? this.order_data.proposed_delivery_date : null,
                comments: this.order_data ? this.order_data.comments : null,
                lpo_number: this.order_data ? this.order_data.lpo_number : null,
                lpo_value: this.order_data ? this.order_data.lpo_value : null,
                payment_status: this.order_data ? this.order_data.payment_status : 'Payment pending',
                delivery_status: this.order_data ? this.order_data.delivery_status : 'Approval pending',
                tb: null,
                opfFile:null
            }),
            recent_data: {...this.recent_orders},
            procurement:null,
            errors:this.$attrs.errors
        }
    },
    methods:{
        drawChart1() {
            var data = google.visualization.arrayToDataTable(this.bar_chart_data);

            var options = {
                chart: {
                    title: '',
                    subtitle: '',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('area-chart'));
            chart.draw(data, options);
        },
        drawChart2() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Fullfiled',      this.top_data.orders_fulfilled.length],
                ['Pending',     this.top_data.orders_pending.length],
            ]);

            var options = {
                // title: 'My Daily Activities',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('doughnut-chart'));
            chart.draw(data, options);
        },

        create_order(){
            this.order_form_holder.post(route('post_order'))
        },

        update_order(id){
            this.order_form_holder.post(route('put_order',id))
        },

        search_order(){
            let value = $(event.currentTarget).val();
            value = value.trim();

            if ( value !== '' && value !== 'undefined' ){
                axios.post(route('dashboard_search_order_by_id'),{
                    id:value
                }).then((response) => {
                    if ( response.data.length ){
                        this.recent_data = response.data
                    }else {
                        this.recent_data = []
                    }
                });
            } else {
                axios.post(route('dashboard_search_order_by_id'),{
                    id:null
                }).then((response) => {
                    if ( response.data.length ){
                        this.recent_data = response.data
                    }else {
                        this.recent_data = []
                    }
                });
            }
        },

        changing_form_data(value){
            axios.post(route('dashboard_change_form'),{
                id:value
            }).then((response) => {
                this.order_data = response.data
                this.procurement = [response.data.procurements]
                response.data.user_id = this.$attrs.user.username
                this.order_form_holder = {...this.order_form_holder,...response.data};
            });
        }
    },
    mounted() {
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(this.drawChart1);

        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(this.drawChart2);
    }
}
</script>

<style lang="scss" scoped>
body{
    overflow: hidden;
}

.top-section{
  width: 98%;
  margin:auto;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: space-between;


  .card-holder{
    width: 250px;
    height: 150px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 0 6px #E0DEDE;

    h6{
      color: white;
      padding: 25px 10px 3px;
    }

    .domain-holder{
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0px 10px;

      .icon-holder{
        width: 35px;
        height: 35px;
      }

      h4{
        font-size: 1.6em;
        color: white;
        font-weight: bolder;
      }
    }
    &>p{
      color: white;
      padding: 10px;
    }

  }

  #orders-received{
    background-image: linear-gradient(90deg, #00A6FF, #85D9EC);
  }

  #total-deliveries{
    background-image: linear-gradient(90deg, #1BE736, #99FF00);
  }
  #pending-deliveries{
    background-image: linear-gradient(90deg, #FF4D00, #FF8800);
  }
  #issues{
    background-image: linear-gradient(90deg, #F10F0F, #F35D50);
  }
}
.chart-section{
  width: 98%;
  margin: auto;
  height: 350px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;

  &>div{
    h4{
      padding: 10px;
      font-weight: bolder;
      font-size: larger;
    }
  }

  .line-chart{
    width: 70%;
    height: 100%;
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    .chart-area{
      width: 100%;
      height: calc(100% - 45px);
    }
  }
  .doughnut-chart{
    width: 28%;
    height: 100%;
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    .chart-holder{
      height: 200px;
      width: 100%;
      background-color: chocolate;
      .chart-area{
        width: 100%;
        height: 100%;
        background-color: pink;
      }
    }
  }
}

h2{
  padding: 20px;
  font-weight: bolder;
  font-size: 1.3em;
  background-color: white;
  margin-bottom: 10px;
}

.sales-rep-section{
  width: 98%;
  margin: auto;
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  .order-list{
    width: 28%;
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    height: fit-content;

    .search-section{
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      border-bottom: 1px solid #D2D1D1;

      input{
        width: 100%;
        height: 30px;
        padding: 3px 5px;
        border-radius: 15px;
        border-color: #DCDCDC;
      }
    }

    ul{
      li{
        width: 100%;
        border-bottom: 1px solid #E5E5E5;
        p{
          padding: 3px 0px 3px 10px;
        }
        &:hover{
          cursor: pointer;
          background-color: red;
          color: white;
        }

      }
    }

  };

  .order-form-holder{
    height: fit-content;
    width: calc(100% - 30%);
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    h4{
      width: 100%;
      height: 50px;
      line-height: 40px;
      padding-left: 20px;
      border-bottom: 1px solid #D2D1D1;
    }

    .order-form{
      padding: 10px;
    }

    .action-section{
      margin-top: 15px;
      width: 100%;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      button{
        padding: 8px 15px;
        background-color: red;
        color: white;
        border-radius: 8px;
      }
    }
  }
}

.top-section{
    .card-holder{
        transition: all 150ms ease-in;
        &:hover{
            transform: scale(108%);
        }
        &:active{
            transform: scale(90%);
        }
    }
}
</style>
