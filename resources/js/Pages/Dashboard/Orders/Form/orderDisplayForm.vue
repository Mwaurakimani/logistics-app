<template>
    <form action="">
        <div class="header-section">
            <section class="customer-section">
                <h4>Customer Details</h4>
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">Name:</label>
                        <input type="text" v-model="order_form.customer_name">
                        <span v-if="errors.customer_name" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.customer_name }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Contact Name:</label>
                        <input type="text" v-model="order_form.contact_name">
                        <span v-if="errors.contact_name" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.contact_name }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Tel:</label>
                        <input type="tel" v-model="order_form.contact_phone">
                        <span v-if="errors.contact_phone" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.contact_phone }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Address:</label>
                        <textarea v-model="order_form.contact_address"></textarea>
                    </div>
                </div>
            </section>
            <section class="sales-rep-section">
                <div class="sales-section">
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Sales Rep:</label>
                            <input style="border:none" type="text" v-model="order_form.user_id">
                        </div>
                    </div>
                </div>
                <div class="delivery-section">
                    <h4>Delivery Details</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Proposed DD:</label>
                            <input type="date" v-model="order_form.proposed_delivery_date">
                            <span v-if="errors.proposed_delivery_date" class="form_error text-left"
                                  style="margin-left: 120px">{{ errors.proposed_delivery_date }}</span>
                        </div>
                    </div>
                </div>
                <div class="payment-section">
                    <h4>Payment</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">LPO number</label>
                            <input type="text" v-model="order_form.lpo_number">
                            <span v-if="errors.lpo_number" class="form_error text-left"
                                  style="margin-left: 120px">{{ errors.lpo_number }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">LPO value</label>
                            <input type="text" v-model="order_form.lpo_value">
                            <span v-if="errors.lpo_value" class="form_error text-left"
                                  style="margin-left: 120px">{{ errors.lpo_value }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="footer-section">
            <div class="comments-section">
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">Comment:</label>
                        <textarea v-model="order_form.comments"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </form>
</template>

<script>
export default {
    name: "orderDisplayForm",
    props: ['order_form', 'user', 'errors'],
    mounted() {
        console.log(this.errors)
    }
}
</script>

<style lang='scss' scoped>

h4 {
    font-weight: 500;
    font-size: 1.1em;
    margin-bottom: 10px;
}

.mini-form {
    margin-left: 15px;
    width: 100%;

    .input-group {
        width: 100%;
        margin-bottom: 6px;

        label {
            width: 110px;
        }

        input, select {
            width: 240px;
            height: 25px;
            border: 1px solid #B7B7B7;
        }

        textarea {
            width: 240px;
            border: 1px solid #B7B7B7;
        }
    }
}

form {
    margin-top: 10px;
    width: 100%;
    height: 100%;
    //border: 1px solid grey;
}

//layout
.header-section {
    width: 100%;
    display: flex;
    justify-content: space-between;
    font-size: 0.9em;
    margin-bottom: 10px;

    .customer-section {
        width: 370px;
    }

    .sales-rep-section {
        width: 370px;
    }
}

.particulars-section {
    width: 95%;
    margin: auto;
    margin-bottom: 30px;
    table{
        td:nth-of-type(1),th:nth-of-type(2){
            width: 100px;
            text-align: right;
            padding-right: 10px;
            border: 1px solid lightgrey;
        }
        td:nth-of-type(2),th:nth-of-type(3){
            width: 100px;
            text-align: right;
            padding-right: 10px;
            border: 1px solid lightgrey;
        }
        td:nth-of-type(3),th:nth-of-type(4){
            width: 100px;
            text-align: right;
            padding-right: 10px;
            border: 1px solid lightgrey;
        }

        thead{
            tr{
                border-bottom: 1px solid black;
                th{
                    border-bottom: 1px solid black;
                }
            }
        }
        tbody{
            th{
                width: auto;
            }
        }


        td,th{
            input{
                display: block;
                width: 100%;
                height: 32px;
                padding: 0px;
                padding-left: 5px;
                border: none;
            }
        }
        td{
            input{
                text-align: right;
                padding-right: 5px;
            }
        }
    }

    .error_display{
        color: red;
    }
}

.footer-section {
    display: flex;
    justify-content: space-between;

    .comments-section {
        width: 100%;
    }

    .payment-section {
        width: 370px;
    }
}


</style>
