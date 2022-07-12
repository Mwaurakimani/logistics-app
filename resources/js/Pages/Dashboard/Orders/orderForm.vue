<template>
    <h1 class="page-header">Orders</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_orders')" as="li">
                    <p>Order List</p>
                </Link>
                <li v-if="order" @click="update_order">
                    <p>Update</p>
                </li>
                <li v-else @click="create_order">
                    <p>save</p>
                </li>
                <Link v-if="order" :href="route('dashboard_orders_delivery_Details',[order.id])" as="li">
                    <p>Delivery</p>
                </Link>
            </ul>
        </div>
        <div class="search-section">
            <input type="text" placeholder="Search by ID...">
        </div>
    </div>

    <div class="user-form">
        <div class="form-section">
            <div class="user-details-section">
                <h5>User Details</h5>
                <order-display-form  :order_form="order_form_holder" :user="this.$attrs.user" />
            </div>
        </div>
        <div class="details-section-order">
            <div class="form-section">
                <div class="user-details-section">
                    <h5>Shipment Details</h5>

                    <div class="form-item">
                        <div class="input-group">
                            <label for="">Payment Status</label>
                            <select name="" id="" v-model="order_form_holder.payment_status">
                                <option value="Payment pending">Payment pending</option>
                                <option value="Payed">Payed</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="">Delivery Status</label>
                            <select name="" id="" v-model="order_form_holder.delivery_status">
                                <option value="Approval pending">Approval pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Dispatched">Dispatched</option>
                                <option value="Transit">Transit</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Fulfilled">Fulfilled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import orderDisplayForm from "./orderDisplayForm.vue";

export default {
    name: "index.vue",
    props:['order'],
    components: {
        orderDisplayForm
    },
    data() {
        return {
            order_form_holder: this.$inertia.form({
                customer_name: this.order ? this.order.customer_name : null,
                contact_name: this.order ? this.order.contact_name : null,
                contact_phone: this.order ? this.order.contact_phone : null,
                contact_address: this.order ? this.order.contact_address : null,
                user_id: this.$attrs.user.id,
                date_received: this.order ? this.order.date_received : null,
                proposed_delivery_date: this.order ? this.order.proposed_delivery_date : null,
                comments: this.order ? this.order.comments : null,
                lpo_number: this.order ? this.order.lpo_number : null,
                lpo_value: this.order ? this.order.lpo_value : null,
                payment_status: this.order ? this.order.payment_status : 'Payment pending',
                delivery_status: this.order ? this.order.delivery_status : 'Approval pending',
            })
        }
    },
    methods:{
        create_order(){
            this.order_form_holder.post(route('post_order'))
        },
        update_order(){
            this.order_form_holder.post(route('put_order',[this.order.id]))
        }
    },
    mounted() {
        console.log()
    }
}
</script>

<style lang='scss' scoped>

body {
  overflow: hidden;
}

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

.user-form {
  width: 98%;
  margin: auto;
  display: flex;
  justify-content: space-between;
  padding-bottom: 20px;

  .form-section {
    width: 70%;

    .user-details-section {
      width: 100%;
      background-color: white;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 3px 6px grey;

    }
  }

  .details-section-order {
    width: calc(100% - 70% - 10px);

    .form-section {
      width: 100%;

      .form-item {
        padding: 0;
        margin-top: 10px;


        .input-group {
          margin-bottom: 30px;
          width: 100%;

          label {
            margin-bottom: 5px;
          }

          select {
            padding: 0px;
            padding-left: 5px;
            width: 240px;
            height: 25px;
            border: 1px solid #B7B7B7;
          }
        }
      }
    }
  }
}
</style>