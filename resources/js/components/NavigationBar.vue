<template>
    <v-app-bar>
            <v-app-bar-nav-icon @click="toggle">
                <v-icon>menu</v-icon>
            </v-app-bar-nav-icon>
            <v-spacer class="hidden-md-and-up"></v-spacer>
            <v-toolbar-title class="hidden-sm-and-down">
                <h3> {{ pageTitle }} </h3>
            </v-toolbar-title>
            <v-toolbar-title class="hidden-md-and-up">
                {{ pageTitle }}
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">

                    <v-btn
                    class="hidden-sm-and-down"
                    text
                    v-bind="attrs"
                    v-on="on">
                        <v-icon left>account_circle</v-icon>
                        {{ user.name }}
                    </v-btn>

                    <v-btn
                    class="hidden-md-and-up"
                    text
                    v-bind="attrs"
                    v-on="on">
                        <v-icon>more_vert</v-icon>
                    </v-btn>

                </template>
                <v-list>
                    <v-list-item @click="() => {}">
                        <v-list-item-title> <v-icon left>person</v-icon> Account </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="() => {}">
                        <v-list-item-title> <v-icon left>settings</v-icon> Settings </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="logout">
                        <v-list-item-title> <v-icon left>logout</v-icon> Logout </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

        </v-app-bar>
</template>

<script>
export default {

    data() {
        return {
            user: {}
        }
    },

    computed: {
        pageTitle() {
            return this.$store.getters['interfaces/getPage'];
        }
    },

    methods: {
        toggle() {
            this.$store.commit('interfaces/setDrawer');
        },

        logout() {
            localStorage.removeItem('token');
            this.$router.replace({name: 'adminLogin'});
        }
    },

    mounted() {
        this.user = this.$store.getters['users/getUser'];
        console.log(this.user);
    }

}
</script>
