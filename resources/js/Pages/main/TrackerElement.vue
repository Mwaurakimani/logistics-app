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
export default {
    name: 'tracker-element'
}
</script>
<style lang="scss" scoped>
@import '../../../scss/index';


.track-display {
  width: 900px;
  margin: auto;

  .elem-content-holder{
    width: 900px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .track-stop{
      width: 90px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      p{
        text-align: center;
        font-weight: bolder;
      }
    }
  }
  .track-runner{
    position: relative;
    width: 830px;
    margin: auto;

    .beacon-holder{
      width: 100%;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;

      .stop-beacon{
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: red;
        border-radius: 50%;
        z-index: 100;
        .inner{
          border-radius: 50%;
          background-color: white;
          width: 50%;
          height: 50%;
        }
      }
    }

    .runner{
      top:-18px;
      position: relative;
      width: 100%;
      height: 6px;
      background-color: #DCD3D4;

      .inner-runner{
        width: 66.6%;
        height: 100%;
        background-color: red;
      }
    }

  }
}

</style>