<template>
    <section id="dashboard-sidebar">
        <div class="logo-section">
            <p>Bright</p>
        </div>
        <div class="buttons-section">
            <ul @click="rerender_elem">
                <Link :href="'/dashboard'" as="li">
                    <p>Dashboard</p>
                </Link>
                <Link :href="route('dashboard_orders')" as="li" >
                    <p>Orders</p>
                </Link>
                <Link :href="route('dashboard_users')" as="li" >
                    <p>User</p>
                </Link>
                <Link :href="route('dashboard_settings')" as="li" >
                    <p>Settings</p>
                </Link>

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
    components:{
      Link
    },
    methods : {
        rerender_elem(){
            setTimeout(function () {
                render_elem();
            }, 1000)

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
}


</style>