<template>
    <form action="" @submit.prevent>
        <div class="header-section">
            <section class="customer-section">
                <h4>OPF Entry</h4>
                <input type="file" @input="procurementForm.opfFile = $event.target.files[0]">
            </section>
            <section class="sales-rep-section" v-if="procurement.length > 0 && procurement[0].opf_file_path">
                <div class="sales-section">
                    <h4>OPF Entry</h4>
                    <a :href="'/storage/'+file_path" target="_blank">Download</a>
                </div>
            </section>
            <section class="sales-rep-section">
                <div class="sales-section">
                    <h4>Order Fulfilment Status</h4>
                    <select name="" id="" v-model="procurementForm.status">
                        <option value="Pending">Pending</option>
                        <option value="Unfulfillable">Unfulfillable</option>
                        <option value="Partially Fulfillable">Partially Fulfillable</option>
                        <option value="Fulfillable">Fulfillable</option>
                        <option value="Fulfilled">Fulfilled</option>
                    </select>
                </div>
            </section>
        </div>
        <section class="particulars-section">
            <textarea style="width: 100%;height: 100%" v-model="procurementForm.comments">

            </textarea>
        </section>

        <button class="update-button" @click="upload_procurement_Details">Update</button>
    </form>
</template>

<script>
export default {
    name: "procurementForm",
    props: ['order_details', 'user', 'procurement'],
    computed:{
      file_path(){
         let path = this.procurement[0].opf_file_path;
          path = path.split('/');
          path.shift();
          path = path.join('/')

          return path;
      } ,
    },
    data() {
        return {
            procurementForm: this.$inertia.form({
                opfFile: null,
                status: this.procurement && this.procurement.length > 0 && this.procurement[0].status ? this.procurement[0].status : 'Pending',
                comments: this.procurement && this.procurement.length > 0 && this.procurement[0].comments ? this.procurement[0].comments : ''
            })
        }
    },
    methods: {
        upload_procurement_Details() {
            this.procurementForm.post(route('uploading_procurement_details', [this.order_details.id]), {
                forceFormData: true
            })
        },
    },
}
</script>

<style lang='scss' scoped>

h4 {
  font-weight: 500;
  font-size: 1.1em;
  margin-bottom: 10px;
}

form {
  margin-top: 10px;
  width: 100%;
  height: 100%;
  //border: 1px solid grey;
  & > button {
    padding: 5px 10px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: red;
    color: white;
  }

  select {
    width: 100%;
    height: 30px;
    padding: 2px;
  }
}

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

    & a {
      background-color: red;
      padding: 5px 10px;
      border-radius: 8px;
      color: white;
    }
  }


}

.particulars-section {
  width: 95%;
  margin: auto;
  height: 200px;
  background-color: #00FFA6;
  margin-bottom: 10px;
}


</style>
