<template>
    <div class="container">
        <section class="mb-3">
            <div class="form-check form-check-inline">
                <input v-model.trim="searchInput"  @keyup="getResults()" class="form-control" type="text" placeholder="Votre recherche">
            </div>
        </section>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-3">
            <div class="col" v-for="movie in movies.data" :key="movie.id">
                <MovieCard :movie="movie" />
            </div>
        </div>

        <Bootstrap5Pagination
            :data="movies"
            @pagination-change-page="getResults"
            align="center"
        />
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Bootstrap5Pagination } from 'laravel-vue-pagination'
    import MovieCard from './MovieCard.vue';

    const movies = ref([])
    const searchInput = ref('')

    const getResults = async (page = 1) => {
        const params = {
            page,
        }

        if (searchInput.value.length > 0) {
            params.title = searchInput.value
        }

        await axios
            .get('/api/movies', {
                params
            })
            .then((res) => movies.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
