<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <v-sheet
            elevation="3"
            width="500px"
            class="px-9 pt-5">

                <v-toolbar-title class="text-center mb-9">Add Sub Category</v-toolbar-title>

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
                        @click="saveSubCategory"
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
            selected: '',
            categories: [],
            subCategory: {
                name: '',
                category_id: '',
                'image': ''
            }
        }
    },

    computed: {
        displayCategories() {
            return this.categories.map(category => {
                return category.name;
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

        saveSubCategory() {
            this.saveButton = true;
            this.subCategory.category_id = this.getSelectedCategory.id;

            this.$store.dispatch('subCategories/addSubCategory', this.subCategory)
                .then(response => {
                    console.log(response);

                    this.$swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sub Category created'
                    });
                    this.saveButton = false;
                    this.navigate('sub_categories');
                })
                .catch(error => {
                    console.log(error.response);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not add sub category'
                    });
                    this.saveButton = false;
                });
        }
    },

    mounted() {

        this.$store.commit('interfaces/setPage', 'New Sub Category');

        this.$store.dispatch('categories/getCategories')
            .then(() => {
                this.categories = this.$store.getters['categories/getCategories'];
                console.log(this.categories);
            })
            .catch(error => {
                console.log(error.response);
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Could not fetch the categories'
                });
            });
    }

}
</script>
