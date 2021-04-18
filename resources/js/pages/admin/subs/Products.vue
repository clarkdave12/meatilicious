<template>
    <v-container fill-height>

        <v-layout align-center justify-center v-if="loading">
            <loader></loader>
        </v-layout>

        <v-container v-else>
            <v-row v-if="products.length > 0">
                <v-subheader>Products count: {{ products.length }}</v-subheader>
                <v-spacer></v-spacer>
                <v-btn
                @click="navigate('add_product')"
                outlined
                color="success">Add Prodduct</v-btn>

                <v-col cols="12" sm="12">
                    <v-simple-table
                    fixed-header
                    height="500px">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price(s)</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="button" v-for="product in products" :key="product.id">
                                <td> {{ product.id }} </td>
                                <td>
                                    <v-img v-if="product.images.length > 0" :src="product.images[0].image_url"
                                    max-height="75px" max-width="75px"></v-img>
                                </td>
                                <td>Product 1</td>
                                <td>
                                    <v-row>
                                        <td
                                        v-for="p in product.prices"
                                        :key="p.id"
                                        class="mr-1">
                                            {{p.price}} / {{p.per > 1 ? p.per : ''}} <span> {{ p.unit.name }}, </span>
                                        </td>
                                    </v-row>
                                </td>
                                <td>
                                    <v-btn @click="confirmDelete(product)" text color="error" class="float-right"><v-icon>delete</v-icon></v-btn>
                                    <v-btn
                                    @click="navigateParams('update_product', product.id)"
                                    text
                                    color="primary"
                                    class="float-right"><v-icon>edit</v-icon></v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                </v-col>
            </v-row>

            <v-container v-else>
                <v-row justify="center">
                    <v-col cols="4" class="text-center">
                        <v-img
                        class="mx-auto"
                        :src="config.baseURL + '/images/defaults/meat.png'"
                        max-height="150px"
                        max-width="150px"></v-img>
                        <v-toolbar-title class="mb-6"><h3>No product yet?</h3></v-toolbar-title>
                        <v-btn @click="navigate('add_product')" block outlined color="success">Add Now</v-btn>
                    </v-col>
                </v-row>
            </v-container>

        </v-container>

    </v-container>
</template>

<script>
import {config} from '../../../config';
import Loader from '../../../components/Loader';
export default {

    components: {
        Loader,
    },

    data() {
        return {
            loading: false,
            config
        }
    },

    computed: {
        products() {
            return this.$store.getters['products/getProducts'];
        }
    },

    methods: {

        navigate(name) {
            this.$router.push({name: name});
        },

        navigateParams(name, params) {
            this.$router.push({name: name, params: { productId: params }});
        },

        confirmDelete(product) {
            this.$swal.fire({
                icon: 'warning',
                title: 'Are you sure to delete ?',
                text: 'You won\'t be able to revert this action',
                showCancelButton: true,
                cancelButtonColor: '#DC143C',
                confirmButtonText: 'Yes, Delete it!'
            })
            .then(result => {
                if(result.isConfirmed) {
                    this.deleteProduct(product);
                }
            });
        },

        deleteProduct(product) {
            this.loading = true;
            this.$store.dispatch('products/deleteProduct', product.id)
                .then(() => {
                    this.$store.dispatch('products/getProducts')
                        .then(() => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The product was deleted!'
                            });
                            this.loading = false;
                        })
                        .catch(error => {
                            his.$swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was a problem loading the products'
                            });
                            console.log(error.response);
                            this.loading = false;
                        });
                })
                .catch(error => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem deleting the product'
                    });
                    console.log(error.response);
                    this.loading = false;
                })
        }

    },

    mounted() {
        this.loading = true;
        this.$store.commit('interfaces/setPage', 'Products');

        this.$store.dispatch('products/getProducts')
            .then(() => {
                this.loading = false;
            })
            .catch(error => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was a problem while loading the products'
                });
                console.log(error);
                console.log(error.response);
                this.loading = false;
            });

    }

}
</script>
