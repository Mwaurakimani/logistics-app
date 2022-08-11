<template>
    <h1 class="page-header">Users</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_add_users')" as="li" class="rep-btn">
                    <p>Add User</p>
                </Link>
            </ul>
        </div>
        <div class="search-section">
            <input type="text" placeholder="Search by username" @keyup="search_users()">
        </div>
    </div>
    <div class="table-section">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Last Update</th>

                </tr>
            </thead>
            <tbody>
                <Link v-for="(user,index) in users" as="tr" :href="route('dashboard_get_user',[user.id])"  >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ user.username }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.updated_at }}</td>
                </Link>
            </tbody>
        </table>
    </div>
</template>

<script>
import {isStringNullOrWhiteSpace} from '/resources/js/functions';
import axios from "axios";

export default {
    name: "index.vue",
    props: ['users'],
    methods:{
        search_users(){
            let text = $(event.currentTarget).val();

            if(!isStringNullOrWhiteSpace(text)){
                this.$inertia.post(route('dashboard_search_user'),{
                    data: text
                })
            }else {
                this.$inertia.post(route('dashboard_search_user'),{
                    data: ''
                })
            }
        }
    },
    mounted() {
        console.log(this.users)
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
</style>
