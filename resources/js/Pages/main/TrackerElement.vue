<template>
    <div class="track-display">
        <div class="elem-content-holder">
            <div class="track-stop">
                <p>Order confirmed</p>
            </div>
            <div class="track-stop">
                <p>Order Dispatched</p>
            </div>
            <div class="track-stop">
                <p>Order Delivered</p>
            </div>
            <div class="track-stop">
                <p>Order Fulfilled</p>
            </div>
        </div>
        <div class="track-runner">
            <div class="beacon-holder">
                <div class="stop-beacon">
                    <div class="inner">

                    </div>
                </div>
                <div class="stop-beacon">
                    <div class="inner">

                    </div>
                </div>
                <div class="stop-beacon">
                    <div class="inner">

                    </div>
                </div>
                <div class="stop-beacon">
                    <div class="inner">

                    </div>
                </div>
            </div>
            <div class="runner">
                <div class="inner-runner">

                </div>
            </div>
        </div>
    </div>
</template>
<script>
import deliveryDetails from "../Dashboard/Orders/deliveryDetails.vue";

export default {
    name: 'tracker-element',
    props: ['deliveryData'],
    computed: {
        track() {
            let percentage = 0;

            switch ( this.position ) {
                case 'Order Confirmed':
                    percentage = 0;
                    break;
                case 'Order Dispatched':
                    percentage = 33.3;
                    break;
                case 'Order Delivered':
                    percentage = 66.6;
                    break;
                case 'Order Fulfilled':
                    percentage = 100;
                    break;
                default:
                    percentage = 0;
                    console.log('position: ' + this.position)
                    break
            }

            return percentage + '%';
        }
    },
    data() {
        return {
            position: this.deliveryData[0].transit_position
        }
    },
    mounted() {
        console.log(this.deliveryData)
    }
}
</script>
<style lang="scss" scoped>
@import '../../../scss/index';


.track-display {
  width: 900px;
  margin: auto;

  .elem-content-holder {
    width: 900px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .track-stop {
      width: 90px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;

      p {
        text-align: center;
        font-weight: bolder;
      }
    }
  }

  .track-runner {
    position: relative;
    width: 830px;
    margin: auto;

    .beacon-holder {
      width: 100%;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;

      .stop-beacon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: red;
        border-radius: 50%;
        z-index: 100;

        .inner {
          border-radius: 50%;
          background-color: white;
          width: 50%;
          height: 50%;
        }
      }
    }

    .runner {
      top: -18px;
      position: relative;
      width: 100%;
      height: 6px;
      background-color: #DCD3D4;

      .inner-runner {
        width: v-bind(track);
        height: 100%;
        background-color: red;
      }
    }

  }
}

</style>