<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ movie.title }}</h5>
            <p class="card-text">{{ movie.description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ movie.year + ' | ' + movie.duration }}</small>
                <div class="btn-group">
                    <a :href="'/movies/' + movie.id " type="button" class="btn btn-sm btn-outline-secondary">Voir</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { MovieType } from '../../types/MovieType'

    defineProps<{
        movie: MovieType,
    }>()
</script>
