<template>
    <div class="main-content">
        <pizza-page></pizza-page>
    </div>
</template>

<script>
import Pizza from './pages/PizzaPage.vue'

export default{
    components: {
        'pizza-page': Pizza
    },
    data() {
        return{
            //
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