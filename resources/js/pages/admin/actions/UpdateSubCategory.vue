<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Update Sub Category</v-toolbar-title>

                <v-text-field
                v-model="subCategory.name"
                class="mb-4"
                outlined
                dense
                label="Sub Category"
                placeholder="Please enter sub category name"></v-text-field>

                <v-combobox
                v-model="selected"
                :items="displayCategories"
                outlined
                dense
                label="Category"
                placeholder="Please select category"></v-combobox>

                <v-file-input
                @change="imageChange"
                class="mb-4"
                outlined
                dense
                prepend-icon="add_photo_alternate"
                label="Image"
                placeholder="Please upload image for category"></v-file-input>

                <v-row class="mb-5">
                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="navigate('sub_categories')"
                        outlined
                        block
                        color="secondary">Cancel</v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" md="6">
                        <v-btn
                        @click="updateCategory"
                        block
                        :disabled="saveButton"
                        :loading="saveButton"
                        color="success">Save</v-btn>
                </v-col>

                </v-row>

            </v-sheet>
        </v-row>
    </v-container>
</template>

<script>
export default {

    data() {
        return {
            saveButton: false,
            subCategory: {
                name: '',
                category_id: '',
                image: ''
            },
            categories: [],
            selected: ''
        }
    },

    computed: {
        displayCategories() {
            return this.categories.map(cat => {
                return cat.name;
            });
        },

        getSelectedCategory() {
            let category = {};

            this.categories.map(cat => {
                if(this.selected == cat.name) {
                    category = cat;
                }
            });

            return category;
        }
    },

    methods: {

        navigate(name) {
            this.$router.push({name: name});
        },

        imageChange(e) {

            const fileReader = new FileReader();
            fileReader.readAsDataURL(e);

            fileReader.onload = (ev) => {
                this.subCategory.image = ev.target.result;
            }
        },

        updateCategory() {
            this.saveButton = true;
            this.subCategory.category_id = this.getSelectedCategory.id;
            let payload = {
                id: this.$route.params.subCategoryId,
                data: this.subCategory
            }

            this.$store.dispatch('subCategories/updateSubCategory', payload)
                .then(() => {
                    this.saveButton = false;

                    this.$swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'The sub category was updated'
                    });

                    this.navigate('sub_categories');
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not updated the sub category'
                    });
                    this.saveButton = false;
                });
        }

    },

    mounted() {

        this.$store.commit('interfaces/setPage', 'Update Sub Category');

        let id = this.$route.params.subCategoryId;
        this.$store.dispatch('subCategories/getSubCategory', id)
            .then(() => {
                this.subCategory = this.$store.getters['subCategories/getSubCategory'];
                this.selected = this.subCategory.category.name;
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was a problem while fetching sub category data'
                });
            });

        this.$store.dispatch('categories/getCategories')
            .then(() => {
                this.categories = this.$store.getters['categories/getCategories'];
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was a problem while fetching categories'
                });
            });
    }

}
</script>
