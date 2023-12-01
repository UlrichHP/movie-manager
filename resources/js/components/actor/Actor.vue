<template>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-10 col-md-8 mx-auto">
                <h1 class="fw-light">{{ actor.name }}</h1>
            </div>
        </div>
    </section>

    <div class="py-5 bg-light">
        <div class="container">
            <p><strong>Date de naissance :</strong> {{ actor.birthday }}</p>
            <p><strong>Nationalité :</strong> {{ actor.nationality }}</p>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'

    const actor = ref([])

    const url = window.location.href
    const id = url.split('/').slice(-1)[0]

    const getResults = async () => {
        await axios
            .get(`/api/actors/${id}/show`)
            .then((res) => actor.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
