<template>
    <h1 class="page-header">Vehicles</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link v-if="['Admin','Sales'].includes($attrs.user.account_type)" :href="route('dashboard_add_vehicle')" as="li" class="rep-btn">
                    <p>Add Vehicle</p>
                </Link>
            </ul>
        </div>
<!--        <div class="search-section">-->
<!--            <input type="text">-->
<!--        </div>-->
    </div>
    <div v-if="vehicles.length > 0" class="table-section">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">id</th>
                    <th scope="col">Registration Number</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Last Update</th>

                </tr>
            </thead>
            <tbody>
                <Link v-for="(vehicle,index) in vehicles" as="tr" :href="route('dashboard_update_vehicle',[vehicle.id])">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ vehicle.id }}</td>
                    <td>{{ vehicle.registration_number }}</td>
                    <td>{{ vehicle.model }}</td>
                    <td>{{ vehicle.created_at }}</td>
                    <td>{{ vehicle.updated_at }}</td>
                </Link>
            </tbody>
        </table>
    </div>
    <p v-else class="default-display" >No Vehicles Registered</p>
</template>

<script>
export default {
    name: "index",
    props:['vehicles']
}
</script>

<style lang='scss' scoped>
.default-display{
    margin: 30px auto 30px;
    width: 90%;
    box-shadow: 0 0 6px grey;
    border-radius: 8px;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bolder;
    font-size: 1.3em;
    background-color: white;
}

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
</style>
