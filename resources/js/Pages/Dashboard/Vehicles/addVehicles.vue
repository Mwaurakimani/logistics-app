<template>
    <h1 class="page-header">Vehicles</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_vehicles')" as="li" >
                    <p>List Vehicle</p>
                </Link>
            </ul>
        </div>
        <div class="search-section">
            <input type="text">
        </div>
    </div>

    <div class="content_section">
        <div class="form_section">
            <h2>Vehicle</h2>
            <form action="" v-on:submit.prevent >
                <div v-if="Vehicle != null && Vehicle != 'undefined'" class="input-group">
                    <label for="">ID</label>
                    <input type="text" v-model="vehicle.id" disabled>
                </div>
                <div class="input-group">
                    <label for="">Registartion number</label>
                    <input type="text" v-model="vehicle.reg_number">
                </div>
                <div class="input-group">
                    <label for="">Model</label>
                    <input type="text" v-model="vehicle.model">
                </div>
                <div class="input-group">
                    <label for="">Vehicle Class</label>
                    <select class="w-[400px]" name="" id="" v-model="vehicle.vehicle_class">
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Pick-Up">Pick Up</option>
                        <option value="Lorry">Lorry</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="">Notes</label>
                    <textarea v-model="vehicle.notes"></textarea>
                </div>

                <button v-if="Vehicle != null && Vehicle != 'undefined'" @click="update_vehicle" >Update</button>
                <button v-else @click="add_vehicle" >Create</button>
            </form>
        </div>
        <div class="details_section">
            <h2>Details</h2>
            <div class="details_sect">
                <h3>Date created :</h3>
                <p>{{ Vehicle ?Vehicle.created_at : 'N/A' }}</p>
            </div>
            <div class="details_sect">
                <h3>last update :</h3>
                <p>{{ Vehicle ?Vehicle.created_at : 'N/A' }}</p>
            </div>
            <div v-if="Vehicle" class="details_sect">
                <h3>Driver :</h3>
                <select name="" id="" v-model="vehicle.driver">
                    <option v-for="driver in Drivers" :value="driver.id">{{ driver.username }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "addVehicles",
    props:['Vehicle','Drivers','driver_set'],
    data(){
        return{
            vehicle:this.$inertia.form({
                id: this.Vehicle != 'undefined' && this.Vehicle != null ? this.Vehicle.id : null,
                reg_number: this.Vehicle != 'undefined' && this.Vehicle != null ? this.Vehicle.registration_number : null,
                model: this.Vehicle != 'undefined' && this.Vehicle != null ? this.Vehicle.model : null,
                vehicle_class: this.Vehicle != 'undefined' && this.Vehicle != null ? this.Vehicle.class : null,
                notes: this.Vehicle != 'undefined' && this.Vehicle != null ? this.Vehicle.notes : null,
                driver: this.driver_set ? this.driver_set.id : null
            })
        }
    },
    methods:{
        add_vehicle(){
            this.vehicle.post(route('post_vehicle'));
        },
        update_vehicle(){
            this.vehicle.put(route('put_vehicle',[this.Vehicle.id]))
        }
    }
}
</script>

<style lang='scss' scoped>
.action-bar{
  width: 100%;
  height: 45px;
  background-color: white;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0px 10px;

  .button-section{
    width: 300px;
    height: 100%;

    ul{
      display: flex;
      align-items: center;
      height: 100%;
      li{
        background-color: red;
        width: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        border-radius: 5px;

        p{
          width: auto;
          height: auto;
          color: white;
          padding: 5px 8px;
          font-size: 0.95em;
        }
      }
    }
  }

  .search-section{
    width: 300px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    input{
      height: 32px;
      border-radius: 8px;
    }
  }
}

.table-section{
  margin: auto;
  width: 98%;
  box-shadow: 0 0 6px grey;
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
    }
  }
}

.content_section{
  width: 98%;
  margin: auto;
  display: flex;
  align-items: start;
  justify-content: space-between;

  .form_section{
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    width: 70%;

    form{
      width: 100%;
      height: 100%;

      .input-group{
        margin-bottom: 20px;
        padding-left: 20px;


        label{
          width: 300px;
        }

        input,textarea{
          width: 400px;
        }
        textarea{
          height: 150px;
        }
      }

      .input-group:last-of-type{
        margin-bottom: 30px;
      }

      button{
        display: block;
        width: 140px;
        background-color: red;
        color: white;
        height: 40px;
        margin: auto auto 40px;
        border-radius: 8px;
      }
    }
  }
  .details_section{
    width: calc(100% - 70%  - 10px);
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
      select{
          width: 200px;
          height: 32px;
          padding: 5px;
      }
  }

  div{
    h2{
      font-size: 1.5em;
      font-weight: bolder;
      padding: 15px;
      margin-bottom: 5px;
    }

    .details_sect{
      width: 100%;
      height: 50px;
      display: flex;
      padding-left: 20px;
      h3{
        width: 150px;
      }
    }
  }
}
</style>
