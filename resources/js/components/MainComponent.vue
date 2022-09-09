<template>
    <div class="main-content">
        <pizza-page @open-modal="showModal = true"></pizza-page>
    </div>
</template>

<script>

import Pizza from './pages/PizzaPage.vue';

export default{
    components: {
        'pizza-page': Pizza,
    },
    data() {
        return{
            showModal: false,
            confirmAction: false
        }
    },
    methods: {
        //
    }
}
</script>

<style>
    .main-content{
        background-color: white;
    }
</style>