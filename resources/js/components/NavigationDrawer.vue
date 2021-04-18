<template>
    <v-navigation-drawer
    app
    permanent
    v-if="drawer"
    >
        <v-list>
            <v-list-item>
                <v-list-item-content class="">
                    <v-img src="http://localhost:8000/images/defaults/logo.png"></v-img>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>

            <v-list-item @click="navigate('dashboard')">
                <v-list-item-icon>
                    <v-icon>dashboard</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="navigate('categories')">
                <v-list-item-icon>
                    <v-icon>folder</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Categories</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="navigate('sub_categories')">
                <v-list-item-icon>
                    <v-icon>category</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Sub Categories</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="navigate('products')">
                <v-list-item-icon>
                    <v-icon>inventory</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Products</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="() => {}">
                <v-list-item-icon>
                    <v-icon>shopping_bag</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Orders</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="() => {}">
                <v-list-item-icon>
                    <v-icon>person</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Users</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

    </v-navigation-drawer>
</template>

<script>
export default {
    computed: {
        drawer() {
            return this.$store.getters['interfaces/getDrawer'];
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        }
    }
}
</script>
