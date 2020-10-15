<template>
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Sign In</h3>
            <div class="login-form">
                <ValidationObserver v-slot="{ handleSubmit }">
                    <form @submit.prevent="handleSubmit(login)">
                        <div class="form-group form-floating-label">
                            <ValidationProvider
                                name="Email"
                                rules="required"
                                mode="eager"
                                :customMessages="{
                                    required: 'Email is required',
                                    email: 'Email is not valid'
                                }"
                                v-slot="{ errors }"
                            >
                                <span
                                    v-if="errors[0]"
                                    class="my-2 flex justify-end text-xs text-red-600 font-bold"
                                >
                                    {{ errors[0] }}
                                </span>

                                <input
                                    v-model="u_email"
                                    id="u_email"
                                    name="u_email"
                                    type="email"
                                    class="form-control input-border-bottom"
                                />

                                <label for="username" class="placeholder"
                                    >Email</label
                                >
                            </ValidationProvider>
                        </div>

                        <div class="form-group form-floating-label">
                            <ValidationProvider
                                name="Password"
                                rules="required"
                                mode="eager"
                                :customMessages="{
                                    required: 'Password is required'
                                }"
                                v-slot="{ errors }"
                            >
                                <span
                                    v-if="errors[0]"
                                    class="my-2 flex justify-end text-xs text-red-600 font-bold"
                                >
                                    Password is required
                                </span>

                                <input
                                    v-model="u_password"
                                    id="u_password"
                                    name="u_password"
                                    type="password"
                                    class="form-control input-border-bottom"
                                />

                                <label for="password" class="placeholder"
                                    >Password</label
                                >
                            </ValidationProvider>
                        </div>

                        <div class="form-action mb-3">
                            <button
                                class="btn btn-primary btn-rounded btn-login"
                            >
                                Go
                            </button>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            u_email: "",
            u_password: "",
            successURL: "http://board.test:85"
        };
    },
    methods: {
        login() {
            axios
                .get("/sanctum/csrf-cookie")
                .then(response => {
                    axios
                        .post("/api/login", {
                            u_email: this.u_email,
                            u_password: this.u_password
                        })
                        .then(response => {
                            window.location = this.successURL;
                        })
                        .catch(error => {
                            this.$toasted.global.failNotification({
                                message:
                                    "Credentials does not match our records"
                            });
                        });
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>
