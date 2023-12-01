<template>
    <section class="d-flex flex-wrap align-items-center text-center py-5">
        <form class="p-15 m-auto w-100" style="max-width: 330px;">
            <h1 class="h3 mb-3 fw-normal">Se connecter</h1>

            <div class="form-floating">
                <input v-model="formData.email" type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''" placeholder="john.doe@gmail.com" style="margin-bottom: -1px; border-bottom-right-radius: 0; border-bottom-left-radius: 0;">
                <label for="floatingInput">Email</label>

                <template v-if="errors.email">
                    <div class="invalid-feedback">{{ errors.email[0] }}</div>
                </template>
            </div>
            <div class="form-floating">
                <input v-model="formData.password" type="password" class="form-control" :class="errors.password ? 'is-invalid' : ''" id="floatingPassword" placeholder="Mot de passe" style="margin-bottom: 10px; border-top-left-radius: 0; border-top-right-radius: 0;">
                <label for="floatingPassword">Mot de passe</label>

                <template v-if="errors.password">
                    <div class="invalid-feedback">{{ errors.password[0] }}</div>
                </template>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" @click.prevent="logInUser">Se connecter</button>
        </form>
    </section>
</template>

<script setup>
    import { ref } from 'vue'

    const errors = ref({})
    const formData = ref({
        email: '',
        password: '',
    })

    const logInUser = () => {
        axios
            .post('/api/login', formData.value)
            .then((res) => {
                errors.value = {}
                window.location.href = '/'
            })
            .catch((err) => errors.value = err.response.data.errors)
    }
</script>
