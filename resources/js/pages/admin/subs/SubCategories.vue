<template>
    <v-container fill-height>

        <v-layout align-center justify-center v-if="loading">
            <loader></loader>
        </v-layout>

        <v-container v-else>
            <v-row v-if="subCategories.length > 0">
                <v-subheader>Sub Category count: {{ subCategories.length }} </v-subheader>
                <v-spacer></v-spacer>
                <v-btn
                @click="navigate('add_sub_category')"
                outlined
                color="success">
                    Add Sub Category
                </v-btn>

                <v-col cols="12" sm="12">
                    <v-simple-table
                    fixed-header
                    height="500px">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Sub Category</th>
                                <th>Category</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="subCategory in subCategories" :key="subCategory.id" role="button">
                                <td> {{ subCategory.id }} </td>
                                <td>
                                    <v-img :src="subCategory.image_url" max-height="100px" max-width="100px"></v-img>
                                </td>
                                <td> {{ subCategory.name }} </td>
                                <td>{{ subCategory.category.name }}</td>
                                <td>
                                    <v-btn @click="confirmDelete(subCategory)" text color="error" class="float-right"><v-icon>delete</v-icon></v-btn>
                                    <v-btn
                                    @click="navigateParams('update_sub_category', subCategory.id)"
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
                    <v-col cols="12" sm="12" md="4" class="text-center">
                        <v-img
                        class="mx-auto"
                        :src="config.baseURL + '/images/defaults/meat.png'"
                        max-height="150px"
                        max-width="150px"></v-img>
                        <v-toolbar-title class="mb-6"><h3>No Sub Category yet?</h3></v-toolbar-title>
                        <v-btn @click="navigate('add_sub_category')" block outlined color="success">Add Now</v-btn>
                    </v-col>
                </v-row>
            </v-container>

        </v-container>



    </v-container>
</template>

<script>

import Loader from '../../../components/Loader';
import { config } from '../../../config';

export default {

    components: {
        Loader
    },

    data() {
        return {
            loading: false,
            config: config
        }
    },

    computed: {
        subCategories() {
            return this.$store.getters['subCategories/getSubCategories'];
        }
    },

    methods: {
        navigate(name) {
            this.$router.push({name: name});
        },

        navigateParams(name, params) {
            this.$router.push({name: name, params: { subCategoryId: params }});
        },

        confirmDelete(subCategory) {
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
                    this.deleteSubCategory(subCategory);
                }
            });
        },

        deleteSubCategory(subCategory) {
            this.loading = true;
            this.$store.dispatch('subCategories/deleteSubCategory', subCategory.id)
                .then(() => {
                    this.$store.dispatch('subCategories/getSubCategories')
                        .then(() => {
                            this.loading = false;
                            this.$swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: 'The sub category was deleted'
                            });
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was a problem while fetching the sub categories'
                            });
                            this.loading = false;
                        })
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was a problem while deleting the sub category'
                    });
                    this.loading = false;
                });
        }
    },

    mounted() {
        this.loading = true;
        this.$store.commit('interfaces/setPage', 'Sub Categories')
        this.$store.dispatch('subCategories/getSubCategories')
            .then(() => {
                this.loading = false;
                let subs = this.$store.getters['subCategories/getSubCategories'];
                console.log(subs);
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was a problem while fetching the sub catgories'
                });
                this.loading = false;
            })
    }
}
</script>
