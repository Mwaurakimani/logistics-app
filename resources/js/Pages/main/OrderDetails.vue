<template>
    <main-navigation/>

    <div v-if="order_available" class="found_order_details">
        <section>
            <p>Tracking Code: {{ delivery[0].id}}</p>
            <p>Shipping is handled by: <b>{{ delivery[0].handled_by }}</b></p>
        </section>
        <section>
            <h5>{{ delivery[0].dispatched_from }}</h5>
            <p>{{ 	delivery[0].dispatch_date }}, {{ delivery[0].region }}</p>
            <tracker-element/>
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
            <div class="day-details">
                <div class="date-section">
                    <p>Sunday</p>
                    <h5>July, 02 2022</h5>
                </div>
                <div class="entry-record">
                    <div class="time-display">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display">
                        <img src="/storage/icons/location.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
            </div>
            <div class="day-details">
                <div class="date-section">
                    <p>Sunday</p>
                    <h5>July, 02 2022</h5>
                </div>
                <div class="entry-record">
                    <div class="time-display">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display triangle">
                        <img src="/storage/icons/triangle.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
                <div class="entry-record">
                    <div class="time-display ">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display triangle">
                        <img src="/storage/icons/triangle.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
                <div class="entry-record">
                    <div class="time-display ">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display triangle">
                        <img src="/storage/icons/triangle.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
            </div>
            <div class="day-details">
                <div class="date-section">
                    <p>Sunday</p>
                    <h5>July, 02 2022</h5>
                </div>
                <div class="entry-record">
                    <div class="time-display">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display triangle">
                        <img src="/storage/icons/triangle.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
                <div class="entry-record">
                    <div class="time-display ">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display triangle">
                        <img src="/storage/icons/triangle.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
                <div class="entry-record">
                    <div class="time-display ">
                        <p>06:20pm Localtime</p>
                    </div>
                    <div class="icon-display">
                        <img src="/storage/icons/location.png" alt="location">
                    </div>
                    <div class="full-details">
                        <h6>Dispatched from HQ</h6>
                        <p>NAIROBI-CBD</p>
                        <p class="piece">2 pieces</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div v-else class="no_order_details">
        <div class="no_order_notice">
            <p>No order with id 0000000000 found</p>
            <a href="">Go to home</a>
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
    props:['delivery','stages'],
    data() {
        return {
            order_available: true
        }
    },
    mounted() {
        console.log(this.delivery)
    }
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