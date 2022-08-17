<template>
    <section id="dashboard-sidebar">
        <div class="logo-section">
            <img src="/storage/icons/lorry.png" alt="">
        </div>
        <div class="buttons-section">
            <ul @click="rerender_elem">
                <Link v-show="display_button(['Admin','Procurement','Sales','Finance','Management','Logistics'])" :href="'/dashboard'" as="li">
                    <p>Dashboard</p>
                </Link>
                <Link v-show="display_button(['Admin','Procurement','Sales','Finance','Management','Logistics'])" :href="route('dashboard_orders')" as="li" >
                    <p v-if="user.account_type == 'Sales'">Sales</p>
                    <p v-else-if="user.account_type == 'Logistics'">Deliveries</p>
                    <p v-else>Orders</p>
                </Link>
                <Link v-show="display_button(['Admin','Management'])" :href="route('dashboard_users')" as="li" >
                    <p>User</p>
                </Link>
                <Link v-show="display_button(['Admin','Management','Logistics'])" :href="route('dashboard_vehicles')" as="li" >
                    <p>Vehicles</p>
                </Link>
<!--                <Link v-show="display_button(['Admin','Procurement','Sales','Finance','Management','Logistics'])" :href="route('dashboard_get_user',[user.id])" as="li" >-->
<!--                    <p>Settings</p>-->
<!--                </Link>-->
            </ul>
        </div>
    </section>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";

function render_elem(){
    let elems = $('#dashboard-sidebar').find('ul li');

    elems.each((index,el) => {
        let element = $(el)
        let text = element.text().toLowerCase();

        element.removeClass('active')

        if ( window.location.href.indexOf(text) > -1 ){
            element.addClass('active');
            return;
        }
    })
}


export default {
    name: 'side-nav',
    props:['user'],
    components:{
      Link
    },
    methods : {
        rerender_elem(){
            setTimeout(function () {
                render_elem();
            }, 1000)
        },
        display_button(options){
            if(options.includes(this.user.account_type)){
                return true
            }else {
                return false
            }
        }
    },
    mounted() {
        this.rerender_elem()
    }
}
</script>
<style lang="scss" scoped>
@import '../../scss/index';

body {
  overflow: hidden;
}

#dashboard-sidebar {
  width: 280px;
  height: 100vh;
    .logo-section{
        width: 100%;
        height: 70px;
        padding: 60px;
    }
}



</style>
