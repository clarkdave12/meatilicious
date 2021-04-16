<template>
    <v-container>
        <h1>Products Page</h1>
    </v-container>
</template>

<script>
export default {

    mounted() {
        this.$store.commit('interfaces/setPage', 'Products');
    }

}
</script>
