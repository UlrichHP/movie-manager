<template>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-3">
            <div class="col" v-for="genre in genres.data" :key="genre.id">
                <MovieCard :genre="genre" />
            </div>
        </div>

        <Bootstrap5Pagination
            :data="genres"
            @pagination-change-page="getResults"
            align="center"
        />
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Bootstrap5Pagination } from 'laravel-vue-pagination'
    import MovieCard from './GenreCard.vue';

    const genres = ref([])

    const getResults = async (page = 1) => {
        await axios
            .get('/api/genres', {
                params: {
                    page,
                }
            })
            .then((res) => genres.value = res.data.data)
            .catch((err) => console.log(err))
    }

    getResults()
</script>
