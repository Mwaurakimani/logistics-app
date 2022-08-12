<template>
    <h1 class="page-header">Users From</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_users')" as="li" >
                    <p>User List</p>
                </Link>
                <li v-if="selected_user == null || selected_user == 'undefined'" @click="create_user">
                    <p>Save</p>
                </li>
                <li v-else @click="update_user">
                    <p>Update</p>
                </li>

            </ul>
        </div>
    </div>
    <div class="user-form">
        <div class="form-section">
            <div class="user-details-section">
                <h5>User Details</h5>

                <div class="form-item">
                    <div class="input-group">
                        <label for="">Username</label>
                        <input type="text" v-model="user_from.username">
                        <span v-if="this.$attrs.errors.username"  class="form_error">{{this.$attrs.errors.username}} </span>
                    </div>
                    <div class="input-group">
                        <label for="">Email</label>
                        <input type="email" v-model="user_from.email">
                        <span v-if="this.$attrs.errors.email"  class="form_error">{{this.$attrs.errors.email}} </span>
                    </div>
                    <div class="input-group">
                        <label for="">Phone</label>
                        <input type="text" v-model="user_from.phone">
                        <span v-if="this.$attrs.errors.phone"  class="form_error">{{this.$attrs.errors.phone}} </span>
                    </div>
                    <div class="input-group">
                        <label for="">Account Type</label>
                        <select name="" id="" v-model="user_from.account_type">
                            <option value="none">none</option>
                            <option value="Admin">Admin</option>
                            <option value="Management">Management</option>
                            <option value="Procurement">Procurement</option>
                            <option value="Sales">Sales</option>
                            <option value="Finance">Finance</option>
                            <option value="Logistics">Logistics</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="">Notes</label>
                        <textarea v-model="user_from.notes">

                        </textarea>
                    </div>
                </div>
            </div>
            <div v-if="selected_user"  class="user-details-section">
                <h5>Security</h5>

                <div class="form-item">
                    <div class="input-group">
                        <label for="">Current password</label>
                        <input type="password" v-model="security_form.current_password">
                        <p class="error_text" >{{ $attrs.errors.current_password }}</p>
                    </div>
                    <div class="input-group">
                        <label for="">New Password</label>
                        <input type="password" v-model="security_form.new_password">
                        <p class="error_text" >{{ $attrs.errors.new_password }}</p>
                    </div>
                    <div class="input-group">
                        <label for="">Confirm Password</label>
                        <input type="password" v-model="security_form.confirm_new_password">
                        <p class="error_text" >{{ $attrs.errors.confirm_new_password }}</p>
                    </div>

                    <button @click="update_password">Update Password</button>
                </div>
            </div>
        </div>
        <div v-if="selected_user" class="details-section">
            <div class="form-section">
                <div class="user-details-section">
                    <h5>Account Details</h5>

                    <div class="form-item">
                        <div class="info-box">
                            <h6>Date created: </h6>
                            <p>{{ selected_user.created_at }}</p>
                        </div>
                        <div class="info-box">
                            <h6>Date created: </h6>
                            <p>{{ selected_user.updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "usersForm.vue",
    props:['selected_user'],
    data(){
        return {
            user_from: this.$inertia.form({
               username: this.selected_user ? this.selected_user.username : null ,
                email: this.selected_user ? this.selected_user.email : null ,
                phone: this.selected_user ? this.selected_user.phone : null ,
                account_type: this.selected_user ? this.selected_user.account_type : '' ,
                notes: this.selected_user ? this.selected_user.notes : null ,
            }),

            security_form: this.$inertia.form({
                current_password:null,
                new_password:null,
                confirm_new_password:null,
            })
        }
    },

    methods:{
        create_user(){
            this.user_from.post(route('post_new_user'))
        },
        update_user(){
            this.user_from.post(route('update_user',[this.selected_user.id]))
        },
        update_password(){
            this.security_form.post(route('update_password',[this.selected_user.id]))
        }
    },

}
</script>

<style lang='scss'>

body{
  overflow: hidden;
}

.error_text{
  width: 100%;
  color: red;
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

.user-form{
  width: 98%;
  margin: auto;
  display: flex;
  justify-content: space-between;
  padding-bottom: 20px;

  .form-section{
    width: 70%;

    .user-details-section{
      width: 100%;
      background-color: white;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 3px 6px grey;

      h5{
        font-weight: bolder;
        margin-bottom: 15px;
      }

      .form-item{
        width: 95%;
        padding: 0px 20px;

        .input-group{
          margin-bottom: 15px;
          label{
            font-size: 0.9em;
            display: block;
            width: 100%;
            margin-bottom: 5px;
          }

          input{
            height: 32px;
            width: 80%;
          }

          select{
            width: 80%;
            height: 32px;
            padding: 4px;
          }
          textarea{
            width: 80%;
            height: 100px;
          }
        }

        button{
          margin-top: 10px;
          width: 160px;
          height: 30px;
          color: white;
          background-color: red;
          border-radius: 8px;
        }
      }
    }
  }

  .details-section{
    width: calc(100% - 70% - 10px);

    .form-section{
      width: 100%;

      .info-box{
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        h6{
          font-weight: bolder;
          margin-right: 10px;
        }
        h6,p{
          font-size: 0.85em;
        }
      }
    }
  }
}
</style>
