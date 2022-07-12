<template>
    <form action="">
        <div class="header-section">
            <section class="customer-section">
                <h4>Customer Details</h4>
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">Name:</label>
                        <input type="text" v-model="order_form.customer_name">
                    </div>
                    <div class="input-group">
                        <label for="">Contact Name:</label>
                        <input type="text"  v-model="order_form.contact_name">
                    </div>
                    <div class="input-group">
                        <label for="">Tel:</label>
                        <input type="tel" v-model="order_form.contact_phone">
                    </div>
                    <div class="input-group">
                        <label for="">Address:</label>
                        <textarea v-model="order_form.contact_address" ></textarea>
                    </div>
                </div>
            </section>
            <section class="sales-rep-section">
                <div class="sales-section">
                    <h4>Sales Rep</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Name:</label>
                            <input type="text" v-model="order_form.user_id">
                        </div>
                        <div class="input-group">
                            <label for="">Emp No:</label>
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="delivery-section">
                    <h4>Delivery Details</h4>
                    <div class="mini-form">
                        <div class="input-group">
                            <label for="">Date Received:</label>
                            <input type="date" v-model="order_form.date_received">
                        </div>
                        <div class="input-group">
                            <label for="">Proposed DD:</label>
                            <input type="date" v-model="order_form.proposed_delivery_date">
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="particulars-section">
            <div class="table-holder">

            </div>
        </section>
        <div class="footer-section">
            <div class="comments-section">
                <h4>Comments</h4>
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">Comment:</label>
                        <textarea v-model="order_form.comments"></textarea>
                    </div>
                </div>
            </div>
            <div class="payment-section">
                <h4>Payment</h4>
                <div class="mini-form">
                    <div class="input-group">
                        <label for="">LPO number</label>
                        <input type="text" v-model="order_form.lpo_number">
                    </div>
                    <div class="input-group">
                        <label for="">LPO value</label>
                        <input type="text" v-model="order_form.lpo_value">
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "orderDisplayForm",
    props: ['order_form','user'],
}
</script>

<style lang='scss' scoped>

h4{
  font-weight: 500;
  font-size: 1.1em;
  margin-bottom: 10px;
}

.mini-form{
  margin-left: 15px;
  width: 100%;
  .input-group{
    width: 100%;
    margin-bottom: 6px;
    label{
      width: 110px;
    }

    input,select{
      width: 240px;
      height: 25px;
      border: 1px solid #B7B7B7;
    }
    textarea{
      width: 240px;
      border: 1px solid #B7B7B7;
    }
  }
}

form{
  margin-top: 10px;
  width: 100%;
  height: 100%;
  //border: 1px solid grey;
}

//layout
.header-section{
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 0.9em;
  margin-bottom: 10px;

  .customer-section{
    width: 370px;
  }
  .sales-rep-section{
    width: 370px;
  }
}

.particulars-section{
  width: 95%;
  margin: auto;
  height: 200px;
  background-color: #00FFA6;
  margin-bottom: 10px;
}

.footer-section{
  display: flex;
  justify-content: space-between;

  .comments-section{
    width: 320px;
  }
  .payment-section{
    width: 370px;
  }
}



</style>