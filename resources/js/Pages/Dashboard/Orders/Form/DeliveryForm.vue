<template>
    <div class="delivery-form-holder">
        <section class="form-holder">
            <section class="dispatch-form">
                <h5>Dispatch Form</h5>
                <form action="">
                    <section>
                        <div>
                            <h4>Tracking ID:</h4>
                            <p>{{ tracking_code }}</p>
                        </div>
                        <div class="input-group">
                            <label for="">Shipping is handled by</label>
                            <input type="text" v-model="delivery.handled_by">
                            <span v-if="errors.handled_by" class="form_error">{{ errors.handled_by }}</span>
                        </div>
                    </section>
                    <section>
                        <div class="input-group">
                            <label for="">Dispatched from</label>
                            <input type="text" v-model="delivery.dispatched_from">
                            <span v-if="errors.dispatched_from" class="form_error text-center">{{ errors.dispatched_from }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Date Dispatched</label>
                            <input type="datetime-local" v-model="delivery.dispatch_date">
                            <span v-if="errors.dispatch_date" class="form_error text-center">{{ errors.dispatch_date }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Region</label>
                            <input type="text" v-model="delivery.region">
                            <span v-if="errors.region" class="form_error text-center">{{ errors.region }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Transit position</label>
                            <select  v-model="delivery.transit_position">
                                <option value="None">None</option>
                                <option value="Order Confirmed">Order Confirmed</option>
                                <option value="Order Dispatched">Order Dispatched</option>
                                <option value="Order Delivered">Order Delivered</option>
                                <option value="Order Fulfilled">Order Fulfilled</option>
                            </select>
                            <span v-if="errors.transit_position" class="form_error text-center">{{ errors.transit_position }}</span>
                        </div>
                        <div class="input-group">
                            <label for="">Vehicle Assigned</label>
                            <select  v-model="delivery.vehicle">
                                <option value="None">None</option>
                                <option v-for="vehicle in Vehicles" :value="vehicle.id" >{{ vehicle.registration_number }}</option>
                            </select>
                            <span v-if="errors.vehicle" class="form_error text-center">{{ errors.vehicle }}</span>
                        </div>
                    </section>
                    <section>
                        <div class="input-group">
                            <label for="">Estimated Delivery Date</label>
                            <input type="date" v-model="delivery.estimated_time_of_arrival">
                            <span v-if="errors.estimated_time_of_arrival" class="form_error text-center">{{ errors.estimated_time_of_arrival }}</span>
                        </div>
                    </section>
                    <section>
                        <h6>Customer Feed back</h6>
                        <p class="customer_feedback" >{{ delivery.comment ?? "No comment"  }}</p>
                    </section>
                </form>
            </section>
            <section class="progress-form">
                <h5>Progress</h5>
                <div class="table-view">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Location</th>
                                <th scope="col">Description</th>
                                <th scope="col">Items</th>
                                <th scope="col">Date and Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in stages">
                                <th scope="row">{{ (index + 1)}}</th>
                                <td>{{ item.id }}</td>
                                <td>{{ item.location }}</td>
                                <td>description</td>
                                <td>{{ item.items }}</td>
                                <td>{{ item.time+" "+item.date }}</td>
                                <td>
                                    <div>
<!--                                        <div @click="" class="icon-holder">-->
<!--                                            <img src="/storage/icons/edit.png" alt="">-->
<!--                                        </div>-->
                                        <div @click="delete_stage(item.id)" class="icon-holder">
                                            <img src="/storage/icons/delete.png" alt="">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
        <section v-if="['Admin','Logistics'].includes(user_account.account_type)" class="form-entry">
            <h5>Progress Entry</h5>
            <form action="" v-on:submit.prevent="">
                <div class="input-group">
                    <label>Description</label>
                    <textarea v-model="stage_form.description">

                    </textarea>
                    <span v-if="errors.description" class="form_error text-center">{{ errors.description }}</span>
                </div>
                <div class="input-group">
                    <label>Location</label>
                    <input type="text" v-model="stage_form.location">
                    <span v-if="errors.location" class="form_error text-center">{{ errors.location }}</span>
                </div>
                <div class="input-group">
                    <label>Items</label>
                    <input type="text" v-model="stage_form.items">
                    <span v-if="errors.items" class="form_error text-center">{{ errors.items }}</span>
                </div>
                <div class="grouper">
                    <div class="input-group">
                        <label>Time</label>
                        <input style="font-size: 0.85em" type="time" v-model="stage_form.time">
                        <span v-if="errors.time" class="form_error text-center">{{ errors.time }}</span>
                    </div>
                    <div class="input-group">
                        <label>Date</label>
                        <input style="font-size: 0.85em" type="date" v-model="stage_form.date">
                        <span v-if="errors.date" class="form_error text-center">{{ errors.date }}</span>
                    </div>
                </div>
                <div class="input-group">
                    <label>Full Details</label>
                    <textarea v-model="stage_form.full_details">

                    </textarea>
                </div>

                <button @click="create_stage" >Update Delivery</button>
            </form>
        </section>
    </div>
</template>
<script>
export default {
    name: 'delivery-form',
    props: ['delivery','tracking_code','stages','Vehicles','errors','user_account'],
    data(){
        return {
            stage_form: this.$inertia.form({
                description:null,
                location:null,
                items:null,
                time:null,
                date:null,
                full_details:null
            })
        }
    },
    methods:{
        create_stage(){
            this.stage_form.post(route('create_stage',[this.tracking_code]),{
                preserveScroll: true,
                onSuccess: () => this.stage_form.reset(),
            })
        },
        delete_stage(id){

            axios.delete(route('delete_stage',[id]))
                .then(function (response) {
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
    mounted() {
        console.log(this.stages)
    }
}
</script>
<style lang='scss' scoped>

body {
  overflow: hidden;
}

.form-holder{
  width: calc(100% - 310px);
}

.delivery-form-holder {
  width: 99%;
  margin: auto;
  display: flex;
  justify-content: space-between;

  h5{
    font-weight: bolder;
    padding: 7px;
  }
}

.dispatch-form{
  border-radius: 8px;
  background-color: white;
  border: 1px solid darkgrey;
  margin-bottom: 20px;

  form {
    & > section{
      font-size: 0.9em;
      margin: auto;
      width: 95%;
      margin-bottom: 15px;
      border-bottom: 1px solid darkgrey;
      padding-bottom: 20px;

      .input-group{
        display: flex;
        align-items: center;
        margin-bottom: 8px;

        label{
          margin-right: 10px;
          width: 200px;
        }

        input, select{
          height: 30px;
          width: 240px;
        }
        select{
          padding: 0px 5px;
        }
      }

      h6{
        padding: 10px 0px;
        font-weight: bolder;
      }
    }

    section:first-of-type{
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0px;
      div{
        max-width: 400px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        h4{
          margin-right: 10px;
        }

        p{
          font-weight: bolder;
        }

        label{
          width: auto;
        }

        input{
          width: 212px;
        }
      }
    }

    section:last-of-type{
      border-bottom: none;
    }
  }
}

.progress-form{
  border-radius: 8px;
  background-color: white;
  border: 1px solid darkgrey;
  margin-bottom: 20px;

  .table-view{
    padding: 10px 0px;
    margin: auto;
    width: 98%;
    height: 400px;
    margin-bottom: 20px;
    background-color: white;

    thead{
      background-color: red;
      color: white;
      tr:first-of-type{
        border-left: none;
      }
      th{
      }
    }

    tbody{
      tr{
        cursor: pointer;

        td:last-of-type{
          padding: 0px;
          div{
            width: 100%;
            height: 33px;
            display: flex;
            justify-content: space-around;

            .icon-holder{
              padding: 6px;
              width: 33px;
              height: 33px;
              &:hover{
                background-color: palevioletred;
              }
            }
          }
        }
      }
    }
  }
}

.form-entry{
  width: 300px;
  height: auto;
  background-color: white;

  form{
    font-size: 0.9em;
    width: 96%;
    margin: auto;
    padding-left: 15px;
    padding-right: 15px;

    .input-group{
      margin-bottom: 10px;
      label{
        width: 100%;
        margin-bottom: 3px;
      }

      input,textarea{
        width: 100%;
      }

      input{
        height: 30px;
      }

      textarea{
        height: 80px;
      }
    }

    .grouper{
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;

      .input-group{
        width: 49%;
      }
    }

    button{
      display: block;
      background-color: red;
      padding: 3px 10px;
      margin: auto;
      color: white;
      border-radius: 5px;
    }
  }
}

.customer_feedback{
    width: 96%;
    margin: auto;
    background-color: #f3f3f3;
    border-radius: 8px;
    padding: 10px;
}
</style>
