<template>
    <h1 class="page-header">Orders</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_orders')" as="li" class="rep-btn">
                    <p>Order List</p>
                </Link>
                <Link :href="route('dashboard_select_order',[order])" as="li" class="rep-btn">
                    <p>Order</p>
                </Link>
                <li v-if="delivery.length > 0" @click="update_delivery" class="rep-btn">
                    <p>Update Delivery</p>
                </li>
            </ul>
        </div>
    </div>
    <delivery-form
            v-if="delivery.length > 0"
            :tracking_code="delivery[0].id"
            :delivery="this.delivery_form"
            :stages="stages"
            :Vehicles="Vehicles"
            :comment="comment"
            :errors="errors.errors"
    />
    <div v-else class="no_delivery">
        <p>No delivery available</p>
        <button @click="create_delivery">Create Delivery</button>
    </div>
</template>

<script>
import DeliveryForm from "./Form/DeliveryForm.vue";

export default {
    name: "deliveryDetails",
    props: ['delivery', 'order', 'stages', 'Vehicles'],
    components: {DeliveryForm},
    data() {
        return {
            delivery_form: this.$inertia.form({
                handled_by: this.delivery.length > 0 ? this.delivery[0].handled_by : null,
                dispatched_from: this.delivery.length > 0 ? this.delivery[0].dispatched_from : null,
                dispatch_date: this.delivery.length > 0 ? this.delivery[0].dispatch_date : null,
                region: this.delivery.length > 0 ? this.delivery[0].region : null,
                transit_position: this.delivery.length > 0 ? this.delivery[0].transit_position : 'None',
                comment: this.delivery.length > 0 ? this.delivery[0].comment : 'No Comment',
                vehicle: this.delivery.length > 0 ? this.delivery[0].vehicle_id : 'None',
                estimated_time_of_arrival: this.delivery.length > 0 ? this.delivery[0].estimated_time_of_arrival : null,
            }),
            errors:this.$attrs
        }
    },
    methods: {
        create_delivery() {
            this.$inertia.post(route('generate_order', [this.order]))
        },
        update_delivery() {
            this.delivery_form.put(route('update_delivery', {
                Order: this.order,
                Delivery: this.delivery[0].id
            }));
        }
    },
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

.no_delivery {
  width: 98%;
  margin: auto;
  height: 200px;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: space-around;
  flex-direction: column;

  button {
    background-color: red;
    padding: 5px 10px;
    color: white;
    border-radius: 8px;
  }
}
</style>
