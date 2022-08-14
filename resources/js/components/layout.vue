<template>
    <div id="dashboard-display">
        <side-nav  :key="componentKey" :user="$attrs.user" @reload_comp = 'rerender_component'/>
        <section id="dashboard-content">
            <top-navigation/>
            <slot></slot>
        </section>
        <div v-show="$attrs.session_message" class="info-bubble" id="info_bubble">
            <div class="strip"></div>
            <div  class="info">
                <p>{{ $attrs.session_message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import SideNav from "../partials/SideNav.vue";
import TopNavigation from "../partials/TopNavigation.vue";
import {mapMutations} from "vuex";
import {isStringNullOrWhiteSpace} from "../functions";

export default {
    components: {TopNavigation, SideNav},

    data(){
        return {
            componentKey: true
        }
    },

    watch:{
        '$attrs.session_message': function (){
            let session_data = this.$attrs.session_message;

            if(!isStringNullOrWhiteSpace(session_data)){
                this.$store.state.infoBubbleModule.display_bubble = true
                this.display_info_bubble(session_data)
            }
        }
    },

    methods:{
        rerender_component(){
            this.componentKey = !this.componentKey
        },
        ...mapMutations(['display_info_bubble'])
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

.info-bubble{
    position: absolute;
    bottom:30px;
    right: 0;
    width: 400px;
    min-height: 80px;
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 0 6px grey;
    overflow: hidden;
    .info{
        border-left:red 10px solid;
        width: 100%;
        height: calc(80px - 4px);
        display: flex;
        padding:5px;
        align-items: center;
    }
    .strip{
        height: 4px;
        width: 400px;
        background-color: red;

    }
}
</style>
