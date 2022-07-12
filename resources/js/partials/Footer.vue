<template>
    <div class="footer">
        <div class="upper_footer">
            <div class="small_card_display">
                <div class="image_display">

                </div>
                <div class="description_section">
                    <h4>Deliver</h4>
                    <p>We ship countrywide. Simply
                        shop, we deliver</p>
                </div>
            </div>
            <div class="small_card_display">
                <div class="image_display">

                </div>
                <div class="description_section">
                    <h4>Shop with Confidence</h4>
                    <p>Our Buyer Protection covers
                        your purchase from
                        click to delivery.</p>
                </div>
            </div>
            <div class="small_card_display">
                <div class="image_display">

                </div>
                <div class="description_section">
                    <h4>Secure Payment</h4>
                    <p>Pay with the world’s most
                        popular and secure
                        payment methods.</p>
                </div>
            </div>
            <div class="small_card_display" style="border:none">
                <div class="image_display">

                </div>
                <div class="description_section">
                    <h4>24/7 Help Center</h4>
                    <p>Round-the-clock assistance
                        for a smooth shopping
                        experience.</p>
                </div>
            </div>
        </div>
        <div class="horizontal_rule"></div>
        <div class="lower_footer">
            <section>
                <h4>Contact Information</h4>
                <p>Absa Towers, 15th floor, Loita Street, Nairobi.<br>
                    +254 710 623 400 or +254 202 241 229<br>
                    sales@bright.co.ke</p>
            </section>
            <section>
                <h4>Contact Information</h4>
                <p>Our Story<br>
                    Careers<br>
                    CSR<br>
                    Contact US</p>
            </section>
            <section>
                <h4>Contact Information</h4>
                <p>Delivery Information<br>
                    Privacy Policy<br>
                    Terms & Conditions<br>
                    IT Solutions</p>
            </section>
            <section>
                <h4>Newsletter</h4>
                <div>
                    <input>
                    <button>Subscribe</button>
                </div>
            </section>
        </div>
    </div>
</template>
<script>
export default {
    name: 'footer',
}
</script>
<style lang="scss" scoped>
@import '../../scss/index';

.footer{
  background-color: #272727;

  .upper_footer{
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: space-around;

    .small_card_display{
      width: 300px;
      height: 120px;
      display: flex;
      align-items: center;
      border-right: 1px solid darkgrey;

      .image_display{
        width: 100px;
        height: 90px;
        border: 1px solid #9D6969;
      }
      .description_section{
        width: calc(100% - 120px);
        height: auto;
        padding-left: 3px;
        h4{
          margin-bottom: 3px;
          font-weight: bolder;
          color: white;
        }
        p{
          color: white;
          font-size: 0.8em;
        }
      }
    }
  }

  .lower_footer{
    height: 216px;
    display: flex;
    padding-top: 40px;
    justify-content: space-around;

    section{
      color: white;
      h4{
        font-weight: bolder;
        margin-bottom: 5px;
      }
      p{
        font-size: 0.9em;
      }
    }

    section{
      div{
        width: 297px;
        height: 50px;
        background-color: red;
        input{
          height: 100%;
          padding: 5px;
        }
        button{
          width: 100px;
          height: 100%;
          line-height: 50px;
          &:hover{
            background-color: darken(red,20%);
          }
        }
      }
    }
  }

}
.horizontal_rule{
  height: 1px;
  width: 92%;
  margin: auto;
  background-color: white;
}
</style>