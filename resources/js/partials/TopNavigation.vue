<template>
    <section id="dashboard-navigation">
        <div class="search-section">
            <div class="input-section">
                <p>Welcome, {{username.username}}</p>
            </div>
            <div class="helper-section">

            </div>
        </div>
        <div class="account-action-section">
            <Link :href="'/users/'+username.id" class="icon-section rep-btn">
                <img title="account" src="/storage/icons/user.png" alt="">
            </Link>
            <Link as="div" class="icon-section rep-btn" :href="'/'">
                <img title="Home page" src="/storage/icons/home.png" alt="">
            </Link>
            <div class="icon-section rep-btn" @click="logout">
                <img title="log out" src="/storage/icons/logout.png" alt="">
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name: 'top-navigation',
    props:['username'],
    methods:{
        logout(){
            axios.post('/logout')
                .then(
                    window.location.href = '/'
            );
        }
    }
}
</script>
<style lang="scss">

#dashboard-navigation{
  margin-bottom: 15px;
  top: 0px;
  position: sticky;
  z-index: 1000;
  background-color: white;
}
</style>
