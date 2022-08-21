<template>
    <form action="" @submit.prevent>
        <div class="header-section">
            <section class="sales-rep-section">
                <div class="sales-section">
                    <h4>Financial</h4>
                    <select v-if="finance && ['Admin','Finance'].includes(user.account_type)"  name="" id="" v-model="financeForm.status">
                        <option value="Pending">Pending</option>
                        <option value="Reviewing">Reviewing</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
            </section>
        </div>
        <section class="particulars-section">
            <textarea v-if="finance && ['Admin','Finance'].includes(user.account_type)" style="width: 100%;height: 100%" v-model="financeForm.comments">

            </textarea>
            <textarea v-else disabled style="width: 100%;height: 100%" v-model="financeForm.comments">

            </textarea>
        </section>

        <button v-if="finance && ['Admin','Finance'].includes(user.account_type)"  class="update-button" @click="update_finance_details">Update</button>
    </form>
</template>

<script>
export default {
    name: "FinanceForm",
    props: ['order_form','user','finance'],
    data(){
        return {
            financeForm: this.$inertia.form({
                status : this.finance && this.finance.length > 0 && this.finance[0].status ? this.finance[0].status : 'Pending',
                comments :  this.finance && this.finance.length > 0 && this.finance[0].comment ? this.finance[0].comment : null
            })
        }
    },
    methods:{
        update_finance_details(){
            this.financeForm.post(route('update_finance_details',[this.order_form.id]))
        }
    }
}
</script>

<style lang='scss' scoped>

h4{
  font-weight: 500;
  font-size: 1.1em;
  margin-bottom: 10px;
}

form{
  margin-top: 10px;
  width: 100%;
  height: 100%;
  //border: 1px solid grey;
  &>button{
    padding: 5px 10px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: red;
    color: white;
  }

  select{
    width: 100%;
    height: 30px;
    padding: 2px;
  }
}

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
    & button {
      background-color: red;
      padding: 5px 10px;
      border-radius: 8px;
      color: white;
    }
  }


}

.particulars-section{
  width: 95%;
  margin: auto;
  height: 200px;
  background-color: #00FFA6;
  margin-bottom: 10px;
}




</style>
