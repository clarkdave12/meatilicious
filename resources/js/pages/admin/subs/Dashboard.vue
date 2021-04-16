<template>
    <v-container>
        <h1>Dashboard Page</h1>
    </v-container>
</template>

<script>
export default {
    mounted() {
        this.$store.commit('interfaces/setPage', 'Dashboard');
    }
}
</script>
