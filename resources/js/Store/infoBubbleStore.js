
const infoBubbleModule = {
    state: () => {
        return {
            display_bubble: true,
            bubble_message: "this is the message"
        }
    },
    mutations: {
        display_info_bubble(state, payload) {
            state.display_bubble = true
            this.commit("animation_fade_our_bubble")
        },
        hide_info_bubble(state, payload) {
            state.display_bubble = true
        },
        animation_fade_our_bubble(callback){
            let elem = $('#info_bubble');
            let elem2 = elem.find('.strip');

            if(elem.length > 0){
                elem2.animate({
                    width:'10px'
                },3010)

                setTimeout(()=>{
                    elem.fadeOut('fast',() => {
                        this.commit('hide_info_bubble')
                        elem2.css('width','400px')
                    })
                },3000,)
            }

        }
    }
}

export default infoBubbleModule;
