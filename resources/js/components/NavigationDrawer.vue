<template>
    <v-navigation-drawer
    app
    permanent
    v-if="drawer"
    >
        <v-list>
            <v-list-item>
                <v-list-item-content class="">
                    <v-img src="https://cdn.shopify.com/s/files/1/0430/2330/2822/files/MGM_logo_no_bg_300x.png?v=1595995883"></v-img>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>

            <v-list-item @click="() => {}">
                <v-list-item-icon>
                    <v-icon>dashboard</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="() => {}">
                <v-list-item-icon>
                    <v-icon>category</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Categories</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item @click="() => {}">
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
    }
}
</script>
