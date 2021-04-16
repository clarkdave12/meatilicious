<template>
    <v-container fluid class="pa-0">
        <navigation-drawer></navigation-drawer>
        <v-main>
            <navigation-bar></navigation-bar>
            <v-container fluid>
                <router-view></router-view>
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
