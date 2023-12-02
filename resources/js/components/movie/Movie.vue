<template>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-10 col-md-8 mx-auto">
                <h1 class="fw-light">{{ movie.title }}</h1>
            </div>
        </div>
    </section>

    <div class="py-5 bg-light">
        <div class="container">
            <p><strong>Année :</strong> {{ movie.year }}</p>
            <p><strong>Durée :</strong> {{ movie.duration }}</p>
            <p><strong>Genre(s) : </strong>
                <template v-for="(genre, index) in movie.genres">
                    {{ genre.name }}
                    <span v-if="index !== movie.genres.length - 1">, </span>
                </template>
            </p>
            <p><strong>Acteur(s) : </strong>
                <template v-for="(genre, index) in movie.actors">
                    {{ genre.name }}
                    <span v-if="index !== movie.actors.length - 1">, </span>
                </template>
            </p>
            <p>{{ movie.description }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ref } from 'vue'
    import { MovieType } from '../../types/MovieType';

    const movie = ref<MovieType|[]>([])

    const url = window.location.href
    const id = url.split('/').slice(-1)[0]

    const getResults = async () => {
        await axios
            .get(`/api/movies/${id}/show`)
            .then((res) => movie.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
