<template>
    <nav>
        <div class="top_nav">
            <div class="logo_display">
                <p>Bright</p>
            </div>

            <div class="left_section">
                <div class="contact_section">
                    <p>#ShopatBright</p>
                    <p>+254 700 000 000</p>
                </div>
                <div class="action_buttons">
                    <div>
                        <img src="/storage/icons/add-to-cart.png" alt="">
                    </div>
                    <Link :href="'/dashboard'" as="div">
                        <img src="/storage/icons/user.png" alt="">
                    </Link>
                </div>
            </div>
        </div>
        <div class="bottom_nav">
            <ul>
                <li><a href="#">Offer</a></li>
                <li><a href="/trackOrder">Track Your Order</a></li>
                <li><a href="#">IT solutions</a></li>
                <li><a href="#">Career</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    name: 'main-navigation',
}
</script>
<style lang="scss" scoped>
@import '../../scss/index';

nav{
  .top_nav{
    width: 100%;
    height: 70px;
    background-color: red;
    display: flex;
    justify-content: space-between;

    .logo_display{
      width: 100px;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 20px;

      p{
        font-size: 1.4em;
        color: white;
      }
    }

    .left_section{
      width: 500px;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-right: 30px;
      .contact_section{
        font-size: 0.8em;
        color: white;
      }
      .action_buttons{
        display: flex;
        align-items: center;
        justify-content: center;
        &>div{
          margin-left: 10px;
          width: 35px;
          height: 35px;
          padding: 5px;

        }
      }

    }
  }

  .bottom_nav{
    width: 100%;
    height: 40px;
    background-color: red;
    box-shadow: 0 0 6px #9D9A9A;
    display: flex;
    align-items: center;
    justify-content: right;
    ul{
      width: 500px;
      display: flex;
      align-items: center;
      justify-content: space-around;
      a{
        color: white;
      }
    }
  }
}
</style>