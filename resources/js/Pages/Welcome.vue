<template>
    <layout>
        <main-navigation/>
        <h1>Order Tracking</h1>
        <p>To track your order please enter your Order ID in the box below and press the "Track" button. This
            was given to you on your receipt and in the confirmation email you should have received.</p>

        <div class="order_tracker_input">
            <label for="order_id">Tracking Code</label>
            <input id="order_id" type="text" placeholder="Please enter your tracking code" name="order_id" v-model="tracking_form.id">
            <button @click="track_id">Track</button>
        </div>
        <Footer/>
    </layout>
</template>

<script>
import MainNavigation from "../partials/MainNavigation.vue";
import Footer from "../partials/Footer.vue";
import layout from "../components/defaultLayout.vue";

export default {
    components: {
        MainNavigation,
        Footer,
        layout
    },
    data(){
        return {
            tracking_form: this.$inertia.form({
                id:null
            })
        }
    },
    methods:{
        track_id(){
            this.tracking_form.post(route('track_delivery_by_id'));
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../scss/index';

h1{
  margin-top: 100px;
  text-align: center;
  font-size:1.8em;
  font-weight: bolder;
  margin-bottom: 50px;
}

p{
  width: 650px;
  font-size: 0.9em;
  margin: auto;
  margin-bottom: 60px;
}

.order_tracker_input{
  width: 650px;
  margin: auto;
  display: flex;
  flex-direction:column;
  margin-bottom: 50px;

  label{
    margin-bottom: 10px;
  }

  input{
    width: 100%;
    height: 45px;
    margin-bottom: 30px;
  }

  button{
    width: 250px;
    height: 40px;
    background-color: red;
    display: block;
    margin: auto;
    color: white;
  }
}

</style>
