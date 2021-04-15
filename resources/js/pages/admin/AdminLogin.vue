<template>
    <v-container>
        <v-row justify="center" class="mt-16">
            <div>
                <h1 class="mb-4 text-center">ADMIN LOGIN</h1>

                <v-alert v-if="hasError" type="error">
                    The email and password is incorrect
                </v-alert>

                <v-sheet
                color="white"
                elevation="3"
                width="500"
                class="py-9 px-6">

                    <v-text-field
                    outlined
                    label="Email"
                    prepend-inner-icon="account_circle"
                    placeholder="Please enter your email..."
                    class="mb-5"
                    v-model="user.email"
                    ></v-text-field>

                    <v-text-field
                    outlined
                    type="password"
                    label="Password"
                    prepend-inner-icon="lock"
                    placeholder="Please enter your password..."
                    class="mb-5"
                    v-model="user.password"
                    ></v-text-field>

                    <v-btn
                    :loading="loginLoader"
                    block
                    color="success"
                    class="text--white py-4 mb-3"
                    @click="login">
                        LOGIN
                    </v-btn>

                </v-sheet>
            </div>
        </v-row>
    </v-container>
</template>


<script>
export default {

    data() {
        return {
            loginLoader: false,
            hasError: false,
            user: {
                email: '',
                password: ''
            }
        }
    },

    methods: {

        login() {
            this.loginLoader = !this.loginLoader;
            this.$store.dispatch('users/adminLogin', this.user)
                .then(() => {
                    this.hasError = false;
                    this.loginLoader = !this.loginLoader;
                    const token = this.$store.getters['users/getToken'];
                    localStorage.setItem('token', token);
                    this.$router.replace({name: 'adminMain'});
                })
                .catch(error => {
                    console.log(error);
                    if(error.response.status == 401 || error.response.status == 422) {
                        this.hasError = true;
                        this.loginLoader = !this.loginLoader;
                    }
                });
        }

    }
}
</script>
