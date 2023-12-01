<template>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-10 col-md-8 mx-auto">
                <h1 class="fw-light">{{ genre.name }}</h1>
            </div>
        </div>
    </section>
</template>

<script setup>
    import { ref } from 'vue'

    const genre = ref([])

    const url = window.location.href
    const id = url.split('/').slice(-1)[0]

    const getResults = async () => {
        await axios
            .get(`/api/genres/${id}/show`)
            .then((res) => genre.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
