<template>
    <v-container fill-height>
        <v-layout align-center justify-center v-if="loading">
            <loader></loader>
        </v-layout>

        <v-container v-else>
            <v-row v-if="categories.length > 0">
                <v-subheader>Category count: {{ categories.length }} </v-subheader>
                <v-spacer></v-spacer>
                <v-btn @click="navigate('add_category')" outlined color="success">Add Category</v-btn>
                <v-col cols="12" sm="12">
                    <v-simple-table
                    fixed-header
                    height="500px">

                        <thead>
                            <tr>
                                <th class="text-start">
                                    Category ID
                                </th>
                                <th class="text-start">
                                    Image
                                </th>
                                <th class="text-start">
                                    Category
                                </th>
                                <th class="text-end">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr role="button" v-for="category in categories" :key="category.id">
                                <td> {{ category.id }} </td>
                                <td>
                                    <v-img :src="category.image_url" max-height="100px" max-width="100px"></v-img>
                                </td>
                                <td> {{ category.category }} </td>
                                <td>
                                    <v-btn @click="confirmDelete(category)" text color="error" class="float-right"><v-icon>delete</v-icon></v-btn>
                                    <v-btn @click="update(category)" text color="primary" class="float-right"><v-icon>edit</v-icon></v-btn>
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
                        <v-toolbar-title class="mb-6"><h3>No Categories yet?</h3></v-toolbar-title>
                        <v-btn @click="navigate('add_category')" block outlined color="success">Add Now</v-btn>
                    </v-col>
                </v-row>
            </v-container>

        </v-container>
    </v-container>
</template>

<script>

import Loader from '../../../components/Loader';
import {config} from '../../../config';

export default {

    components: {

        Loader,
    },

    data() {
        return {
            loading: false,
            config: config,
            categoryHeader: [
            {
                text: 'Category ID',
                value: 'id'
            },
            {
                text: 'Category',
                value: 'category'
            }
        ],
        }
    },

    computed: {
        categories() {
            let temp = this.$store.getters['categories/getCategories'];
            let categories = temp.map(t => {
                delete t.created_at;
                delete t.updated_at;
                return t;
            });
            return categories;
        },
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        update(category) {
            this.$router.push({name: 'update_category', params: { categoryId: category.id }});
        },

        confirmDelete(category) {
            this.$swal.fire({
                icon: 'warning',
                title: 'Delete Category',
                text: 'Are you sure you want to delete this category?',
                showCancelButton: true,
                cancelButtonColor: '#DC143C',
                confirmButtonText: 'Yes, Delete it!'
            })
            .then(result => {
                if(result.isConfirmed) {
                    this.deleteCategory(category);
                }
            });
        },

        deleteCategory(category) {
            this.loading = true;
            this.$store.dispatch('categories/deleteCategory', category.id)
                .then(() => {
                    this.$store.dispatch('categories/getCategories')
                        .then(() => {
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: 'The category has been deleted'
                            });
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Ooops...',
                                text: 'There is a problem while loading the categories.'
                            });
                            this.loading = false;
                        });
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Couldn\'t delete the category.'
                    });
                    this.loading = false;
                });

        }
    },

    mounted() {
        this.loading = true;
        this.$store.commit('interfaces/setPage', 'Categories');
        this.$store.dispatch('categories/getCategories')
            .then(response => {
                this.loading = false;
                console.log(response.data.categories);
            })
            .catch(error => {
                this.loading = false;
                console.log(error.response);
                alert('Error');
            });
    }
}
</script>

<style>
    .container {
        height: 89vh;
    }
</style>
