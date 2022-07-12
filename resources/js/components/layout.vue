<template>
    <div id="dashboard-display">
        <side-nav  :key="componentKey" @reload_comp = 'rerender_component'/>
        <section id="dashboard-content">
            <top-navigation/>
            <slot></slot>
        </section>
    </div>
</template>

<script>
import SideNav from "../partials/SideNav.vue";
import TopNavigation from "../partials/TopNavigation.vue";

export default {
    components: {TopNavigation, SideNav},

    data(){
        return {
            componentKey: true
        }
    },

    methods:{
        rerender_component(){
            this.componentKey = !this.componentKey
        }
    }
}
</script>

<style lang='scss'>

#dashboard-display {
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

#dashboard-content {
  width: calc(100vw - 285px);
  height: 100vh;
  background-color: #F6F5F5;
  overflow-y: auto;
}
</style>