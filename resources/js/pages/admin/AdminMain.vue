<template>
    <v-container fluid class="pa-0">
        <navigation-drawer></navigation-drawer>
        <v-main>
            <navigation-bar></navigation-bar>
            <v-container fluid>
                <h1>Admin Page</h1>
            </v-container>
        </v-main>
    </v-container>
</template>

<script>

import NavigationBar from '../../components/NavigationBar';
import NavigationDrawer from '../../components/NavigationDrawer';

export default {

    components: {
        NavigationBar,
        NavigationDrawer
    },

    mounted() {

    }

}
</script>
