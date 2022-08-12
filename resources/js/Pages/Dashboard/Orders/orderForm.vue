<template>
    <h1 class="page-header">Orders</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_orders')" as="li" class="rep-btn">
                    <p>Order List</p>
                </Link>
                <li v-if="order" @click="update_order" class="rep-btn">
                    <p>Update</p>
                </li>
                <li v-else @click="create_order" class="rep-btn">
                    <p>save</p>
                </li>
                <Link v-if="order" :href="route('dashboard_orders_delivery_Details',[order.id])" as="li"
                      class="rep-btn">
                    <p>Delivery</p>
                </Link>
            </ul>
        </div>
    </div>

    <div class="user-form">
        <div class="form-section">
            <div class="user-details-section">
                <h5>Order Details</h5>
                <order-display-form :order_form="order_form_holder" :user="this.$attrs.user" :errors="errors"/>
            </div>
            <div v-if="order" class="user-details-section">
                <h5>Procurement Details</h5>
                <procurement-form :order_details="order" :procurement="procurement" :user="this.$attrs.user"/>
            </div>
            <div v-if="order" class="user-details-section">
                <h5>Finance Details</h5>
                <finance-form :order_form="order" :finance="finance" :user="this.$attrs.user"/>
            </div>
        </div>
<!--        <div class="details-section-order">-->
<!--            <div class="form-section">-->
<!--                <div class="user-details-section">-->
<!--                    <h5>Shipment Details</h5>-->

<!--                    <div class="form-item">-->
<!--                        <div class="input-group">-->
<!--                            <label for="">Payment Status</label>-->
<!--                            <select name="" id="" v-model="order_form_holder.payment_status">-->
<!--                                <option value="Payment pending">Payment pending</option>-->
<!--                                <option value="Payed">Payed</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="input-group">-->
<!--                            <label for="">Delivery Status</label>-->
<!--                            <select name="" id="" v-model="order_form_holder.delivery_status">-->
<!--                                <option value="Approval pending">Approval pending</option>-->
<!--                                <option value="Approved">Approved</option>-->
<!--                                <option value="Dispatched">Dispatched</option>-->
<!--                                <option value="Transit">Transit</option>-->
<!--                                <option value="Delivered">Delivered</option>-->
<!--                                <option value="Fulfilled">Fulfilled</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
import orderDisplayForm from "./Form/orderDisplayForm.vue";
import procurementForm from "./modules/procurementModule/procurementForm.vue";
import financeForm from "./modules/financeModule/financeForm.vue";

export default {
    name: "index.vue",
    props: ['order', 'procurement', 'finance'],
    components: {
        orderDisplayForm,
        procurementForm,
        financeForm
    },
    computed: {
        computed_table_section() {
            return null
        }
    },
    data() {
        return {
            order_form_holder: this.$inertia.form({
                customer_name: this.order ? this.order.customer_name : null,
                contact_name: this.order ? this.order.contact_name : null,
                contact_phone: this.order ? this.order.contact_phone : null,
                contact_address: this.order ? this.order.contact_address : null,
                user_id: this.$attrs.user.username,
                proposed_delivery_date: this.order ? this.order.proposed_delivery_date : null,
                comments: this.order ? this.order.comments : null,
                lpo_number: this.order ? this.order.lpo_number : null,
                lpo_value: this.order ? this.order.lpo_value : null,
                payment_status: this.order ? this.order.payment_status : 'Payment pending',
                delivery_status: this.order ? this.order.delivery_status : 'Approval pending',
                tb: null
            }),
            errors: this.$attrs.errors
        }
    },
    methods: {
        create_order() {
            let table_data = this.extract_items()

            this.order_form_holder.post(route('post_order'),{
                data_table: table_data
            })
        },
        update_order() {
            this.order_form_holder.tb = this.extract_items()

            this.order_form_holder.post(route('put_order', [this.order.id]))
        },
        extract_items() {
            let table = $('#items_table');

            let rows = table.find('tbody tr');
            let items = []

            rows.each((index, obj) => {
                let tr = $(obj);

                let data_cells = tr.children();

                let row = {
                    name:  $(data_cells[0]).children()[0].value,
                    quantity: $(data_cells[1]).children()[0].value,
                    each: $(data_cells[2]).children()[0].value,
                    sub_total:  $(data_cells[3]).children()[0].value
                }

                items.push(row)
            });

            return items
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
