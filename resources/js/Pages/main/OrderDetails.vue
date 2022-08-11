<template>
    <main-navigation/>

    <div v-if="order_available">
        <div  class="found_order_details">
            <section>
                <p>Tracking Code: {{ delivery[0].id}}</p>
                <p>Shipping is handled by: <b>{{ delivery[0].handled_by }}</b></p>
            </section>
            <section>
                <h5>{{ delivery[0].dispatched_from }}</h5>
                <p>{{ 	delivery[0].dispatch_date }}, {{ delivery[0].region }}</p>
                <tracker-element :deliveryData="delivery" />
            </section>
            <section>
                <p>Estimated Delivery Date</p>
                <h5>{{ delivery[0].estimated_time_of_arrival }} - By End Day</h5>
                <!--            <button>Shipping notifications</button>-->
            </section>
            <section>
                <h5>More Shipment Details</h5>
                <div class="more-details">
                    2 Pieces
                </div>
            </section>
            <section class="detailed_shipping_details" style="border:none">
                <h5 class="" style="margin-bottom: 30px">All Shipment Details</h5>
                <div class="splitter"></div>
                <div v-for="stage in stages" class="day-details">
                    <div class="date-section">
                        <p>{{ get_day(stage.date) }}</p>
                        <h5>{{ stage.date }}</h5>
                    </div>
                    <div v-for="entry in stage.date_items" class="entry-record">
                        <div class="time-display">
                            <p>{{ entry.time }} Localtime</p>
                        </div>
                        <div class="icon-display triangle">
                            <img src="/storage/icons/triangle.png" alt="location">
                        </div>
                        <div class="full-details">
                            <h6>{{ entry.description }}</h6>
                            <p>{{ (entry.location).toUpperCase() }}</p>
                            <p class="piece">{{ entry.items }} pieces</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="comment_section" >
            <h5>Comment</h5>
            <div class="form-input">
                <textarea v-model="form.comment" >

                </textarea>
                <button @click="submit_comment" >Submit</button>
            </div>
        </div>
    </div>

    <div v-else class="no_order_details">
        <div class="no_order_notice">
            <p>No order with id <b style="color: red">{{ delivery_id }}</b> found</p>
            <Link :href="'/'" as="a"  > Go to Home</Link>
        </div>
    </div>

    <Footer/>
</template>

<script>
import MainNavigation from "../../partials/MainNavigation.vue";
import Footer from "../../partials/Footer.vue";
import TrackerElement from "./TrackerElement.vue";
import layout from "../../components/defaultLayout.vue";

export default {
    components: {
        TrackerElement,
        MainNavigation,
        Footer,
        layout
    },
    props:['delivery','stages','delivery_id'],
    data() {
        return {
            order_available: this.delivery ? true : false,
            form: this.$inertia.form({
                comment: this.delivery? this.delivery[0].comment ?? '' : ''
            })
        }
    },
    methods:{
        get_day(date){
            let date_rendered = new Date(date)
            let day = null;

            switch (date_rendered.getDay()) {
                case 0:
                    day = "Sunday";
                    break;
                case 1:
                    day = "Monday";
                    break;
                case 2:
                    day = "Tuesday";
                    break;
                case 3:
                    day = "Wednesday";
                    break;
                case 4:
                    day = "Thursday";
                    break;
                case 5:
                    day = "Friday";
                    break;
                case 6:
                    day = "Saturday";
            }

            return day;
        },

        submit_comment(event){
            console.log(this.delivery_id);
            this.form.post(route('post_comment',[this.delivery_id]));
        }
    },
}
</script>

<style lang="scss" scoped>
@import '../../../scss/index';

.no_order_details {
  height: 50vh;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;

  .no_order_notice {
    width: 80%;
    height: 300px;
    border-radius: 3px;
    background-color: white;
    box-shadow: 0 0 6px darkgrey;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;

    p {
      margin-bottom: 40px;
      font-weight: bolder;
      font-size: 1.2em;
    }

    a {
      background-color: red;
      color: white;
      padding: 5px 20px;
      border-radius: 5px;
    }
  }
}

.found_order_details {
  width: 1000px;
  margin: auto;
  margin-top: 20px;
  margin-bottom: 50px;
  background-color: white;
  border-radius: 5px;
  border: 1px solid darkgrey;

  section {
    font-size: 0.85em;
    padding: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid darkgrey;

    p {
      margin-bottom: 10px;
    }

    h5 {
      font-weight: bolder;
      font-size: 1.5em;
      margin-bottom: 5px;
    }

    .more-details {
      width: 98%;
      height: 40px;
      border-radius: 8px;
      background-color: #D9D2D2;
      color: #D25959;
      padding: 10px;
      font-weight: bolder;
    }
  }
}

.comment_section{
    width: 1000px;
    margin: auto;
    margin-bottom: 20px;
    padding-bottom: 10px;

    h5{
        padding: 10px;
        font-weight: bolder;
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .form-input{
        width: 90%;
        margin: auto;
        border: none;

        textarea{
            width: 100%;
            border-radius: 8px;
            height: 200px;
            padding: 10px;
        }
        button{
            padding: 10px 20px;
            background-color: red;
            color: white;
            border-radius: 8px;
        }
    }
}

.detailed_shipping_details {
  .day-details {
    width: 100%;
    padding-bottom: 10px;
    border-bottom: 1px solid #B6B4B4;
    margin-bottom: 10px;

    .date-section {
      p {
        margin: 0px;
      }
    }

    .entry-record {
      //background-color: yellow;
      display: flex;
      margin-bottom: 30px;

      .time-display {
        width: 160px;
        //background-color: greenyellow;
      }

      .icon-display {
        z-index: 300;
        background-color: white;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        //background-color: pink;
        margin-right: 20px;

        img {
          width: 30px;
          height: 30px;
        }

      }

      .full-details {
        h6 {
          font-size: 1.1em;
          font-weight: bolder;
        }

        p {
          margin: 0px;
        }

        .piece {
          color: red;
        }
      }
    }
  }

  .day-details:last-of-type {
    border: none;
  }
}

.triangle {
  img {
    width: 20px !important;
    height: 20px !important;
  }
}

section:last-of-type{
  position: relative;
}

.splitter{
  position: absolute;
  left: 205px;
  width: 1px;
  height: calc(100% - 120px);
  background-color: #B6B4B4;
}

</style>
