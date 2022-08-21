<template>
    <form action="">
        <div class="header-section">
            <section class="customer-section">
                <h4>Customer Details</h4>
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">Name:</label>
                        <input v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="text" v-model="order_form.customer_name">
                        <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.customer_name  }}</p>
                        <span v-if="errors.customer_name" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.customer_name }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Contact Name:</label>
                        <input v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="text" v-model="order_form.contact_name">
                        <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.contact_name  }}</p>
                        <span v-if="errors.contact_name" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.contact_name }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Tel:</label>
                        <input v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="tel" v-model="order_form.contact_phone">
                        <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.contact_phone  }}</p>
                        <span v-if="errors.contact_phone" class="form_error text-right"
                              style="margin-right: 30px">{{ errors.contact_phone }}</span>
                    </div>
                    <div class="input-group">
                        <label for="">Address:</label>
                        <textarea v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" v-model="order_form.contact_address"></textarea>
                        <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.contact_address  }}</p>
                    </div>
                </div>
            </section>
            <section class="sales-rep-section">
                <div class="sales-section">
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Sales Rep:</label>
                            <input v-if="false" id="un-editable" style="border:none;outline: transparent" readonly  type="text" v-model="order_form.user_id">
                            <p>{{ order_form.user_id  }}</p>
                        </div>
                    </div>
                </div>
                <div class="payment-section">
                    <h4>LPO Details</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">LPO number</label>
                            <input v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="text" v-model="order_form.lpo_number">
                            <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.customer_name  }}</p>
                            <span v-if="errors.lpo_number" class="form_error text-left"
                                  style="margin-left: 120px">{{ errors.lpo_number }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">LPO value</label>

                            <input  v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="currency" v-model="order_form.lpo_value">
                            <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.lpo_value  }}</p>

                            <span v-if="errors.lpo_value" class="form_error text-left" style="margin-left: 120px">{{ errors.lpo_value }}</span>
                        </div>

                    </div>
                </div>

                <div class="delivery-section mb-[50px]">
                    <h4>Delivery Details</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Proposed DD:</label>
                            <input v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" type="date" v-model="order_form.proposed_delivery_date">
                            <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.proposed_delivery_date  }}</p>
                            <span v-if="errors.proposed_delivery_date" class="form_error text-left"
                                  style="margin-left: 120px">{{ errors.proposed_delivery_date }}</span>
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
                        <textarea v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" class="h-[170px]" v-model="order_form.comments"></textarea>
                        <p v-if="!['Admin','Sales'].includes(user.account_type)">{{ order_form.comments  }}</p>
                    </div>
                </div>
            </div>

            <div class="opf-entry-sect w-[370px]">
                <section v-if="(order_form.id == null || order_form.id == '') && ['Admin','Sales'].includes(user.account_type)" class="customer-section mb-[40px]">
                    <h4 >Attach OPF</h4>
                    <input class="ml-[100px] inline-block w-[280px]" type="file" @input="order_form.opfFile = $event.target.files[0]">
                </section>

                <section class="sales-rep-section" v-if="procurement && procurement.length > 0 && procurement[0].opf_file_path">
                    <div class="sales-section">
                        <h4>Download OPF</h4>
                        <a class="ml-[100px]" :href="'/storage/'+file_path" target="_blank">Download</a>
                    </div>
                </section>
            </div>
        </div>
    </form>
</template>

<script>

function localStringToNumber( s ){
    return Number(String(s).replace(/[^0-9.-]+/g,""))
}

function onFocus(e){
    let value = e.target.value;
    e.target.value = value ? localStringToNumber(value) : ''
}

function onBlur(e){
    let value = e.target.value

    let options = {
        maximumFractionDigits : 2,
        currency              : 'Ksh',
        style                 : "currency",
        currencyDisplay       : "symbol"
    }

    e.target.value = (value || value === 0)
        ? localStringToNumber(value).toLocaleString(undefined, options)
        : ''
}





export default {
    name: "orderDisplayForm",
    props: ['order_form', 'user', 'errors','procurement'],
    watch:{
      order_form: ()=> {
          console.log("hi");
      }
    },
    computed:{
        file_path(){
            let path = this.procurement[0].opf_file_path;
            path = path.split('/');
            path.shift();
            path = path.join('/')

            return path;
        } ,
    },
    methods:{
      change_date(date){
          const [year, month, day] = date.split('-');

      }
    },
    mounted() {
        let currencyInput = document.querySelector('input[type="currency"]')

        if(currencyInput){
            onBlur({target:currencyInput})

            currencyInput.addEventListener('focus', onFocus)
            currencyInput.addEventListener('blur', onBlur)
        }
    },
    // updated() {
    //     let currencyInput = document.querySelector('input[type="currency"]')
    //
    //     if(currencyInput){
    //         onBlur({target:currencyInput})
    //
    //         currencyInput.addEventListener('focus', onFocus)
    //         currencyInput.addEventListener('blur', onBlur)
    //     }
    // }
}
</script>

<style lang='scss' scoped>

#un-editable{
    border: none;
    outline: none;
    &:active{
        border: none;
        outline: none;
    }
}

.sales-rep-section {
    width: 370px;

    & a {
        background-color: red;
        padding: 5px 10px;
        border-radius: 8px;
        color: white;
    }
}

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

.input-group{
    p{
        padding: 0px 20px 10px;
        font-weight: bolder;
    }
}

</style>
