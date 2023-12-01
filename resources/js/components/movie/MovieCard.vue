<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ year + ' | ' + duration }}</small>
                <div class="btn-group">
                    <a :href="'/movies/' + id " type="button" class="btn btn-sm btn-outline-secondary">Voir</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    defineProps([
        'id',
        'title',
        'description',
        'year',
        'duration',
    ])
</script>
